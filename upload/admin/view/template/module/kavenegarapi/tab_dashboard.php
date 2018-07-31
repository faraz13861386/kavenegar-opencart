<?php if ( !isset($data['KavenegarApi']['APIKey']) || (empty($data['KavenegarApi']['APIKey'])) ) { 
	echo '<div class="alert alert-danger fade in">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4>Missing API key!</h4>
	<p>In order to use '.$heading_title.', you have to enter your API key. By that you ensure proper functioning of the module.</p>
	<div style="height:5px;"></div>
		<button type="button" onclick="enterAPIKey()" class="btn btn-danger">Click to enter your API key</button>
		<a href="http://KavenegarApi.com" target="_blank" class="btn btn-default">Go to KavenegarApi.com to get a key</a>

	</div>';
} else { ?>
	<iframe id="frame" style="width: 100%;height:900px" frameBorder="0" hspace="0" vspace="0" marginheight="0" marginwidth="0" align="top" src="http://KavenegarApi.com/apps/ext/<?php echo $data['KavenegarApi']['APIKey'] ?>"></iframe>
<?php } ?>
<script>
	function enterAPIKey() {
		$('a[href=#main_settings]').trigger('click');
		$('#APIKey').attr('autofocus','autofocus');
	}
</script>