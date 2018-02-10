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
 * This is the Notify URL file, called by Alipay system
 *
 * First, we need to verify the genuineness of the notification by calling the Alipay "notify_verify" service
 * Then we performs some tests with local values
 * Finally, after we made the proper actions, we need to answer to Alipay with the word "success" or "fail"
 * @see AlipayNotify
 */

require_once('../../config/config.inc.php');
require_once(dirname(__FILE__) . '/alipay.php');
require_once(dirname(__FILE__) . '/api/loader.php');
require_once _PS_MODULE_DIR_ . 'alipay/alipay-sdk/config.php';
require_once _PS_MODULE_DIR_ . 'alipay/alipay-sdk/pagepay/service/AlipayTradeService.php';
$arr = $_POST;
$alipaySevice = new AlipayTradeService($config);
unset($arr['id_cart']);
unset($arr['secure_key']);
$alipaySevice->writeLog(var_export($_POST, true));
$verfiy = $alipaySevice->check($arr);

$alipay_notify = new AlipayNotify();
$alipay_notify->getPostData();
$alipay_notify->writeLog('异步通知成功 '.$verfiy);
//$alipay_notify->writeLog(var_export($alipay_notify,true));


switch ($alipay_notify->getNotifyType()) {
    case "trade_status_sync":
        if ($verfiy) {
            $alipay_notify->writeLog("接收通知-签名认证成功");
            /*$default_config = array(
                'secrete_key'   => false
            );
            $service = Configuration::get('ALIPAY_SERVICE_NOTIFY_VERIFY');
            $credentials = AlipayTools::getCredentials($service, $default_config);
            $alipayapi = new AlipayApi($credentials);
            $alipay_notify->setParamList('notify_verify');
            $alipayapi->prepareRequest($alipay_notify, false);
            $url = $alipayapi->createUrl();
            $alipay_notify->setParamList('compare_sign');
            $params = $alipayapi->getProtocolParams();
            unset($params['partner']);
            unset($params['service']);
            $alipayapi->setProtocolParams($params);
            $alipayapi->setSecreteKey(Configuration::get('ALIPAY_SECRETE_KEY'));
            $alipayapi->prepareRequest($alipay_notify);
            if ($alipayapi->getResponse($url) != 'true' ||
                !$alipay_notify->verifyDupplicates() ||
                $alipayapi->getSign() != Tools::getValue('sign')
            ) {
                return;
            }*/
            if ($_POST['trade_status'] == 'TRADE_FINISHED') {
                $alipaySevice->writeLog("接收通知-交易完成TRADE_FINISHED");
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
            } else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                $alipaySevice->writeLog("接收通知-定单成功TRADE_SUCCESS");
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //付款完成后，支付宝系统发送该交易状态通知
            }
            if ($alipay_notify->saveNotify()) {
                $alipay = new Alipay();
                $extra_vars = array();
                $extra_vars['transaction_id'] = $alipay_notify->getTradeNo();
                $alipay->validateOrder(
                    (int)$alipay_notify->getIdCart(),
                    Configuration::get('PS_OS_PAYMENT'),
                    $alipay_notify->getTotalFee(),
                    'Alipay',
                    null,
                    $extra_vars,
                    null,
                    false,
                    $alipay_notify->getSecureKey()
                );
                $alipaySevice->writeLog("保存交易通知成功");
                $id_order = (int)Order::getOrderByCartId($alipay_notify->getIdCart());
                if ($id_order) {
                    $alipay_notify->saveOrder($id_order);
                    header('HTTP/1.1 200 OK');
                    echo "success";
                    exit;
                }else{
                    $alipaySevice->writeLog("通知支付宝失败-fail");
                }
            } else {
                $alipaySevice->writeLog("保存交易通知失败！");
            }

        } else {
            $alipaySevice->writeLog("接收通知-签名认证失败！");
        }
        header('HTTP/1.1 200 OK');
        echo "fail";
        exit;
    default:
        break;
}
