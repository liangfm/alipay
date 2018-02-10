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
 * Class AlipayConfirmationModuleFrontController
 * Extends ModuleFrontController
 * @see ModuleFrontController
 */
class AlipayPayModuleFrontController extends ModuleFrontController
{
    /**
     * This method is called when the customer goes back to shop, after he made a payment.
     * The customer will redirected either to the order confirmation page or to an error page
     * @return mixed
     */
    public function initContent()
    {
        parent::initContent();
	$this->name = 'alipay';
        $cart = $this->context->cart;
        //$this->hookPayment($cart);
	$this->aliPay($cart);
    }

    public function aliPay($cartObj){
	require_once _PS_MODULE_DIR_.'alipay/alipay-sdk/config.php';
	require_once _PS_MODULE_DIR_.'alipay/alipay-sdk/pagepay/service/AlipayTradeService.php';
	require_once _PS_MODULE_DIR_.'alipay/alipay-sdk/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php';
	include_once(_PS_MODULE_DIR_.'alipay/api/loader.php');
        $currency_id = $cartObj->id_currency;
        $currency = new Currency((int)$currency_id);
        $cart = new Cart($cartObj->id);
        if (!ValidateCore::isLoadedObject($cart)) {
            return false;
        }
        
   //商户订单号，商户网站订单系统中唯一订单号，必填
    $out_trade_no = trim(date('YmdHis').$cart->id);
    //订单名称，必填
    $subject = trim($this->getGoodsName($cart->id));
    //付款金额，必填
    $total_amount = trim($cart->getOrderTotal());
    //商品描述，可空
    $body = trim($this->getGoodsDescription());
	//构造参数
	$payRequestBuilder = new AlipayTradePagePayContentBuilder();
	$payRequestBuilder->setBody($body);
	$payRequestBuilder->setSubject($subject);
	$payRequestBuilder->setTotalAmount($total_amount);
	$payRequestBuilder->setOutTradeNo($out_trade_no);

	$aop = new AlipayTradeService($config);

	/**
	 * pagePay 电脑网站支付请求
	 * @param $builder 业务参数，使用buildmodel中的对象生成。
	 * @param $return_url 同步跳转地址，公网可以访问
	 * @param $notify_url 异步通知地址，公网可以访问
	 * @return $response 支付宝返回的信息
 	*/
//	$response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);
	$response = $aop->pagePay($payRequestBuilder,$this->getReturnUrl($cart->secure_key, $cart->id),
	$config['notify_url']);
	//$this->getNotifyUrl($cart->secure_key, $cart->id));
	//输出表单
	var_dump($response);
    }

 /**
     * This method is used to render the payment button,
     * Take care if the button should be displayed or not.
     */
    public function hookPayment($cartObj)
    {
        include_once(_PS_MODULE_DIR_.'alipay/api/loader.php');
        $currency_id = $cartObj->id_currency;
        $currency = new Currency((int)$currency_id);
        $cart = new Cart($cartObj->id);
        if (!ValidateCore::isLoadedObject($cart)) {
            return false;
        }
        
        $service = Configuration::get('ALIPAY_SERVICE_PAYMENT');
        $credentials = AlipayTools::getCredentials($service, false);

        $alipayapi = new AlipayApi($credentials);
       //$alipayapi->setReturnUrl($this->getReturnUrl($cart->secure_key, $cart->id));
        $alipayapi->setNotifyUrl($this->getNotifyUrl($cart->secure_key, $cart->id));
        $alipayapi->setCharset('UTF-8');
        date_default_timezone_set('Asia/Hong_Kong');
        $payment_request = new PaymentRequest();
        $payment_request->setCurrency($currency->iso_code);
        $payment_request->setPartnerTransactionId(date('YmdHis').$cart->id);
        $payment_request->setGoodsDescription($this->getGoodsDescription());
        $payment_request->setGoodsName($this->getGoodsName($cart->id));
        $payment_request->setOrderGmtCreate(date('Y-m-d H:i:s'));
        $payment_request->setOrderValidTime(21600);
        $payment_request->setTotalFee($cart->getOrderTotal());
        $alipayapi->prepareRequest($payment_request);
        $url = $alipayapi->createUrl();
        $this->context->smarty->assign(
            array(
                'module_dir' => _PS_MODULE_DIR_,
                'alipay_payment_url' => $url
            )
        );
	die($url);
//        return $this->display(__FILE__, 'views/templates/hook/payment.tpl');
    }
/**
     * This method returns the products name of the products order
     * @param $id_cart
     * @return string
     */
    public function getGoodsName($id_cart)
    {
        $cart = new Cart($id_cart);
        $products = $cart->getProducts();
        $goods_name = '';
        foreach ($products as $product) {
            $goods_name .= $product['name'].', ';
        }
        if ($goods_name) {
            return Tools::substr($goods_name, 0, -2);
        }
        return $goods_name;
    }
 /**
     * @return mixed
     */
    public function getGoodsDescription()
    {
        return $this->context->shop->name;
    }
  /**
     * This method returns the Notify URL used by Alipay to send notifications to the module
     * @param $secure_key
     * @param $id_cart
     * @return string
     */
    public function getNotifyUrl($secure_key, $id_cart)
    {
        $shop_url = Tools::getHttpHost(true).__PS_BASE_URI__;
        return $shop_url.'modules/alipay/notify_url.php?secure_key='.$secure_key.'&id_cart='.$id_cart;
    }

 /**
     * This method returns the Return URL after a payment is made by a customer
     * @param $secure_key
     * @param $id_cart
     * @return string
     */
    public function getReturnUrl($secure_key, $id_cart)
    {
        $shop_url = Tools::getHttpHost(true).__PS_BASE_URI__;
        return $shop_url.'index.php?fc=module&module='.$this->name
        .'&controller=confirmation&secure_key='.$secure_key.'&id_cart='.$id_cart;
    }

}
