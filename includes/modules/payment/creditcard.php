<?php


class creditcard extends base {

    const DOMAIN = 'https://safepay.asiabill.com';
    const SANDBOX = 'https://testpay.asiabill.com';

    var $code;
    var $title;
    var $description;
    var $sort_order;
    var $enabled;
    var $order_status;

	var $paymentMethod  = 'Credit Card';
	var $remark         = '';
	var $db;

	var $form_action_url;

	function creditcard() {

		global $db,$order;

        $this->db = $db;

		$this->code = 'creditcard';
		$this->title  = MODULE_PAYMENT_CREDITCARD_TEXT_CATALOG_TITLE.' (Version 1.0)';
		$this->description = MODULE_PAYMENT_CREDITCARD_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_CREDITCARD_SORT_ORDER;
		$this->enabled = MODULE_PAYMENT_CREDITCARD_STATUS == 'true' ? true : false;
		$this->order_status = MODULE_PAYMENT_CREDITCARD_ORDER_STATUS_ID>1?MODULE_PAYMENT_CREDITCARD_ORDER_STATUS_ID:DEFAULT_ORDERS_STATUS_ID;

		if (is_object($order)) $this->update_status();

		// 支付程序页面地址
		$this->form_action_url = zen_href_link('checkout_creditcard', '', 'SSL');

	}

