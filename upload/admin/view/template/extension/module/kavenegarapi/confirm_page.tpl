<?php echo $header;?>
<?php echo $column_left;?>

<div id="content">
    <div class="page-header">
        <div class="container-fluid">
          <h1><i class="fa fa-mobile"></i>&nbsp;<?php echo $heading_title; ?></h1>
          <ul class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
            <?php } ?>
          </ul>

        </div>
    </div>
    <div class="container-fluid">
        <?php if ($success) { ?>
            <div class="alert alert-success autoSlideUp"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <script>$('.autoSlideUp').delay(3000).fadeOut(600, function(){ $(this).show().css({'visibility':'hidden'}); }).slideUp(600);</script>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> <img src="view/template/extension/module/kavenegarapi/kavenegarapi.logo.small.png" /> <span style="vertical-align:middle;font-weight:bold;"><?php echo $heading_title; ?></span></h3>
                <div class="storeSwitcherWidget">
                	
                </div>
            </div>
            <div class="panel-body">
                <form class="form-default" id="settings-form" action="<?= $confirm ?>" method="post">
                	<div class="login_form">
                    	<h3>Confirm</h3>
                        <input name="confirm_code" type="text" class="form-control" placeholder="Verification code"/>
                        <div class="e e-submit">
                        	<button type="submit" class="btn btn-primary" id="login-form-submit" value="Confirm">Confirm</button>
                        </div>
                    </div>
                    <input name="store_id" type="hidden" class="form-control" value="<?= $store_id ?>">
                    <input name="login_email" type="hidden" class="form-control" value="<?= $email ?>">
                    <input name="login_phone" type="hidden" class="form-control" value="<?= $phone ?>">
                </form>
    			<div class="box-heading" style="text-align:center">
                    <h5>This service is provided by <a href="http://kavenegarapi.com" target="_blank"><img src="view/template/extension/module/kavenegarapi/kavenegarapi.logo.png" style="max-height:19px;" /></a></h5>
                </div>

            </div> 
        </div>
    </div>
</div>
<?php echo $footer; ?>