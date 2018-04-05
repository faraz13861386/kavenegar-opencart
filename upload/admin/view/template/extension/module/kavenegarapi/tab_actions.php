<div class="row">
  <div class="col-md-3">
    <ul class="nav nav-pills nav-stacked" id="preSaleTabs">
        <h4 style="line-height: 22px;"><span class="fa fa-minus"></span>&nbsp;مشتریان</h4>
        <li><input id="Check_CustomerPlaceOrder" type="checkbox" class="optionsKavenegarApi" <?php echo (!empty($data['KavenegarApi']['CustomerPlaceOrder']['Enabled']) && $data['KavenegarApi']['CustomerPlaceOrder']['Enabled'] == 'yes') ? 'checked="checked"' : '' ?> /><a href="#customerOrder" data-toggle="tab"><span class="pillLink">ثبت سفارش جدید</span></a></li>
        <li><input id="Check_OrderStatusChange" type="checkbox" class="optionsKavenegarApi" <?php echo (!empty($data['KavenegarApi']['OrderStatusChange']['Enabled']) && $data['KavenegarApi']['OrderStatusChange']['Enabled'] == 'yes') ? 'checked="checked"' : '' ?> /><a href="#orderStatusChange" data-toggle="tab"><span class="pillLink">تغییر وضعیت سفارش</span></a></li>
        <li><input id="Check_CustomerRegister" type="checkbox" class="optionsKavenegarApi" <?php echo (!empty($data['KavenegarApi']['CustomerRegister']['Enabled']) && $data['KavenegarApi']['CustomerRegister']['Enabled'] == 'yes') ? 'checked="checked"' : '' ?> /><a href="#customerRegister" data-toggle="tab"><span class="pillLink">هنگام ثبت نام</span></a></li>
		<h4 style="line-height: 22px;"><span class="fa fa-minus"></span>&nbsp;مدیر</h4>
        <li><input id="Check_AdminPlaceOrder" type="checkbox" class="optionsKavenegarApi" <?php echo (!empty($data['KavenegarApi']['AdminPlaceOrder']['Enabled']) && $data['KavenegarApi']['AdminPlaceOrder']['Enabled'] == 'yes') ? 'checked="checked"' : '' ?> /><a href="#customerOrderAdmin" data-toggle="tab"><span class="pillLink">ثبت سفارش جدید</span></a></li>
        <li><input id="Check_AdminRegister" type="checkbox" class="optionsKavenegarApi" <?php echo (!empty($data['KavenegarApi']['AdminRegister']['Enabled']) && $data['KavenegarApi']['AdminRegister']['Enabled'] == 'yes') ? 'checked="checked"' : '' ?> /><a href="#customerRegisterAdmin" data-toggle="tab"><span class="pillLink">هنگام ثبت نام</span></a></li>
        <br /><br />
         <li><a href="#customEvent" data-toggle="tab"><span class="pillLink">رویداد های سفارشی</span></a></li>
    </ul>
  </div>
  <div class="col-md-9">
  <div class="tab-content">
    <div id="customerOrder" class="tab-pane fade">
        <table class="table">
            <tr>
                <td class="col-xs-2"><h5>وضعیت:</h5></td>
                <td class="col-xs-10">
                    <div class="col-xs-3">
                        <select name="KavenegarApi[CustomerPlaceOrder][Enabled]" class="form-control">
                              <option value="yes" <?php echo (!empty($data['KavenegarApi']['CustomerPlaceOrder']['Enabled']) && $data['KavenegarApi']['CustomerPlaceOrder']['Enabled'] == 'yes') ? 'selected=selected' : '' ?>><?php echo $text_enabled; ?></option>
                              <option value="no"  <?php echo (empty($data['KavenegarApi']['CustomerPlaceOrder']['Enabled']) || $data['KavenegarApi']['CustomerPlaceOrder']['Enabled']== 'no') ? 'selected=selected' : '' ?>><?php echo $text_disabled; ?></option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="col-xs-2"><h5>پیام:</h5><span class="help">کد کوتاه:<br/>{SiteName} - نام فروشگاه <br/>{OrderID} -  شناسه خرید<br/>{CartTotal} - هزینه خرید</span></td>
                <td class="col-xs-10">
                    <div class="col-xs-12">
                        <ul class="nav nav-tabs">
                          <?php $class="active";  foreach ($languages as $language) {
    ?>
                              <li class="<?php echo $class; ?>"><a href="#tabOrder-<?php echo $language['language_id']; ?>" data-toggle="tab">
							  <?php echo $language['name']; ?></a></li>
                          <?php  $class="";
}?>
                        </ul>
                        
                        <div class="tab-content">
                            <?php $class=" active"; foreach ($languages as $language) {
    ?>
                              <div id="tabOrder-<?php echo $language['language_id']; ?>" language-id="<?php echo $language['language_id']; ?>" class="row-fluid tab-pane<?php echo $class; ?> language">
                                    <br /><textarea rows="3" class="form-control" name="KavenegarApi[CustomerPlaceOrderText][<?php echo $language['language_id']; ?>]"><?php if (!empty($data['KavenegarApi']['CustomerPlaceOrderText'][$language['language_id']])) {
        echo $data['KavenegarApi']['CustomerPlaceOrderText'][$language['language_id']];
    } else {
        echo '{SiteName}&#13;';
        echo'با تشکر برای خرید شما.'.'&#13';
        echo'شناسه خرید شما'.'&#13';
        echo '{OrderID}';
    } ?></textarea>
                              </div>
                            <?php $class="";
} ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    
    <div id="orderStatusChange" class="tab-pane fade">
        <table class="table">
            <tr>
                <td class="col-xs-2"><h5>وضعیت:</h5></td>
                <td class="col-xs-10">
                    <div class="col-xs-3">
                        <select name="KavenegarApi[OrderStatusChange][Enabled]" class="form-control">
                              <option value="yes" <?php echo (!empty($data['KavenegarApi']['OrderStatusChange']['Enabled']) && $data['KavenegarApi']['OrderStatusChange']['Enabled'] == 'yes') ? 'selected=selected' : '' ?>><?php echo $text_enabled; ?></option>
                              <option value="no"  <?php echo (empty($data['KavenegarApi']['OrderStatusChange']['Enabled']) || $data['KavenegarApi']['OrderStatusChange']['Enabled']== 'no') ? 'selected=selected' : '' ?>><?php echo $text_disabled; ?></option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="col-xs-2">
                  <h5>وضعیت سفارش ها:</h5>
                  <span class="help">با انتخاب هریک از تغییروضعیت های سفارش یک پیامک اطلاع رسانی برای مشتری ارسال میشود.</span>
                </td>
                <td class="col-xs-10">
                    <div class="col-xs-3">
                        <?php foreach ($order_statuses as $order_statuses) {
    ?>
                        <div class="orderStatuses checkbox">
                          <label><input type="checkbox" <?php if (!empty($data['KavenegarApi']['OrderStatusChange']['OrderStatus']) && in_array($order_statuses['order_status_id'], $data['KavenegarApi']['OrderStatusChange']['OrderStatus'])) {
        echo "checked=checked";
    } ?> name="KavenegarApi[OrderStatusChange][OrderStatus][]" value="<?php echo $order_statuses['order_status_id']; ?>"><?php echo $order_statuses['name']; ?></label>
                        </div> <?php
} ?>
                        <a id="selectall" href="#">انتخاب همه</a> | <a id="deselectall" href="#">عدم انتخاب همه</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="col-xs-2"><h5>پیام:</h5><span class="help">کد کوتاه:<br/>{Status1} - اولین تغییر وضعیت سفارش<br/>{Status2} - دومین  تغییر وضعیت سفارش<br/>{SiteName} - نام فروشگاه<br/>{OrderID} - ش {Status}. سفارش شما با شناسه خرید ({OrderID})در {SiteName} به وضعیت {Status} بروزرسانی شد</span></td>
                <td class="col-xs-10">
					<div class="col-xs-12">
                        <ul class="nav nav-tabs">
                          <?php $class="active";  foreach ($languages as $language) {
        ?>
                              <li class="<?php echo $class; ?>"><a href="#tabOrderChange-<?php echo $language['language_id']; ?>" data-toggle="tab">

							  <?php echo $language['name']; ?></a></li>
                          <?php  $class="";
    }?>
                        </ul>
                        
                        <div class="tab-content">
                            <?php $class=" active"; foreach ($languages as $language) {
        ?>
                              <div id="tabOrderChange-<?php echo $language['language_id']; ?>" language-id="<?php echo $language['language_id']; ?>" class="row-fluid tab-pane<?php echo $class; ?> language">
                                    <br /><textarea rows="3" class="form-control" name="KavenegarApi[OrderStatusChangeText][<?php echo $language['language_id']; ?>]"><?php if (!empty($data['KavenegarApi']['OrderStatusChangeText'][$language['language_id']])) {
            echo $data['KavenegarApi']['OrderStatusChangeText'][$language['language_id']];
        } else {
            echo ' {Status}. سفارش شما با شناسه خرید ({OrderID})در {SiteName} به وضعیت {Status} بروزرسانی شد';
        } ?></textarea>
                              </div>
                            <?php $class="";
    } ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    
    <div id="customerRegister" class="tab-pane fade">
        <table class="table">
            <tr>
                <td class="col-xs-2"><h5>وضعیت:</h5></td>
                <td class="col-xs-10">
                    <div class="col-xs-3">
                        <select name="KavenegarApi[CustomerRegister][Enabled]" class="form-control">
                              <option value="yes" <?php echo (!empty($data['KavenegarApi']['CustomerRegister']['Enabled']) && $data['KavenegarApi']['CustomerRegister']['Enabled'] == 'yes') ? 'selected=selected' : '' ?>><?php echo $text_enabled; ?></option>
                              <option value="no"  <?php echo (empty($data['KavenegarApi']['CustomerRegister']['Enabled']) || $data['KavenegarApi']['CustomerRegister']['Enabled']== 'no') ? 'selected=selected' : '' ?>><?php echo $text_disabled; ?></option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="col-xs-2"><h5>متن پیام:</h5><span class="help"> کد کوتاه:<br/>{SiteName} - نام فروشگاه<br/>{CustomerName} - نام مشتری</span></td>
                <td class="col-xs-10">
                    <div class="col-xs-12">
                        <ul class="nav nav-tabs mainMenuTabs">
                          <?php $class="active";  foreach ($languages as $language) {
        ?>
                              <li class="<?php echo $class; ?>"><a href="#tabSignup-<?php echo $language['language_id']; ?>" data-toggle="tab">

							  <?php echo $language['name']; ?></a></li>
                          <?php  $class="";
    }?>
                        </ul>
                        
                        <div class="tab-content">
                            <?php $class=" active"; foreach ($languages as $language) {
        ?>
                              <div id="tabSignup-<?php echo $language['language_id']; ?>" language-id="<?php echo $language['language_id']; ?>" class="row-fluid tab-pane<?php echo $class; ?> language">
                                    <br /><textarea rows="3" class="form-control" name="KavenegarApi[CustomerRegisterText][<?php echo $language['language_id']; ?>]"><?php if (!empty($data['KavenegarApi']['CustomerRegisterText'][$language['language_id']])) {
            echo $data['KavenegarApi']['CustomerRegisterText'][$language['language_id']];
        } else {
            echo '';
        } ?></textarea>
                              </div>
                            <?php $class="";
    } ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    
    <div id="customerOrderAdmin" class="tab-pane fade">
        <table class="table">
            <tr>
                <td class="col-xs-2"><h5>وضعیت:</h5></td>
                <td class="col-xs-10">
                    <div class="col-xs-3">
                        <select name="KavenegarApi[AdminPlaceOrder][Enabled]" class="form-control">
                              <option value="yes" <?php echo (!empty($data['KavenegarApi']['AdminPlaceOrder']['Enabled']) && $data['KavenegarApi']['AdminPlaceOrder']['Enabled'] == 'yes') ? 'selected=selected' : '' ?>><?php echo $text_enabled; ?></option>
                              <option value="no"  <?php echo (empty($data['KavenegarApi']['AdminPlaceOrder']['Enabled']) || $data['KavenegarApi']['AdminPlaceOrder']['Enabled']== 'no') ? 'selected=selected' : '' ?>><?php echo $text_disabled; ?></option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="col-xs-2"><h5>متن پیام:</h5><span class="help">کد کوتاه:<br/>{SiteName} - نام فروشگاه<br/>{OrderID} - شناسه سفارش<br/>{CartTotal} - جمع کل<br/>{Telephone} -شماره تماس مشتری<br/> {ShippingAddress} - آدرس مشتری<br/> {NameProducts} - نام محصولات<br/></span></td>
                <td class="col-xs-10">
                    <div class="col-xs-12">
                        <br /><textarea rows="3" class="form-control" name="KavenegarApi[AdminPlaceOrderText]"><?php if (!empty($data['KavenegarApi']['AdminPlaceOrderText'])) {
        echo $data['KavenegarApi']['AdminPlaceOrderText'];
    } else {
        echo 'یک سفارش جدید با شناسه {OrderID}  در فروشگاه  {SiteName} ثبت شد';
    } ?></textarea>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    
    <div id="customerRegisterAdmin" class="tab-pane fade">
        <table class="table">
            <tr>
                <td class="col-xs-2"><h5>وضعیت:</h5></td>
                <td class="col-xs-10">
                    <div class="col-xs-3">
                        <select name="KavenegarApi[AdminRegister][Enabled]" class="form-control">
                              <option value="yes" <?php echo (!empty($data['KavenegarApi']['AdminRegister']['Enabled']) && $data['KavenegarApi']['AdminRegister']['Enabled'] == 'yes') ? 'selected=selected' : '' ?>><?php echo $text_enabled; ?></option>
                              <option value="no"  <?php echo (empty($data['KavenegarApi']['AdminRegister']['Enabled']) || $data['KavenegarApi']['AdminRegister']['Enabled']== 'no') ? 'selected=selected' : '' ?>><?php echo $text_disabled; ?></option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="col-xs-2"><h5>متن پیام:</h5><span class="help">کد کوتاه:<br/>{SiteName} - نام فروشگاه<br/>{CustomerName} - نام مشتری</span></td>
                <td class="col-xs-10">
                    <div class="col-xs-12">
                        <br /><textarea rows="3" class="form-control" name="KavenegarApi[AdminRegisterText]"><?php if (!empty($data['KavenegarApi']['AdminRegisterText'])) {
        echo $data['KavenegarApi']['AdminRegisterText'];
    } else {
        echo 'سلام، {CustomerName} در فروشگاه ثبت نام کرد';
    } ?></textarea>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    
    <div id="customEvent" class="tab-pane fade">
     	<div class="col-xs-9">
            <h4> 
			
			با اضافه کردن کد زیر در هر رویداد سفارشی میتوانید پیام ارسال نمایید
			
			</h4><br />

