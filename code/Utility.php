<?php
 	function GenerateRandomString()
	{
		$length = 15;
		$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
		return $randomString;
	}
	
//$encrypted = aes128ctr_en('the bomb will blow up at 1 pm','ajinkya',12345);
//aes128ctr_de($encrypted,'ajinkya',12345);

	
function aes128ctr_en($data,$key,$hash_rounds = 0) 
{
//iv is created
$iv = mcrypt_create_iv(16,MCRYPT_DEV_URANDOM);
//internal secret random string is created so no one knows what
//is exactly encoded by main cipher
$xtea = mcrypt_create_iv(16,MCRYPT_DEV_URANDOM);
//password is hashed in many rounds to prevent dictionary attack,
//hashing is done with individual iv for hmac so it makes no sense to use
//precalculated hashes
for($i=0;$i<=$hash_rounds;++$i) $key = hash_hmac('sha256',$key,$iv,true);
//string is randomized for use in aes, so no one knows what actually will be encoded
//this is not actual encoding so password is stored inside with xtea encoded string,
//second half of this password is used as IV for xtea
//again: THIS IS NOT ACTUAL ENCODING
$data = $xtea.mcrypt_encrypt('xtea',$xtea,$data,'ofb',substr($xtea,8));
//hash is added to check if return string is really what we looked for,
//must match with string on decoding
$data = hash('md5',$data,true).$data;
//actual encoding, IV is prepended to encrypted string
return $iv.mcrypt_encrypt('rijndael-128',$key,$data,'ctr',$iv);
}

function aes128ctr_de($data,$key,$hash_rounds = 0) 
{
 $iv = substr($data,0,16);
 $data = substr($data,16);

 for($i=0;$i<=$hash_rounds;++$i) $key = hash_hmac('sha256',$key,$iv,true);

 $data = mcrypt_decrypt('rijndael-128',$key,$data,'ctr',$iv);
 $md5 = substr($data,0,16);
 $data = substr($data,16); 
 if (hash('md5',$data,true)!==$md5) return false;
 $xtea = substr($data,0,16);
 $data = substr($data,16);
 return mcrypt_decrypt('xtea',$xtea,$data,'ofb',substr($xtea,8));
}

	function GenerateHashedString($input)
	{
		//Generates the hashed value of a string and returns its value
		//$6 --> Algorithm prefix
		//$rounds --> nº of times the algorithm is going to be looping
		//$SillyString -->string used for encryption.
		$hashed = crypt($input,'$6$rounds=8000$Pikachu3Dabai4$');
		
		//this will return the generated key
		return substr($hashed,30);
	}

?>