    // 安装程序，添加字段设置
    function install() {
        // zen_db_perform
        global $db, $module_type;
        // 加载语言文件
        include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/' . $module_type . '/creditcard.php');

        //在数据库中插入模块设置(是否启用插件)
        $sql_data_array = array(
            'configuration_title' => 'Enable Credit Card Module',
            'configuration_key' => 'MODULE_PAYMENT_CREDITCARD_STATUS',
            'configuration_value' => 'false',
            'configuration_description' => 'Do you want to accept Credit Card payments?',
            'configuration_group_id' => '6',
            'sort_order' => '1',
            'set_function' => 'zen_cfg_select_option(array(\'true\', \'false\'), ',
            'date_added' =>  'now()'
        );
        zen_db_perform(TABLE_CONFIGURATION, $sql_data_array);

        //在数据库中插入模块设置(模式)
        $sql_data_array = array(
            'configuration_title' => 'Mode',
            'configuration_key' => 'MODULE_PAYMENT_CREDITCARD_MODE',
            'configuration_value' => 'test',
            'configuration_description' => '',
            'configuration_group_id' => '6',
            'sort_order' => '2',
            'set_function' => 'zen_cfg_select_option(array(\'test\', \'live\'), ',
            'date_added' =>  'now()'
        );
        zen_db_perform(TABLE_CONFIGURATION, $sql_data_array);

        //在数据库中插入模块设置(填写商户号)
        $sql_data_array = array(
            'configuration_title' => 'Mer No',
            'configuration_key' => 'MODULE_PAYMENT_CREDITCARD_MERNO',
            'configuration_value' => '',
            'configuration_description' => '',
            'configuration_group_id' => '6',
            'sort_order' => '3',
            'date_added' =>  'now()'
        );
        zen_db_perform(TABLE_CONFIGURATION, $sql_data_array);

        //在数据库中插入模块设置(填写网关接入号)
        $sql_data_array = array(
            'configuration_title' => 'Gateway No',
            'configuration_key' => 'MODULE_PAYMENT_CREDITCARD_GATEWAYNO',
            'configuration_value' => '',
            'configuration_description' => '',
            'configuration_group_id' => '6',
            'sort_order' => '4',
            'date_added' =>  'now()'
        );
        zen_db_perform(TABLE_CONFIGURATION, $sql_data_array);

        //在数据库中插入模块设置(KEY值)
        $sql_data_array = array(
            'configuration_title' => 'Signkey',
            'configuration_key' => 'MODULE_PAYMENT_CREDITCARD_SIGNKEY',
            'configuration_value' => '',
            'configuration_description' => '',
            'configuration_group_id' => '6',
            'sort_order' => '5',
            'date_added' =>  'now()'
        );
        zen_db_perform(TABLE_CONFIGURATION, $sql_data_array);

        //在数据库中插入模块设置(填写测试商户号)
        $sql_data_array = array(
            'configuration_title' => 'Test Mer No',
            'configuration_key' => 'MODULE_PAYMENT_CREDITCARD_TEST_MERNO',
            'configuration_value' => '12246',
            'configuration_description' => '',
            'configuration_group_id' => '6',
            'sort_order' => '6',
            'date_added' =>  'now()'
        );
        zen_db_perform(TABLE_CONFIGURATION, $sql_data_array);

        //在数据库中插入模块设置(填写测试网关接入号)
        $sql_data_array = array(
            'configuration_title' => 'Test Gateway No',
            'configuration_key' => 'MODULE_PAYMENT_CREDITCARD_TEST_GATEWAYNO',
            'configuration_value' => '12246002',
            'configuration_description' => '',
            'configuration_group_id' => '6',
            'sort_order' => '7',
            'date_added' =>  'now()'
        );
        zen_db_perform(TABLE_CONFIGURATION, $sql_data_array);

        //在数据库中插入模块设置(测试KEY值)
        $sql_data_array = array(
            'configuration_title' => 'Test Signkey',
            'configuration_key' => 'MODULE_PAYMENT_CREDITCARD_TEST_SIGNKEY',
            'configuration_value' => '12H4567r',
            'configuration_description' => '',
            'configuration_group_id' => '6',
            'sort_order' => '8',
            'date_added' =>  'now()'
        );
        zen_db_perform(TABLE_CONFIGURATION, $sql_data_array);

        //在数据库中插入模块设置(默认订单状态)
        $sql_data_array = array(
            'configuration_title' => 'Setting the Pending order status：',
            'configuration_key' => 'MODULE_PAYMENT_CREDITCARD_ORDER_STATUS_ID',
            'configuration_value' => '1',
            'configuration_description' => '',
            'configuration_group_id' => '6',
            'sort_order' => '9',
            'use_function' => 'zen_get_order_status_name',
            'set_function' => 'zen_cfg_pull_down_order_statuses(',
            'date_added' =>  'now()'
        );
        zen_db_perform(TABLE_CONFIGURATION, $sql_data_array);

        //在数据库中插入模块设置(成功订单状态)
        $sql_data_array = array(
            'configuration_title' => 'Setting the Successful order status',
            'configuration_key' => 'MODULE_PAYMENT_CREDITCARD_SUCCESS_STATUS_ID',
            'configuration_value' => '2',
            'configuration_description' => '',
            'configuration_group_id' => '6',
            'sort_order' => '10',
            'use_function' => 'zen_get_order_status_name',
            'set_function' => 'zen_cfg_pull_down_order_statuses(',
            'date_added' =>  'now()'
        );
        zen_db_perform(TABLE_CONFIGURATION, $sql_data_array);

        //在数据库中插入模块设置(失败订单状态)
        $sql_data_array = array(
            'configuration_title' => 'Setting the Failure order status',
            'configuration_key' => 'MODULE_PAYMENT_CREDITCARD_FAILURE_STATUS_ID',
            'configuration_value' => '1',
            'configuration_description' => '',
            'configuration_group_id' => '6',
            'sort_order' => '11',
            'use_function' => 'zen_get_order_status_name',
            'set_function' => 'zen_cfg_pull_down_order_statuses(',
            'date_added' =>  'now()'
        );
        zen_db_perform(TABLE_CONFIGURATION, $sql_data_array);


        //在数据库中插入模块设置(是否显示Visa logo)
        $sql_data_array = array(
            'configuration_title' => 'Show Visa logo',
            'configuration_key' => 'MODULE_PAYMENT_CREDITCARD_VISA',
            'configuration_value' => 'No',
            'configuration_description' => 'Do you want to show Visa logo?',
            'configuration_group_id' => '6',
            'sort_order' => '12',
            'set_function' => 'zen_cfg_select_option(array(\'Yes\', \'No\'), ',
            'date_added' =>  'now()'
        );
        zen_db_perform(TABLE_CONFIGURATION, $sql_data_array);

        //在数据库中插入模块设置(是否显示MaterCard logo)
        $sql_data_array = array(
            'configuration_title' => 'Show MasterCard logo',
            'configuration_key' => 'MODULE_PAYMENT_CREDITCARD_MASTERCARD',
            'configuration_value' => 'No',
            'configuration_description' => 'Do you want to show Master Card logo?',
            'configuration_group_id' => '6',
            'sort_order' => '13',
            'set_function' => 'zen_cfg_select_option(array(\'Yes\', \'No\'), ',
            'date_added' =>  'now()'
        );
        zen_db_perform(TABLE_CONFIGURATION, $sql_data_array);

        //在数据库中插入模块设置(是否显示JCB logo)
        $sql_data_array = array(
            'configuration_title' => 'Show JCB logo',
            'configuration_key' => 'MODULE_PAYMENT_CREDITCARD_JCB',
            'configuration_value' => 'No',
            'configuration_description' => 'Do you want to show JCB logo?',
            'configuration_group_id' => '6',
            'sort_order' => '14',
            'set_function' => 'zen_cfg_select_option(array(\'Yes\', \'No\'), ',
            'date_added' =>  'now()'
        );
        zen_db_perform(TABLE_CONFIGURATION, $sql_data_array);

        //在数据库中插入模块设置(是否显示American Express logo)
        $sql_data_array = array(
            'configuration_title' => 'Show American Express logo',
            'configuration_key' => 'MODULE_PAYMENT_CREDITCARD_AE',
            'configuration_value' => 'No',
            'configuration_description' => 'Do you want to show American Express logo?',
            'configuration_group_id' => '6',
            'sort_order' => '15',
            'set_function' => 'zen_cfg_select_option(array(\'Yes\', \'No\'), ',
            'date_added' =>  'now()'
        );
        zen_db_perform(TABLE_CONFIGURATION, $sql_data_array);


        //在数据库中插入模块设置(支付模块排序)
        $sql_data_array = array(
            'configuration_title' => 'Sort order of display',
            'configuration_key' => 'MODULE_PAYMENT_CREDITCARD_SORT_ORDER',
            'configuration_value' => '1',
            'configuration_description' => 'Sort order of display. Lowest is displayed first.',
            'configuration_group_id' => '6',
            'sort_order' => '16',
            'date_added' =>  'now()'
        );
        zen_db_perform(TABLE_CONFIGURATION, $sql_data_array);

        //在数据库中插入模块设置(支付地区)
        $sql_data_array = array(
            'configuration_title' => 'Payment Zone',
            'configuration_key' => 'MODULE_PAYMENT_CREDITCARD_ZONE',
            'configuration_value' => '0',
            'configuration_description' => 'If a zone is selected, only enable this payment method for that zone?',
            'configuration_group_id' => '6',
            'sort_order' => '17',
            'use_function' => 'zen_get_zone_class_title',
            'set_function' => 'zen_cfg_pull_down_zone_classes(',
            'date_added' =>  'now()'
        );
        zen_db_perform(TABLE_CONFIGURATION, $sql_data_array);


    }

