<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2009 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: checkout_success.php 14198 2009-08-18 22:32:11Z drbyte $
 */

define('NAVBAR_TITLE_1', 'Checkout');
define('NAVBAR_TITLE_2', 'Waiting - Oops! We\'re sorry');
define('HEADING_TITLE', 'Waiting');
define('TEXT_SEE_ORDERS', 'You can view your order history by going to the <a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '" name="linkMyAccount">My Account</a> page and by clicking on "View All Orders".');
define('TEXT_CONTACT_STORE_OWNER', 'Please direct any questions you have to <a href="' . zen_href_link(FILENAME_CONTACT_US) . '" name="linkContactUs">customer service</a>.');


define('TEXT_YOUR_ORDER_NUMBER', '<strong>Your Order Number is:</strong> ');
define('TEXT_CHECKOUT_LOGOFF_GUEST', 'NOTE: To complete your order, a temporary account was created. You may close this account by clicking Log Off. Clicking Log Off also ensures that your receipt and purchase information is not visible to the next person using this computer. If you wish to continue shopping, feel free! You may log off at anytime using the link at the top of the page.');
define('TEXT_CHECKOUT_LOGOFF_CUSTOMER', 'Thank you for shopping. Please click the Log Off link to ensure that your receipt and purchase information is not visible to the next person using this computer.');


define('WAITING', 'We will confirm your payment and inform you when the order processing is initiated (normally in 1 hours).If not, please review your order information below and complete the payment for order processing.');
