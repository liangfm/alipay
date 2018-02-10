<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016091200495132",

		//商户私钥
		'merchant_private_key' => "MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDg/mOLr1Qs3/0+ xMrQOi/167MsarKjnMpQmcEdDMF85W9Mi4KBor3l7MqiGDMuoF2wwwYCE+QsJwWU mkgqJyzV21czqt8OAAaDKtkUPVBo/sZE3lerxYr8ob6ADkb+G3nDmS7rHSBHePm9 pXdG65Ob5TYdO2V4ajSfanwWaQEAGejg5oTywL4+LJxwMvf1IYHGyebEw1/W8SWB a00Mu5K0XvG0fYDJ++Yy3lOF04UgeTpukZRTz7pvigbXaak1H8tJSaBF9pUCaBqX v/znWejVe0bipFAfIbZfCPOqML69a5eD71b/bRsOzZzDyfLcyvxRqIzsZsibY4kw J6gmbDsRAgMBAAECggEAIrD2tl4FU5oB2UDMqMigBoIeMVYOT03on/7lGM6TsudJ fvrv1385Wo9lOxMSKTlO2OdpML7SasBliuEzCVTbA+p7CptpIyZ72pOrvwQpNtc5 yPqjd/fQk115GxOYfKvN3YvsARKPnJWZpFU0C/pc2ye/bUhwP93YWVA469eq8NHD 4lxXZzU/HjlYqgCQHKY9qezqmT8onO/4gZBJzSAkAXNex2lpEbL4ym/3owII6RZI hCnOb3uxPLRE5w42bIAUCq0s9N6HCriNF64RSOFnumuk0y42xjD8ogTvFeD1dXad QCxRjFz9IpF5uGgRbaR5GHtVy1z1ASvYe+2UO2eQAQKBgQD0AQHKdvoltrxE371F 1W8/NZuPUcefs/8btWi/0lDJEY/Y0oNaLO+rN1kTGrXiADJFMyhvzGgTkxUw0Gta D4Iq0I8dkq7aTmETiR/KxAi8QxAP2hY3kQ6KAd4aLkuiGBAgpJye1rI/OVbg3NLi L320S14gcbo1kvABUYO/QNnxAQKBgQDsDh9OfwCGwgzIRDLcoP35s8xCq9BOaOc1 nHaY8oVPGxXS6m8Ukqjoovv9fJRHQw5LvIErYxkZIfxBllSIsA2j2OQRTeGcOFtx 9fJHZP2bcBtumGaGfoaf7/0k9WvHYueElVvYvyZJngR+5qQgNsq97hx1/LHIqW1i ILWwrlk6EQKBgQDBQebsOC3KHyCgoGEl5XV2J/xsmEY2zHaauKUdgPNxPZKkFZ/p lTvCbVUEl5xFQwiN3IYDfm9USaN4BStxqmTbilJABwSsbXXf5jSjAX81tRwMohwE qMRONEp4jABlgw+K+zX9bGjDQKP594yjjx/N4//KTKlCc33aXXiuyyuTAQKBgQDX tVAGeygP/OORXkDcPIHZ3OObSUZhYJtn8kKuIXCQiT+4LWK0ehDABbAgQ+d791ro +qlO7I/S16ucg7Nb9QWB5IEFDxZLm3R0/zsW4sKdeCSZO8r0vEppfPTnAR4sZcUK 8zGrL4HdY/jXvgvdJDTAuwZnCzOrGqhKM3nUqn3/AQKBgERyo6AmgjcPXR5CmRwF vT+DJKzygFiHQdqGN7azCkqgBhYwIqfCxHMGeBAnBji9C+pSGXLd7cbHGYq0hoRx fMRmj+CrUHsofdENtrqr1REWUrgh2rWNqPyr9ro5U1v3a3v5fJjEkNfkMwE2ScwE BLD0nIse6voQ/PfO9TS48eoy",
		
		//异步通知地址
		'notify_url' => "http://shop.mylawcase.cn/modules/alipay/alipay-sdk/notify_url.php",
		
		//同步跳转
		'return_url' => "http://shop.mylawcase.cn/modules/alipay/alipay-sdk/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEArWbbt68vakXPOQYY7/oyGWfaoQrlRqR06aA0q41z7LodHVpTHXnH1WB+4ktmqazk0BNE33Z/iZGfqH88KioBBmJn78gxZ1c46vUgeaG3HjmHuwBkveL7H71kp72vOyGBm9pH1ULhU80/BDs4DM1+gQvuotQ8ZcHHq6hzZmyN0YvudQ4nacBBhvdHSCbySDtppTE6NdzeGhcab6MGpNbmZd3iv1Z5ljFaesKU5rjM3j/V9+wQK8Y40iYF4IcuRQgoSz7DKK6gI2axarLOALjzy3vtHAQPEnNtejTetYXiif97HfooabpI5HbeWfvBvdf8ZNcN8pCfKmynVY/hvtmmiwIDAQAB"
);
