<?php

	require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

	if (isset($_REQUEST['orderStatus'])) {

		// load selected payment module
		require(DIR_WS_CLASSES . 'payment.php');

		$payment_modules = new payment('creditcard');
		
		$payment_modules->after_process();

 		if($_REQUEST['orderStatus'] == '1' && $_REQUEST['isPush'] == ''){
			$_SESSION['cart']->reset(true);
 		}

		// unregister session variables used during checkout
		unset($_SESSION['sendto']);
		unset($_SESSION['billto']);
		unset($_SESSION['shipping']);
		unset($_SESSION['payment']);
		unset($_SESSION['comments']);
		setcookie('refresh', '', time()-3600);
		
		//返回交易信息
		$orderInfo = $_REQUEST['orderInfo'];
		$_SESSION['orderInfo'] = $orderInfo;
		$_SESSION['errorCode'] = substr($orderInfo,0,5);
		$_SESSION['check'] = strtolower($orderInfo);
		
		preg_match('/do not honour/si', $_SESSION['check'], $p);
		if(isset($p[0])){
			$_SESSION['donothonour'] = '1';
		}else{
			$_SESSION['donothonour'] = '0';
		};
		
		preg_match('/refer to card issuer/si', $_SESSION['check'], $p);
		if(isset($p[0])){
			$_SESSION['refertocardissuer'] = '1';
		}else{
			$_SESSION['refertocardissuer'] = '0';
		};


		if($_REQUEST['orderStatus'] == '1'){
			echo '<script type="text/javascript">parent.location.replace("' . zen_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL') . '");</script>';
			exit();
		} elseif($_REQUEST['orderStatus'] == '-1' || $_REQUEST['orderStatus'] == '-2') {
			echo '<script type="text/javascript">parent.location.replace("' . zen_href_link('checkout_waiting', '', 'SSL') . '");</script>';
			exit();
		} else {
			echo '<script type="text/javascript">parent.location.replace("' . zen_href_link('checkout_failure', '', 'SSL') . '");</script>';
			exit();
		}

		
	} else {

		// load selected payment module
		require(DIR_WS_CLASSES . 'payment.php');
		$payment_modules = new payment($_SESSION['payment']);

		// load the selected shipping module
		require(DIR_WS_CLASSES . 'shipping.php');
		$shipping_modules = new shipping($_SESSION['shipping']);

        // load the order module
		require(DIR_WS_CLASSES . 'order.php');
		$order = new order;

		// prevent 0-entry orders from being generated/spoofed
		if (sizeof($order->products) < 1) {
		  zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
		}

        // load the order_total module
		require(DIR_WS_CLASSES . 'order_total.php');
		$order_total_modules = new order_total;

		$order_totals = $order_total_modules->pre_confirmation_check();
		
		$order_totals = $order_total_modules->process();
		
		if (!isset($_SESSION['payment']) && !$credit_covers) {
			zen_redirect(zen_href_link(FILENAME_DEFAULT));
		}

		if(!isset($_COOKIE['refresh'])){
			$insert_id = $order->create($order_totals, 2);
			// create the order record
			$_SESSION['order_number_created'] = $insert_id;
			// store the product info to the order
			$order->create_add_products($insert_id);
			global $order_totals;
			$_SESSION['order_totals']=$order_totals;
			setcookie('refresh',1);
		}

		$order->send_order_email($insert_id, 2);

		$credits_applied = 0;
		for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {
			if ($order_totals[$i]['code'] == 'ot_subtotal') $order_subtotal = $order_totals[$i]['value'];
			if ($$order_totals[$i]['code']->credit_class == true) $credits_applied += $order_totals[$i]['value'];
			if ($order_totals[$i]['code'] == 'ot_total') $ototal = $order_totals[$i]['value'];
		}
		$commissionable_order = ($order_subtotal - $credits_applied);
		$commissionable_order_formatted = $currencies->format($commissionable_order);
		$_SESSION['order_summary']['order_number'] = $insert_id;
		$_SESSION['order_summary']['order_subtotal'] = $order_subtotal;
		$_SESSION['order_summary']['credits_applied'] = $credits_applied;
		$_SESSION['order_summary']['order_total'] = $ototal;
		$_SESSION['order_summary']['commissionable_order'] = $commissionable_order;
		$_SESSION['order_summary']['commissionable_order_formatted'] = $commissionable_order_formatted;
		$_SESSION['order_summary']['coupon_code'] = $order->info['coupon_code'];
	}
	$breadcrumb->add(NAVBAR_TITLE);
?>