<pre style="direction:ltr">&lt;?php
$this<span style="color:#00f">-></span>load<span style="color:#00f">-></span>model(<span style="color:#093">'extension/module/KavenegarApi'</span>); <span style="color:#06f;font-style:italic">// Load the model for KavenegarApi </span>
$KavenegarApi <span style="color:#00f">=</span> $this<span style="color:#00f">-></span>model_module_KavenegarApi<span style="color:#00f">-></span>getSetting(<span style="color:#093">'KavenegarApi'</span>, $this<span style="color:#00f">-></span>config<span style="color:#00f">-></span>get(<span style="color:#093">'store_id'</span>)); <span style="color:#06f;font-style:italic">// Load the settings for KavenegarApi</span>
$this<span style="color:#00f">-></span>load<span style="color:#00f">-></span>library(<span style="color:#093">'KavenegarApi'</span>); <span style="color:#06f;font-style:italic">// Load the library for the KavenegarApi API</span>

<span style="color:#33f;font-weight:700">KavenegarApi</span><span style="color:#00f">::</span>sendMessage(<span style="color:#33f;font-weight:700">array</span>(
    <span style="color:#093">'APIKey'</span> <span style="color:#00f">=></span> $KavenegarApi[<span style="color:#093">'KavenegarApi'</span>][<span style="color:#093">'APIKey'</span>], <span style="color:#06f;font-style:italic">// KavenegarApi API</span>
    <span style="color:#093">'receptor'</span> <span style="color:#00f">=></span> <span style="color:#093">'Selected_Phone_Number'</span>, <span style="color:#06f;font-style:italic">// The phone number which will receive the SMS</span>
    <span style="color:#093">'Sender'</span> <span style="color:#00f">=></span> $KavenegarApi[<span style="color:#093">'KavenegarApi'</span>][<span style="color:#093">'Sender'</span>], <span style="color:#06f;font-style:italic">// Sender who will be sent the SMS</span>
    <span style="color:#093">'message'</span> <span style="color:#00f">=></span> <span style="color:#093">'Your_Message'</span>, <span style="color:#06f;font-style:italic">// The message that will be received</span>
    <span style="color:#093">'callback'</span> <span style="color:#00f">=></span> <span style="color:#33f;font-weight:700">array</span>(<span style="color:#093">'ModelModuleKavenegarApi'</span>, <span style="color:#093">'KavenegarApiCallback'</span>) <span style="color:#06f;font-style:italic">// Callback function</span>
));
?>
</pre>

        </div>
    </div>
    
   </div>
  </div>
