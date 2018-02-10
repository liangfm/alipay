
<?php
//data you want to sign
$data = '{isdelet:1,name:123,age:231}';
$priKey='MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDg/mOLr1Qs3/0+ xMrQOi/167MsarKjnMpQmcEdDMF85W9Mi4KBor3l7MqiGDMuoF2wwwYCE+QsJwWU mkgqJyzV21czqt8OAAaDKtkUPVBo/sZE3lerxYr8ob6ADkb+G3nDmS7rHSBHePm9 pXdG65Ob5TYdO2V4ajSfanwWaQEAGejg5oTywL4+LJxwMvf1IYHGyebEw1/W8SWB a00Mu5K0XvG0fYDJ++Yy3lOF04UgeTpukZRTz7pvigbXaak1H8tJSaBF9pUCaBqX v/znWejVe0bipFAfIbZfCPOqML69a5eD71b/bRsOzZzDyfLcyvxRqIzsZsibY4kw J6gmbDsRAgMBAAECggEAIrD2tl4FU5oB2UDMqMigBoIeMVYOT03on/7lGM6TsudJ fvrv1385Wo9lOxMSKTlO2OdpML7SasBliuEzCVTbA+p7CptpIyZ72pOrvwQpNtc5 yPqjd/fQk115GxOYfKvN3YvsARKPnJWZpFU0C/pc2ye/bUhwP93YWVA469eq8NHD 4lxXZzU/HjlYqgCQHKY9qezqmT8onO/4gZBJzSAkAXNex2lpEbL4ym/3owII6RZI hCnOb3uxPLRE5w42bIAUCq0s9N6HCriNF64RSOFnumuk0y42xjD8ogTvFeD1dXad QCxRjFz9IpF5uGgRbaR5GHtVy1z1ASvYe+2UO2eQAQKBgQD0AQHKdvoltrxE371F 1W8/NZuPUcefs/8btWi/0lDJEY/Y0oNaLO+rN1kTGrXiADJFMyhvzGgTkxUw0Gta D4Iq0I8dkq7aTmETiR/KxAi8QxAP2hY3kQ6KAd4aLkuiGBAgpJye1rI/OVbg3NLi L320S14gcbo1kvABUYO/QNnxAQKBgQDsDh9OfwCGwgzIRDLcoP35s8xCq9BOaOc1 nHaY8oVPGxXS6m8Ukqjoovv9fJRHQw5LvIErYxkZIfxBllSIsA2j2OQRTeGcOFtx 9fJHZP2bcBtumGaGfoaf7/0k9WvHYueElVvYvyZJngR+5qQgNsq97hx1/LHIqW1i ILWwrlk6EQKBgQDBQebsOC3KHyCgoGEl5XV2J/xsmEY2zHaauKUdgPNxPZKkFZ/p lTvCbVUEl5xFQwiN3IYDfm9USaN4BStxqmTbilJABwSsbXXf5jSjAX81tRwMohwE qMRONEp4jABlgw+K+zX9bGjDQKP594yjjx/N4//KTKlCc33aXXiuyyuTAQKBgQDX tVAGeygP/OORXkDcPIHZ3OObSUZhYJtn8kKuIXCQiT+4LWK0ehDABbAgQ+d791ro +qlO7I/S16ucg7Nb9QWB5IEFDxZLm3R0/zsW4sKdeCSZO8r0vEppfPTnAR4sZcUK 8zGrL4HdY/jXvgvdJDTAuwZnCzOrGqhKM3nUqn3/AQKBgERyo6AmgjcPXR5CmRwF vT+DJKzygFiHQdqGN7azCkqgBhYwIqfCxHMGeBAnBji9C+pSGXLd7cbHGYq0hoRx fMRmj+CrUHsofdENtrqr1REWUrgh2rWNqPyr9ro5U1v3a3v5fJjEkNfkMwE2ScwE BLD0nIse6voQ/PfO9TS48eoy';
//create new private and public key
$new_key_pair = openssl_pkey_new(array(
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
));
openssl_pkey_export($new_key_pair, $private_key_pem);

$details = openssl_pkey_get_details($new_key_pair);
$public_key_pem = $details['key'];
$res = "-----BEGIN RSA PRIVATE KEY-----\n" .
	  wordwrap($priKey, 64, "\n", true) .
	"\n-----END RSA PRIVATE KEY-----";
//var_dump($private_key_pem);
//create signature
$ret=openssl_sign($data, $signature, $res, OPENSSL_ALGO_SHA256);
var_dump($ret);
var_dump(base64_encode($signature));
//save for later
//file_put_contents('private_key.pem', $private_key_pem);
//file_put_contents('public_key.pem', $public_key_pem);
//file_put_contents('signature.dat', $signature);
$puc_key2='MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA4P5ji69ULN/9PsTK0Dov 9euzLGqyo5zKUJnBHQzBfOVvTIuCgaK95ezKohgzLqBdsMMGAhPkLCcFlJpIKics 1dtXM6rfDgAGgyrZFD1QaP7GRN5Xq8WK/KG+gA5G/ht5w5ku6x0gR3j5vaV3RuuT m+U2HTtleGo0n2p8FmkBABno4OaE8sC+PiyccDL39SGBxsnmxMNf1vElgWtNDLuS tF7xtH2AyfvmMt5ThdOFIHk6bpGUU8+6b4oG12mpNR/LSUmgRfaVAmgal7/851no 1XtG4qRQHyG2XwjzqjC+vWuXg+9W/20bDs2cw8ny3Mr8UaiM7GbIm2OJMCeoJmw7 EQIDAQAB';
$puc_key= "-----BEGIN PUBLIC KEY-----\n" .
	  	   wordwrap($puc_key2, 64, "\n", true) .
	      "\n-----END PUBLIC KEY-----";

 $ret=openssl_verify($data, $signature, $puc_key, OPENSSL_ALGO_SHA256);
var_dump('verify: '.$ret);

//verify signature
//$r = openssl_verify($data, $signature, $public_key_pem, "sha256WithRSAEncryption");
//var_dump('=======================================');
//var_dump($public_key_pem);
?>
