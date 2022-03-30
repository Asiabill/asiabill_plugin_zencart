<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2009 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: checkout_success.php 14198 2009-08-18 22:32:11Z drbyte $
 */

define('NAVBAR_TITLE_1', 'Checkout');
define('NAVBAR_TITLE_2', 'Failure - Oops! We\'re sorry');
define('HEADING_TITLE', 'Oops! We\'re sorry!');
define('TEXT_SEE_ORDERS', 'You can view your order history by going to the <a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '" name="linkMyAccount">My Account</a> page and by clicking on "View All Orders".');
define('TEXT_CONTACT_STORE_OWNER', 'Please direct any questions you have to <a href="' . zen_href_link(FILENAME_CONTACT_US) . '" name="linkContactUs">customer service</a>.');


define('TEXT_YOUR_ORDER_NUMBER', '<strong>Your Order Number is:</strong> ');
define('TEXT_CHECKOUT_LOGOFF_GUEST', 'NOTE: To complete your order, a temporary account was created. You may close this account by clicking Log Off. Clicking Log Off also ensures that your receipt and purchase information is not visible to the next person using this computer. If you wish to continue shopping, feel free! You may log off at anytime using the link at the top of the page.');
define('TEXT_CHECKOUT_LOGOFF_CUSTOMER', 'Thank you for shopping. Please click the Log Off link to ensure that your receipt and purchase information is not visible to the next person using this computer.');

define('LOGO_SRC', DIR_WS_MODULES . 'payment/creditcard/failure.png');
define('LOGO', '<img src="' . LOGO_SRC . '" width="110px"/>');

define('I0061', 'We are confirming your order, please do not duplicate payments, if the order status is \'pending\', please contact us for verification.');
define('R0000', 'We have received your order.
        But your payment has not been processed at this time, we are sorry for any inconvenience.<br>
        Note:<br>
        1.	Please make sure your credit card is valid and you have entered your card information correctly.<br>
        2.	If your transaction was declined, please use another card to pay.');
define('E0008', 'Transaction has been canceled.');
define('I0013', 'Please check your <b>signInfo</b>.');
define('Do_not_honour', 'Due to the reason of your credit/debit card issuing bank, your payment was not be approved.<br><br>
There are some very important information can help you to complete the payment:<br><br>
1. You can call your credit/debit card issuing bank to let them know you are the card holder and the payment was making by you. It will be 100% successful if the issuing bank receives your phone, it is the best way to fix the problem.<br><br>
2. You may be warned from your issuing bank that the payment is a cross-border transaction. Please don\'t worry about that, because the website uses a Hongkong\'s bank as the acquiring bank. The transaction is safe, please contact us if you have any question.<br><br>
3. The simplest way is you to pay again or change another card.<br><br>');
define('ELSE_ERROR', 'We have received your order.
        But your payment has not been processed at this time, we are sorry for any inconvenience.<br>
        Note:<br>
        1.	Please make sure your credit card is valid and you have entered your card information correctly.<br>
        2.	If your transaction was declined, please use another card to pay.');