    // 删除程序
    function remove() {
        global $db;
        //在数据库中移除插件
        $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key LIKE 'MODULE_PAYMENT_CREDITCARD_%'");
    }

    function javascript_validation() {
        return false;
    }

    function pre_confirmation_check() {
        return false;
    }

    function confirmation() {
        setcookie('refresh', '', time()-3600);
        return false;
    }

    function process_button() {
        return false;
    }

    function check() {
        if ( !isset($this->_check) ) {
            $check_query  = $this->db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_CREDITCARD_STATUS'");
            $this->_check = $check_query->RecordCount();
        }

        return $this->_check;
    }

    // 查询数据库中的设置项，并且返回数组
    function keys() {
        $configuration_key = $this->db->Execute('select configuration_key from '. TABLE_CONFIGURATION .' where configuration_key like "MODULE_PAYMENT_CREDITCARD_%" order by sort_order  ');
        $arr = array();
        while ( !$configuration_key -> EOF ) {
            $arr[] = $configuration_key -> fields['configuration_key'];
            $configuration_key->MoveNext();
        }
        return $arr;
    }

    // 判断客户地址是否可以使用该付款
    function update_status() {
        global $order;

        if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_CREDITCARD_ZONE > 0) ) {
            $check_flag  = false;
            $check_query = $this->db->Execute("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_CREDITCARD_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");

            while (!$check_query->EOF) {
                if ($check_query->fields['zone_id'] < 1) {
                    $check_flag = true;
                    break;
                } elseif ($check_query->fields['zone_id'] == $order->billing['zone_id']) {
                    $check_flag = true;
                    break;
                }
                $check_query->MoveNext();
            }

            if ($check_flag == false) {
                $this->enabled = false;
            }
        }
    }

    // 付款选项
    function selection() {
        $visa = '';
        $master = '';
        $jcb = '';
        $ae = '';

        if(MODULE_PAYMENT_CREDITCARD_VISA == 'Yes'){
            $visa = '<img src= "'.DIR_WS_TEMPLATES.'template_default/images/payment/visa.jpg" style="height:24px;" />';;
        }
        if(MODULE_PAYMENT_CREDITCARD_MASTERCARD == 'Yes'){
            $master = '<img src= "'.DIR_WS_TEMPLATES.'template_default/images/payment/mastercard.jpg" style="height:24px" />';;
        }
        if(MODULE_PAYMENT_CREDITCARD_JCB == 'Yes'){
            $jcb = '<img src= "'.DIR_WS_TEMPLATES.'template_default/images/payment/jcb.jpg" style="height:24px;margin-right:5px" />';;
        }
        if( MODULE_PAYMENT_CREDITCARD_AE == 'Yes' ){
            $ae = '<img src= "'.DIR_WS_TEMPLATES.'template_default/images/payment/AE.jpg" style="height:24px;margin-right:5px" />';
        }


        return array(
            'id'     => $this->code,
            'module' => $visa.$master.$jcb.$ae.MODULE_PAYMENT_CREDITCARD_ACCEPTANCE_MARK_TEXT,
            'icon'   => $this->paymentMethod
        );
    }

    // 支付请求
    function before_process() {
        global $order, $currencies;


        $signkey       =  MODULE_PAYMENT_CREDITCARD_MODE == 'test'? MODULE_PAYMENT_CREDITCARD_TEST_SIGNKEY: MODULE_PAYMENT_CREDITCARD_SIGNKEY;
        $postParameter = array(
            'merNo'         => MODULE_PAYMENT_CREDITCARD_MODE == 'test'? MODULE_PAYMENT_CREDITCARD_TEST_MERNO: MODULE_PAYMENT_CREDITCARD_MERNO, // 商户号
            'gatewayNo'     => MODULE_PAYMENT_CREDITCARD_MODE == 'test'? MODULE_PAYMENT_CREDITCARD_TEST_GATEWAYNO: MODULE_PAYMENT_CREDITCARD_GATEWAYNO, // 网关号
            'orderNo'       => $_SESSION['order_number_created'], // zencart默认订单表主键id为订单id，如果你的网站订单id不是表id，请修改这里
            'orderCurrency' => $order->info['currency'], // 货币类型
            'orderAmount'   => number_format(($order->info['total']) * $currencies->get_value($order->info['currency']), 2, '.', ''), // 订单总额
            'returnUrl'     => zen_href_link('checkout_creditcard', '', 'SSL') // 返回地址，接收支付结果
        );

        // 生成加密字符串
        $signsrc = '';

        foreach ($postParameter as $val) {
            $signsrc .= trim($val);
        }

        $signInfo = hash("sha256",$signsrc.$signkey);

        // 订单商品信息
        $count       = 0;
        $productData = array();

        foreach ($order->products as $val) {
            if ($count == 10) break;

			$productName   = strlen($val['name']) > 130 ? substr($val['name'], 0, 130) : $val['name'];
	        $productData[] = array(
	            'productName' => htmlspecialchars($productName,ENT_QUOTES),
	            'quantity'    => $val['qty'],
	            'price'       => sprintf('%.2f', $val['final_price'])
	        );

            $count++;
        }

        // 账单地址
        $billing         = $order->billing;
        $postParameter_2 = array(
            'signInfo'         => $signInfo,
            'paymentMethod'    => $this->paymentMethod, // 支付方式，传固定值
            'email'            => $order->customer['email_address'],
            'phone'            => $order->customer['telephone'],
            'firstName'        => $billing['firstname'],
            'lastName'         => $billing['lastname'],
            'country'          => $billing['country']['iso_code_2'],
            'state'            => $billing['state'], // 可为空
            'city'             => $billing['city'],
            'address'          => $billing['street_address'],
            'zip'              => $billing['postcode'] != '' ? $billing['postcode'] : '000000',
            'remark'           => $this->remark,
            'interfaceInfo='   => 'zencart',
            'interfaceVersion' => 'V1',
            'isMobile'         => $this->isMobile(),
            'goods_detail'     => !empty($productData) ? json_encode($productData) : ''
        );

        // 合并参数
        $postParameter = array_merge($postParameter,$postParameter_2);

        // 记录请求日志
        $message = "[POST]\r\n";
        $this->requestLog($message,$postParameter);

        // 生成提交表单
        $action = (MODULE_PAYMENT_CREDITCARD_MODE == 'test'? self::SANDBOX: self::DOMAIN).'/Interface/V2';

        $process_button_string  = '';
        $process_button_string .= zen_draw_form('creditcard_checkout', $action);
        foreach ($postParameter as $key => $val){
            $process_button_string .= zen_draw_hidden_field($key,$val);
        }
        $process_button_string .= '</form>';

        //$process_button_string .= '<div>You will be redirected to creditcard in a few seconds.</div>';
        $process_button_string .= '<script type = "text/javascript">document.creditcard_checkout.submit();</script>';

        return $process_button_string;
    }

    function after_process() {
        global $messageStack;

        foreach ($_POST as $key => $val){
            $postData[$key] = trim(addslashes($val));
        }

        // 获取本地的key值
        $signkey       = MODULE_PAYMENT_CREDITCARD_SIGNKEY;
        $signsrc = $postData['merNo'].$postData['gatewayNo'].$postData['tradeNo'].$postData['orderNo'].$postData['orderCurrency'].$postData['orderAmount'].$postData['orderStatus'].$postData['orderInfo'].$signkey;
        $signInfocheck = strtoupper(hash("sha256",$signsrc));

        // 日志
        if( $_POST['isPush'] == '1' ){
            $message = "[PUSH]\r\n";
        }else{
            $message = "[POST]\r\n";
        }


        $this->requestLog($message,$postData);

        //字符串校验
        if (strtolower($postData['signInfo']) == strtolower($signInfocheck)) {
            $orderStatus = $_POST['orderStatus'];

            $current_status = $this->db->Execute("SELECT orders_status FROM  " . TABLE_ORDERS  . " WHERE orders_id = '" . $postData['orderNo'] . "'");

            switch ($orderStatus){
                case '1':
                    $this->order_status = MODULE_PAYMENT_CREDITCARD_SUCCESS_STATUS_ID;
                    $messageStack->add_session('checkout_success', MODULE_PAYMENT_CREDITCARD_SUCCESS_STATUS . $_POST['orderInfo'], 'success');
                    break;
                case '-1':
                case '-2':
                    $this->order_status = MODULE_PAYMENT_CREDITCARD_WAITING_STATUS_ID;
                    $messageStack->add_session('checkout_waiting', MODULE_PAYMENT_CREDITCARD_WAITING_STATUS . $_POST['orderInfo'], 'caution');
                    break;
                case '0':
                    if( substr($postData['orderInfo'],0,5) == 'I0061' ){ // 重复订单号
                        $thisorderstatus = $current_status;
                        $this->order_status = $thisorderstatus->fields['orders_status'];
                    }else{
                        $this->order_status = MODULE_PAYMENT_CREDITCARD_FAILURE_STATUS_ID;
                    }
                    $messageStack->add_session('checkout_failure', MODULE_PAYMENT_CREDITCARD_FAILURE_STATUS . $_POST['orderInfo'], 'error');
                    break;
            }

            $comments = $message.'tradeNo: '.$postData['tradeNo'].' | orderStatus: '. $postData['orderStatus'] .' | orderInfo: '.$postData['orderInfo'];

            if( $current_status != MODULE_PAYMENT_CREDITCARD_SUCCESS_STATUS_ID ){
                $this->addOrderHistory($this->order_status,$comments);
            }

            if( $_POST['isPush'] == 1 ){
                echo 'success';
                exit();
            }

        } else {
            // 签名验证失败
            if( $_POST['isPush'] == 1 ){
                echo 'Encryption error!';
                exit();
            }
        }

        return true;
    }

    public function addOrderHistory($order_status_id = 0,$comments = ''){

	    $this->db->Execute('UPDATE '. TABLE_ORDERS .' set orders_status = "'. $order_status_id .'"  where orders_id = "'. $_POST['orderNo'] .'" ' );

        $sql_data_array = array('orders_id'         => (int)$_SESSION['order_number_created'],
            'orders_status_id'  => $order_status_id,
            'date_added'        => 'now()',
            'comments'          => $comments,
            'customer_notified' => 0
        );

        zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
    }

    // 请求处理日志
    public function requestLog($mestype,$postData){

        $filedate = date('Y-m-d');
        $postdate = date('Y-m-d H:i:s');

        if( !is_dir("asiabill_log") ){
            mkdir("asiabill_log",0777,true);
        }
        $newfile  = fopen( "asiabill_log/" . $filedate . ".log", "a+" );
        // 日志内容
        $post_log = $postdate.$mestype ;
        foreach ($postData as $key => $val){
            $post_log .= $key .' = '. $val ."\r\n";
        }
        $post_log = $post_log . "*************************************\r\n";
        $post_log = $post_log.file_get_contents( "asiabill_log/" . $filedate . ".log");

        $filename = fopen( "asiabill_log/" . $filedate . ".log", "r+" );

        fwrite($filename,$post_log);
        fclose($filename);
        fclose($newfile);
    }

    public function isMobile(){

        $is_mobile = 0;

        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $is_iphone = (strpos($agent, 'iphone')) ? true : false;
        $is_ipad = (strpos($agent, 'ipad')) ? true : false;
        $is_android = (strpos($agent, 'android')) ? true : false;

        if( $is_iphone || $is_ipad || $is_android ){
            $is_mobile = 1;
        }

        return $is_mobile;

    }


}

?>