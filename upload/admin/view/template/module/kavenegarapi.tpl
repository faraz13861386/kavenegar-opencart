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
    	<?php if ($error_warning) { ?>
            <div class="alert alert-danger autoSlideUp"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
             <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <?php if ($success) { ?>
            <div class="alert alert-success autoSlideUp"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <script>$('.autoSlideUp').delay(3000).fadeOut(600, function(){ $(this).show().css({'visibility':'hidden'}); }).slideUp(600);</script>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> <img src="view/template/module/kavenegarapi/logo.png" style="height: 50px;" /> <span style="vertical-align:middle;font-weight:bold;"><?php echo $heading_title; ?></span></h3>
                <div class="storeSwitcherWidget">
                	<div class="form-group">
                    	<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><?php echo $store['name']; if($store['store_id'] == 0) echo $text_default; ?>&nbsp;<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                    	<ul class="dropdown-menu" role="menu">
                        	<?php foreach ($stores  as $st) { ?>
                        		<li><a href="index.php?route=module/kavenegarapi&store_id=<?php echo $st['store_id'];?>&token=<?php echo $token; ?>"><?php echo $st['name']; ?></a></li>
                        	<?php } ?> 
                    	</ul>
                	</div>
                </div>
            </div>
            <div class="panel-body">
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form"> 
                        <input type="hidden" name="store_id" value="<?php echo $store['store_id']; ?>" />
                        <div class="tabbable">
                            <div class="tab-navigation form-inline">
                                <ul class="nav nav-tabs mainMenuTabs" id="mainTabs">
                                    <li class="active"><a href="#bulksmssend" data-toggle="tab"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;ارسال پیام</a></li>
                                    <li><a href="#actions" data-toggle="tab"><span class="fa fa-mobile"></span>&nbsp;&nbsp;اطلاع رسانی رویداد ها</a></li>
        	                        <li><a href="#main_settings" data-toggle="tab"><i class="fa fa-cogs"></i>&nbsp;&nbsp;تنظمیات</a></li>
                                    <li><a href="#support" data-toggle="tab"><i class="fa fa-ticket"></i>&nbsp;&nbsp;پشتیبانی</a></li>
                                </ul>
                                <div class="tab-buttons">
                                    <button type="submit" class="btn btn-success save-changes"><i class="fa fa-check"></i>&nbsp;<?php echo $save_changes?></button>
                                    <a onclick="location = '<?php echo $cancel; ?>'" class="btn btn-warning"><i class="fa fa-times"></i>&nbsp;<?php echo $button_cancel?></a>
                                </div> 
                            </div><!-- /.tab-navigation --> 
                            <div class="tab-content">
                                <div id="bulksmssend" class="tab-pane active"><?php require_once(DIR_APPLICATION.'view/template/module/kavenegarapi/tab_bulksmssend.php'); ?></div>
                                <div id="actions" class="tab-pane fade"><?php require_once(DIR_APPLICATION.'view/template/module/kavenegarapi/tab_actions.php'); ?></div>
                          	    <div id="main_settings" class="tab-pane fade"><?php require_once(DIR_APPLICATION.'view/template/module/kavenegarapi/tab_settings.php'); ?></div>
                                <div id="support" class="tab-pane fade"><?php require_once(DIR_APPLICATION.'view/template/module/kavenegarapi/tab_support.php'); ?></div>
                            </div> <!-- /.tab-content --> 
                        </div><!-- /.tabbable -->
                    </form>
            </div> 
        </div>
    </div>
</div>
<script type="text/javascript">
$(function() {
    $('#mainTabs a:first').tab('show'); // Select first tab
    $('#preSaleTabs a:first').tab('show'); // Select first tab

    if (window.localStorage && window.localStorage['currentTab']) {
        $('.mainMenuTabs a[href="'+window.localStorage['currentTab']+'"]').tab('show');
    }
    if (window.localStorage && window.localStorage['currentSubTab']) {
        $('a[href="'+window.localStorage['currentSubTab']+'"]').tab('show');
    }
    $('.fadeInOnLoad').css('visibility','visible');
    $('.mainMenuTabs a[data-toggle="tab"]').click(function() {
        if (window.localStorage) {
            window.localStorage['currentTab'] = $(this).attr('href');
        }
    });
    $('a[data-toggle="tab"]:not(.mainMenuTabs a[data-toggle="tab"], .followup_tabs a[data-toggle="tab"])').click(function() {
        if (window.localStorage) {
            window.localStorage['currentSubTab'] = $(this).attr('href');
        }
    });


});
function enterAPIKey() {
    $('a[href=#main_settings]').trigger('click');
    $('#APIKey').attr('autofocus','autofocus');
}
</script>
<?php echo $footer; ?>