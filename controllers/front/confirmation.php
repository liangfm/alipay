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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2015 PrestaShop SA
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

/**
 * Class AlipayConfirmationModuleFrontController
 * Extends ModuleFrontController
 * @see ModuleFrontController
 */
class AlipayConfirmationModuleFrontController extends ModuleFrontController
{
    /**
     * This method is called when the customer goes back to shop, after he made a payment.
     * The customer will redirected either to the order confirmation page or to an error page
     * @return mixed
     */
    public function postProcess()
    {
        require_once _PS_MODULE_DIR_ . 'alipay/alipay-sdk/config.php';
        require_once _PS_MODULE_DIR_ . 'alipay/alipay-sdk/pagepay/service/AlipayTradeService.php';
        require_once(dirname(__FILE__) . '/../../api/loader.php');
        // $alipay = new Alipay();
        //$payment_response = new PaymentResponse();
        //  $payment_response->getPostData();
        //if ($payment_response->getTradeStatus() == 'TRADE_FINISHED') {
        //校验签名是否合法
        $arr = $_GET;
        $alipaySevice = new AlipayTradeService($config);
        $result = $alipaySevice->check($arr);
        $cart = $this->context->cart;
        $authorized = false;
        foreach (Module::getPaymentModules() as $module) {
            if ($module['name'] == 'alipay') {
                $authorized = true;
                break;
            }
        }

        if (!$authorized) {
            die($this->trans('This payment method is not available.', array(), 'Modules.Checkpayment.Shop'));
        }
        $customer = new Customer($cart->id_customer);
        if (!Validate::isLoadedObject($customer)) {
            Tools::redirect('index.php?controller=order&step=1');
        }

        $currency = $this->context->currency;
        $total = (float)$cart->getOrderTotal(true, Cart::BOTH);

        $this->module->validateOrder((int)$cart->id, Configuration::get('PS_OS_PAYMENT'), $total, $this->module->displayName, null, var_export($arr), (int)$currency->id, false, $customer->secure_key);
        Tools::redirect('index.php?controller=order-confirmation&id_cart=' . (int)$cart->id . '&id_module=' . (int)$this->module->id . '&id_order=' . $this->module->currentOrder . '&key=' . $customer->secure_key);
    }
}
