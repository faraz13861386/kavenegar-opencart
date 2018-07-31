<table class="table">
    <tr>
        <td class="col-xs-3"><h4><span class="required">* </span><?php echo $entry_code; ?></h4></td>
        <td class="col-xs-9">
            <div class="col-xs-4">
                <select name="KavenegarApi[Enabled]" class="form-control">
                      <option value="yes" <?php echo (!empty($data['KavenegarApi']['Enabled']) && $data['KavenegarApi']['Enabled'] == 'yes') ? 'selected=selected' : '' ?>><?php echo $text_enabled; ?></option>
                      <option value="no"  <?php echo (empty($data['KavenegarApi']['Enabled']) || $data['KavenegarApi']['Enabled']== 'no') ? 'selected=selected' : '' ?>><?php echo $text_disabled; ?></option>
                </select>
            </div>
        </td>
    </tr>
    
    <tr>
        <td class="col-xs-3">
            <h4><span class="required">* </span>کلید شناسایی:</h4>
            <span class="help"><i class="fa fa-info-circle"></i>&nbsp;برای دریافت کلید شناسایی خود به  پنل کاربری خود  در سایت کاوه نگار مراجعه نمایید. panel.kavenegar.com</span>
        </td>
        <td class="col-xs-9">
            <div class="col-xs-4">
                <div class="form-group" style="padding-top:10px;">
                    <input type="text" id="APIKey" class="form-control" name="KavenegarApi[APIKey]" value="<?php if(isset($data['KavenegarApi']['APIKey'])) { echo $data['KavenegarApi']['APIKey']; } else { echo ""; }?>" />
                </div>
            </div>
        </td>
    </tr>
	 <tr>
        <td class="col-xs-3">
            <h4><span class="required">* </span>شماره ارسال کننده:</h4>
            <span class="help"><i class="fa fa-info-circle"></i>&nbsp;برای دریافت شماره خط خود به پنل کاربری خود در سایت کاوه نگار مراجعه نمایید. panel.kavenegar.com</span>
        </td>
        <td class="col-xs-9">
            <div class="col-xs-4">
                <div class="form-group" style="padding-top:10px;">
                    <input type="text" id="Sender" class="form-control" name="KavenegarApi[Sender]" value="<?php if(isset($data['KavenegarApi']['Sender'])) { echo $data['KavenegarApi']['Sender']; } else { echo ""; }?>" />
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="col-xs-3">
            <h4>شماره همراه مدیر سایت:</h4>
            <span class="help"><i class="fa fa-info-circle"></i>&nbsp;این شماره برای اطلاع رسانی ها از طریق پیامک برای مدیر سایت مورد استفاده 
		قرار میگرید.</span></td>
        <td class="col-xs-9">
            <div class="col-xs-4">
                <div class="form-group" style="padding-top:10px;">
                    <input type="text" class="form-control" name="KavenegarApi[StoreOwnerPhoneNumber]" value="<?php if(isset($data['KavenegarApi']['StoreOwnerPhoneNumber'])) { echo $data['KavenegarApi']['StoreOwnerPhoneNumber']; } else { echo ""; }?>" />
                </div>
            </div>
        </td>
    </tr>    
</table>
<script type="text/javascript">
// Display & Hide the settings
$(function() {
    var $typeSelector = $('#Check');
    var $toggleArea = $('.prefix');
	 if ($typeSelector.val() === 'yes') {
            $toggleArea.show(); 
        }
        else {
            $toggleArea.hide(); 
        }
    $typeSelector.change(function(){
        if ($typeSelector.val() === 'yes') {
            $toggleArea.show(300); 
        }
        else {
            $toggleArea.hide(300); 
        }
    });	
});
$(function() {
    var $typeSelector = $('#CheckPrefix');
    var $toggleArea = $('.strict-prefix');
	 if ($typeSelector.val() === 'yes') {
            $toggleArea.show(); 
        }
        else {
            $toggleArea.hide(); 
        }
    $typeSelector.change(function(){
        if ($typeSelector.val() === 'yes') {
            $toggleArea.show(300); 
        }
        else {
            $toggleArea.hide(300); 
        }
    });	
});
</script>