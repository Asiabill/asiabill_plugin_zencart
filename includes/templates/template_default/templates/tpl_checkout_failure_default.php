<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=checkout_failure.<br />
 * Displays confirmation details after order has been successfully processed.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_checkout_failure_default.php 16313 2010-05-22 08:15:39Z wilt $
 */
?>
<div class="centerColumn" id="checkoutSuccess">
<?php echo $messageStack->output('checkout_failure');?>
<!--bof -gift certificate- send or spend box-->
<?php
// only show when there is a GV balance
  if ($customer_has_gv_balance ) {
?>
<div id="sendSpendWrapper">
<?php require($template->get_template_dir('tpl_modules_send_or_spend.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_send_or_spend.php'); ?>
</div>
<?php
  }
?>
<!--eof -gift certificate- send or spend box-->

<h1 id="checkoutSuccessHeading"><?php echo HEADING_TITLE; ?></h1>
<div id="checkoutSuccessOrderNumber"><?php echo TEXT_YOUR_ORDER_NUMBER . $zv_orders_id; ?></div>
<div id="checkoutSuccessMainContent" class="content">
<div style="float:left;height:200px;margin:20px">
<?php echo LOGO;?>
</div>
<div style="padding:20px">
<?php


    if($_SESSION['errorCode'] == 'I0061'){
    	echo I0061;
    } elseif ($_SESSION['errorCode'] == 'R0000') {
    	echo R0000;
    } elseif ($_SESSION['errorCode'] == 'E0008') {
    	echo E0008;
    } elseif ($_SESSION['errorCode'] == 'I0013') {
    	echo I0013;
    } elseif ($_SESSION['donothonour'] == '1' || $_SESSION['refertocardissuer'] == '1') {
    	echo Do_not_honour;
    } else {
    	echo ELSE_ERROR;
    }

?>
</div>
</div>

<!--bof logoff-->
<div id="checkoutSuccessLogoff">

<div class="buttonRow forward"><a href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>"><?php echo zen_image_button(BUTTON_IMAGE_LOG_OFF , BUTTON_LOG_OFF_ALT); ?></a></div>
</div>
<!--eof logoff-->

<br class="clearBoth" />


<!--bof -product downloads module-->
<?php
  if (DOWNLOAD_ENABLED == 'true') require($template->get_template_dir('tpl_modules_downloads.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_downloads.php');
?>
<!--eof -product downloads module-->

<div id="checkoutSuccessOrderLink"><?php echo TEXT_SEE_ORDERS;?></div>

<div id="checkoutSuccessContactLink"><?php echo TEXT_CONTACT_STORE_OWNER;?></div>

</div>