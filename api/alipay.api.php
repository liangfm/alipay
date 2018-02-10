<?php
/**
 * 2007-2015 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2015 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

/**
 * Class AlipayApi
 */
class AlipayApi
{
    private $private_key='MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCyr+FyKi2Gc8xCVdsCO4Ib5pk/WkzjLYDnXCiPH+vGxjhYGKSOfQEKX9kkk7tBAl56lRkRITm0P/pxkuqLuz01To+7/Q332dNkmK1vMio8eIwWJV1QkOMM1w13HeQIbnSa/Re1ENWlrSawjt0npPgtGGqDpHPHgsX2esRtTDeaTyKHof4Xk+vO+bCHnLEh/rnegE+9aSApPg15YDrVKfDgTinwsQdQUB62q+JsH7Eit1sQeuN1HUpWeVue6jjNtDQM3zy0PP3eUpzxokfXO5q82YYsw1V/zXvZOu2wK1bpXn0mPNdbZAQpWTVKjK2e/Iq28cJROJkEvLUfB9XSdApnAgMBAAECggEARscB7r2kMLiXdMMbL+QwYirSEtUK1YWFpJ7Ndfu34ZFMaiDAtavwCJL0qNdXeaWdlMKQHkfh2nLpGamO+/Abi4zlxBm1ObJvWE5djEj7j95T5sXAE5SASuq367HMTEasK2QKyu6zIZ/XTmIYWYavwvUD48b1EVbMYRg5y+0/rP/3pIIMEoh/0s7cT7diSbhfKMLX2/Dl0wTZ3BUFPw23IDKwX2RqJa8Sp1uUs4lEeu4BWM9drVX0ObdNEj8zlDFPm+TEAy3O0cdMociJuTdTTxl8OP789conTXiCpwsyCQxVyxSOxJudg9Plnl4rXyIKqtdj93GRWT7ugIWRqRncMQKBgQDkx8CBwSjwXn2mg4scFcRBXVgDDRIEmBScudEMtVkzYyZueERlzNTt1ugYaNc4Ey529lf1lNXCEK3sj4uW/WbwugeAGZnXOHwPYSDNwcg64UXfR9kTfHrmbOSwokW3zjS2qRLUPo0KVxls5Lu923Iz4jjvsE64M6949ENyUkbs2QKBgQDH8mAz7+PVeAMalnV2Jmeb4xMDCzLUK0stsv8lkEdV1VckSifC5P3YZoXOxl4egjEmEaDtamBjXRAm/Dw577tuF4BLPopl6isunXtqs7NzXCfcPcRXDNkOlnpPt48pxOYx1FkVZQYN7066jyOH6saqSq1gDpIKwqGRQl2RmPkpPwKBgCGE6r2YEWl2Tq6Q41bQEZsKFBUOWy91IL/9sZVNFK6kvkK9ODg6FJBsRkEdSzsaBFrFqQmALvlp/DGGrosGwYhPmT25goK38eVG88lxtOZ7jwMxwapLOK5+EduXSuOtQKfqiamzKHL1Y/JCaQdeGZNkd7cWe9IdMH5mO2OKjn2xAoGABK1RvMVGwg6NnAia9MmPMOFN54tShA4DMy11tG48jPBxmmK1rWRn37D+Pkj7mKEY/zf4WLVdTdW2dAMAcaZ+7uNT1+69lAa3Pd7nLSbI8tDcCdXUCuk9Bo9UixrTGXoGnHHIJ6z2SEspv0lr3lkKjp8ykQWmOuQ0nU49HBPE+EcCgYEAmCciuMBOtrKPfJozSUKTZeBQcGgQ1NgfnVBS3vOYLJXSeSnDaFgTA5AylzQru/FVKtpxU6hkPzcEwGMEWaHOhWmLRLOTjNfXA4iR2+tQyI3TerqSMMjtkdwm80NXa487Ot45TVeufOdQoLOC5oC/uwJjMaIFRnREGd35uVOq9H8=';
    private $publick_key='MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAsq/hciothnPMQlXbAjuCG+aZP1pM4y2A51wojx/rxsY4WBikjn0BCl/ZJJO7QQJeepUZESE5tD/6cZLqi7s9NU6Pu/0N99nTZJitbzIqPHiMFiVdUJDjDNcNdx3kCG50mv0XtRDVpa0msI7dJ6T4LRhqg6Rzx4LF9nrEbUw3mk8ih6H+F5Przvmwh5yxIf653oBPvWkgKT4NeWA61Snw4E4p8LEHUFAetqvibB+xIrdbEHrjdR1KVnlbnuo4zbQ0DN88tDz93lKc8aJH1zuavNmGLMNVf8172TrtsCtW6V59JjzXW2QEKVk1SoytnvyKtvHCUTiZBLy1HwfV0nQKZwIDAQAB';
    /**
     * @var
     */
    public $params;

    /**
     * @var
     */
    private $partner_id;
    /**
     * @var
     */
    private $service;
    /**
     * @var
     */
    private $charset;
    /**
     * @var
     */
    private $sign;
    /**
     * @var
     */
    private $sign_type;
    /**
     * @var
     */
    private $return_url;
    /**
     * @var
     */
    private $notify_url;

    /**
     * @var
     */
    private $protocol_params;

    /**
     * @var
     */
    private $secrete_key;

    /**
     * @var
     */
    private $gateway;
    /**
     * @param $credentials
     */
    public function __construct($credentials)
    {
        $this->partner_id = $credentials['partner_id'];
        //$this->service = $credentials['service'];
        $this->secrete_key = $credentials['secrete_key'];
        $this->gateway = $credentials['gateway'];
        if ($credentials['partner_id']) {
            $this->protocol_params['partner'] = $this->partner_id;
        }
        if ($credentials['service']) {
            $this->protocol_params['service'] = $this->service;
        }
    }

