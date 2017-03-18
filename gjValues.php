<?php
require_once('gdps.php');

if (!function_exists('decodeGJP')) {
	function decodeGJP($password) {
		$key = text2ascii(37526);
		$plaintext = text2ascii(base64_decode($password));
		$keysize = count($key);
		$input_size = count($plaintext);
		$cipher = "";

		for ($i = 0; $i < $input_size; $i++)
			$cipher .= chr($plaintext[$i] ^ $key[$i % $keysize]);

		return $cipher;
	}
}

if (!function_exists('encodeLP')) {
	function encodeLP($password) {
		$key = text2ascii(26364);
		$plaintext = text2ascii($password);
		$keysize = count($key);
		$input_size = count($plaintext);
		$cipher = "";

		for ($i = 0; $i < $input_size; $i++)
			$cipher .= chr($plaintext[$i] ^ $key[$i % $keysize]);

		return base64_encode($cipher);
	}
}
?>
