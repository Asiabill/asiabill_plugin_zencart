<div class="centerColumn" id="checkoutCtopayDefault" >
    <div style="position: relative;background:#FFF; padding: 20px; border: #000 1px solid; width: 320px;margin:100px auto 0;" id="loading">
        <img src="<?php echo DIR_WS_MODULES . 'payment/creditcard/loading_box.gif'?>"  /> Loading...Please do not refresh the page.
    </div>
    <?php echo $payment_modules->before_process(); ?>
    <script type="text/javascript">
        var ifrm_cc  = document.getElementById("ifrm_creditcard_checkout");
        var loading  = document.getElementById("loading");
        if (ifrm_cc.attachEvent){
        	ifrm_cc.attachEvent("onload", function(){
                loading.style.display = 'none';
            });
        } else {
        	ifrm_cc.onload = function(){
                loading.style.display = 'none';
            };
        }

    </script>
	<br class="clearBoth" />
</div>