</div>
<script>
$('#selectall').click(function(event) {  //on click 
    event.preventDefault();
    event.stopPropagation();

    $('.orderStatuses.checkbox input').each(function() {
        this.checked = true;          
    });
});

$('#deselectall').click(function(event) {  //on click 
    event.preventDefault();
    event.stopPropagation();
    
    $('.orderStatuses.checkbox input').each(function() {
        this.checked = false;          
    });
});

$( "input[id='Check_CustomerPlaceOrder']" ).change(function() {
  var isChecked = $(this).is(':checked');
  if (isChecked) {
	$('[name="KavenegarApi[CustomerPlaceOrder][Enabled]"] option[value="yes"]').prop('selected', 'selected');  
  } else {
	$('[name="KavenegarApi[CustomerPlaceOrder][Enabled]"] option[value="no"]').prop('selected', 'selected');   
  }
});

$( "input[id='Check_OrderStatusChange']" ).change(function() {
  var isChecked = $(this).is(':checked');
  if (isChecked) {
	$('[name="KavenegarApi[OrderStatusChange][Enabled]"] option[value="yes"]').prop('selected', 'selected');  
  } else {
	$('[name="KavenegarApi[OrderStatusChange][Enabled]"] option[value="no"]').prop('selected', 'selected');   
  }
});

$( "input[id='Check_CustomerRegister']" ).change(function() {
  var isChecked = $(this).is(':checked');
  if (isChecked) {
	$('[name="KavenegarApi[CustomerRegister][Enabled]"] option[value="yes"]').prop('selected', 'selected');  
  } else {
	$('[name="KavenegarApi[CustomerRegister][Enabled]"] option[value="no"]').prop('selected', 'selected');   
  }
});

$( "input[id='Check_AdminPlaceOrder']" ).change(function() {
  var isChecked = $(this).is(':checked');
  if (isChecked) {
	$('[name="KavenegarApi[AdminPlaceOrder][Enabled]"] option[value="yes"]').prop('selected', 'selected');  
  } else {
	$('[name="KavenegarApi[AdminPlaceOrder][Enabled]"] option[value="no"]').prop('selected', 'selected');   
  }
});

$( "input[id='Check_AdminRegister']" ).change(function() {
  var isChecked = $(this).is(':checked');
  if (isChecked) {
	$('[name="KavenegarApi[AdminRegister][Enabled]"] option[value="yes"]').prop('selected', 'selected');  
  } else {
	$('[name="KavenegarApi[AdminRegister][Enabled]"] option[value="no"]').prop('selected', 'selected');   
  }
});
</script>