    /**
     * @return mixed
     */
    public function getPartnerId()
    {
        return $this->partner_id;
    }

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     */
    public function setService($service)
    {
        $this->service = $service;
        $this->protocol_params['service'] = $service;
    }

    /**
     * @return mixed
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @param mixed $charset
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
        $this->protocol_params['_input_charset'] = $charset;
    }

    /**
     * @return mixed
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * @param mixed $sign
     */
    public function setSign($sign)
    {
        $this->sign = $sign;
    }

    /**
     * @return mixed
     */
    public function getSignType()
    {
        return $this->sign_type;
    }

    /**
     * @param mixed $sign_type
     */
    public function setSignType($sign_type)
    {
        $this->sign_type = $sign_type;
    }

    /**
     * @return mixed
     */
    public function getReturnUrl()
    {
        return $this->return_url;
    }

    /**
     * @param mixed $return_url
     */
    public function setReturnUrl($return_url)
    {
        $this->return_url = $return_url;
        $this->protocol_params['return_url'] = $return_url;
    }

    /**
     * @return mixed
     */
    public function getNotifyUrl()
    {
        return $this->notify_url;
    }

    /**
     * @param mixed $notify_url
     */
    public function setNotifyUrl($notify_url)
    {
        $this->notify_url = $notify_url;
        $this->protocol_params['notify_url'] = $notify_url;
    }

    /**
     * @return mixed
     */
    public function getProtocolParams()
    {
        if ($this->protocol_params && is_array($this->protocol_params) && !empty($this->protocol_params)) {
            return $this->protocol_params;
        }
        return array();
    }

    /**
     * @param mixed $protocol_params
     */
    public function setProtocolParams($protocol_params)
    {
        $this->protocol_params = $protocol_params;
    }

    /**
     * @return mixed
     */
    public function getSecreteKey()
    {
        return $this->secrete_key;
    }

    /**
     * @param mixed $secrete_key
     */
    public function setSecreteKey($secrete_key)
    {
        $this->secrete_key = $secrete_key;
    }

    /**
     * @param $params
     * @return string|void
     */
    public function getPreSignedString($params)
    {
        if (empty($params)) {
            return null;
        }
        $arg = '';
        while (list($key, $val) = each($params)) {
            $arg .= $key."=".$val."&";
        }
        $arg = Tools::substr($arg, 0, count($arg)-2);
        if (get_magic_quotes_gpc()) {
            $arg = Tools::stripslashes($arg);
        }
        return md5($arg.$this->getSecreteKey());
    }

    /**
     * @param $params
     * @return mixed
     */
    public function paramSort($params)
    {
        $ret_params = $params;
        ksort($ret_params);
        reset($ret_params);
        return $ret_params;
    }

/**
     * @param Request $request
     * @param bool $sign
     */
    public function prepareRequest(Request $request, $sign = true)
    {
        $this->params = array_merge($request->getParamList(), $this->getProtocolParams());
        $this->params = $this->paramSort($this->params);
        if ($sign == true) {
            $this->setSign($this->rsaSign($this->params));
            $this->params['sign'] = $this->getSign();
            $this->params['sign_type'] = 'RSA2';
        }
    }
    /**RSA签名函数
     * $data为待签名数据，比如URL
     * 签名用游戏方的保密私钥，必须是没有经过pkcs8转换的.结果需要用base64编码以备在URL中传输
     * return Sign 签名
     */

    public function rsaSign($data) {

        $priKey =$this->private_key;
        //转换为openssl密钥，必须是没有经过pkcs8转换的私钥
        //$res = openssl_get_privatekey($priKey);
        //调用openssl内置签名方法，生成签名$sign
        openssl_sign($data, $sign, $priKey);
        //openssl_free_key($res);
        $sign = base64_encode($sign);
        return $sign;

    }
    /**
     * @param Request $request
     * @param bool $sign
     */
    /*public function prepareRequest(Request $request, $sign = true)
    {
        $this->params = array_merge($request->getParamList(), $this->getProtocolParams());
        $this->params = $this->paramSort($this->params);
        if ($sign == true) {
            $this->setSign($this->getPreSignedString($this->params));
            $this->params['sign'] = $this->getSign();
            $this->params['sign_type'] = 'MD5';
        }
    }*/

    /**
     * @param Response $response
     * @return mixed
     */
    public function getResponseSign(Response $response)
    {
        $this->params = array_merge($response->getParamList(), $this->getProtocolParams());
        $this->params = $this->paramSort($this->params);
        $this->setSign($this->getPreSignedString($this->params));
        return $this->sign;
    }

    /**
     * @param $params
     * @return string|void
     */
    public function getPaymentUrlParam($params)
    {
        if (empty($params)) {
            return null;
        }
        $arg = '';
        while (list($key, $val) = each($params)) {
            $arg .= $key."=".urlencode($val)."&";
        }
        $arg = Tools::substr($arg, 0, count($arg)-2);
        if (get_magic_quotes_gpc()) {
            $arg = Tools::stripslashes($arg);
        }
        return $arg;
    }

    /**
     * @param bool $gateway
     * @return string
     */
    public function createUrl($gateway = false)
    {
        $params_url = $this->getPaymentUrlParam($this->params);
        if ($gateway == false) {
            $url = $this->gateway.$params_url;
        } else {
            $url = $gateway . $params_url;
        }
        return $url;
    }

    /**
     * @param $path
     * @return mixed
     */
    public function getResponse($path)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 2);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }
}
