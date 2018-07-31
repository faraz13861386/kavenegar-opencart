<div class="form-group clearfix">
    <label class="col-sm-2 control-label" for="input-tag2">
			میزان شارژ
    </label>
    <div class="col-sm-10">
        <span id="remaincredit"> <?php echo $remaincredit; ?></span>
    </div>
</div>
<div class="form-group clearfix">
    <label class="col-sm-2 control-label" for="input-tag2">
			دریافت کننده
    </label>
    <div class="col-sm-10">
        <select name="to" class="form-control">
            <option value="customer_all">همه مشتریان</option>
            <option value="customer">مشتریان خاص</option>
            <option value="telephones">افزودن شماره</option>
            <option value="product">مشتریانی که محصول خاصی را خریداری کرده اند</option>
            <option value="customer_group">گروه مشتریان</option>
            <option value="newsletter">همه مشترکین خبرنامه</option>
            <option value="affiliate_all">همه بازاریاب ها</option>
            <option value="affiliate">بازاریاب های خاص</option>
        </select>
    </div>
</div>
<div id="to-customer-group" class="to form-group clearfix">
    <label class="col-sm-2 control-label" for="input-tag2">
			گروه مشتریان
    </label>
    <div class="col-sm-10">
        <select class="form-control" name="customer_group_id">
            <?php foreach ($customer_groups as $customer_group) { ?>
                <option value="<?php echo $customer_group['customer_group_id']; ?>">
                    <?php echo $customer_group['name']; ?>
                </option>
                <?php } ?>
        </select>
    </div>
</div>
<div id="mail">
    <div id="to-telephones" class="to form-group clearfix">
        <label class="col-sm-2 control-label" for="input-tag2">
            شماره
        </label>
        <div class="col-sm-10">
		<div class="input-group"> 
            <input type="text" name="telephones" value="" class="form-control" />
			<span class="input-group-btn"> 
                <a class="btn btn-primary" onclick="addTelephone()">افزودن</a>
			</span> 
		</div>
			<div id="telephone" class="scrollbox form-control" style="height:100px;"></div>
		</div>
    </div>
    <div id="to-customer" class="to form-group clearfix">
        <label class="col-sm-2 control-label" for="input-tag2">
            مشتری
        </label>
        <div class="col-sm-10">
            <input type="text" name="customers" value="" class="form-control" />
			<div id="customer" class="scrollbox form-control" style="height:100px;"></div>
        </div>
    </div>
    <div id="to-affiliate" class="to form-group clearfix">
        <label class="col-sm-2 control-label" for="input-tag2">
            بازاریاب
        </label>
        <div class="col-sm-10">
            <input type="text" name="affiliates" value="" class="form-control" />
			<div id="affiliate" class="scrollbox form-control" style="height:100px;"></div>
        </div>
    </div>
    <div id="to-product" class="to form-group clearfix">
        <label class="col-sm-2 control-label" for="input-tag2">
            محصولات
        </label>
        <div class="col-sm-10">
            <input type="text" name="products" value="" class="form-control" />
			<div id="product" class="scrollbox form-control" style="height:100px;"></div>
        </div>
    </div>
</div>
<div id="" class="form-group clearfix">
    <label class="col-sm-2 control-label" for="input-tag2">
        <strong> متن پیام:</strong>
    </label>
    <div class="col-sm-10">
        <textarea name="message" id="count_me" class="form-control" rows="4"></textarea>
    </div>
</div>
<div id="" class="form-group clearfix">
    <label class="col-sm-2 control-label" for="input-tag2">
		
	</label>
    <div class="col-sm-10">
		<div class="buttons">
            <a id="button-send" onclick="send('index.php?route=module/kavenegarapi/send&token=<?php echo $token; ?>');" class="btn btn-success btn-lg">ارسال پیام</a>
        </div>        
	</div>
</div>




<script type="text/javascript">
    <!--
    function toMoneyFormat(number) {
        var number = number.toString(),
            number = number.split('').reverse().join('')
            .replace(/(\d{3}(?!$))/g, '$1,')
            .split('').reverse().join('');
        return number + ' ریال ';
    }
    $.ajax({
        url: 'index.php?route=module/kavenegarapi/remaincredit&token=<?php echo $token; ?>',
        type: "POST",
        dataType: 'json',
        success: function(result) {
            if (result.return.status == 200)
                $('#remaincredit').html(toMoneyFormat(result.entries.remaincredit));
        }
    });
    addSMSCounter("count_me");

    $('select[name=\'to\']').bind('change', function() {
        $('#mail .to').hide();
        $('#mail #to-' + $(this).children('option:selected').attr('value').replace('_', '-')).show();
    });

    $('select[name=\'to\']').trigger('change');

    $('input[name=\'customers\']').autocomplete({
        delay: 500,
        source: function(request, response) {
            $.ajax({
                url: 'index.php?route=sale/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
                dataType: 'json',
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            category: item.customer_group,
                            label: item.name,
                            value: item.customer_id
                        }
                    }));
                }
            });

        },
        select: function(event, ui) {

            $('#customer' + ui.item.value).remove();

            $('#customer').append('<div id="customer' + ui.item.value + '">' + '<i class="fa fa-minus-circle"></i> ' + ui.item.label + '<input type="hidden" name="customer[]" value="' + ui.item.value + '" /></div>');

            $('#customer div:odd').attr('class', 'odd');
            $('#customer div:even').attr('class', 'even');

            return false;
        },
        focus: function(event, ui) {
            return false;
        }
    });

    $('#customer').delegate('.fa-minus-circle', 'click', function() {
        $(this).parent().remove();

        $('#customer div:odd').attr('class', 'odd');
        $('#customer div:even').attr('class', 'even');
    });


    $('input[name=\'affiliates\']').autocomplete({
        delay: 500,
        source: function(request, response) {
            $.ajax({
                url: 'index.php?route=marketing/affiliate/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
                dataType: 'json',
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            label: item.name,
                            value: item.affiliate_id
                        }
                    }));
                }
            });

        },
        select: function(event, ui) {
            $('#affiliate' + ui.item.value).remove();

            $('#affiliate').append('<div id="affiliate' + ui.item.value + '"><i class="fa fa-minus-circle"></i> ' + ui.item.label + '<input type="hidden" name="affiliate[]" value="' + ui.item.value + '" /></div>');

            $('#affiliate div:odd').attr('class', 'odd');
            $('#affiliate div:even').attr('class', 'even');

            return false;
        },
        focus: function(event, ui) {
            return false;
        }
    });

    $('#affiliate').delegate('.fa-minus-circle', 'click', function() {
        $(this).parent().remove();

        $('#affiliate div:odd').attr('class', 'odd');
        $('#affiliate div:even').attr('class', 'even');
    });

    $('input[name=\'products\']').autocomplete({
        delay: 500,
        source: function(request, response) {
            $.ajax({
                url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
                dataType: 'json',
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            label: item.name,
                            value: item.product_id
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
            $('#product' + ui.item.value).remove();

            $('#product').append('<div id="product' + ui.item.value + '"><i class="fa fa-minus-circle"></i> ' + ui.item.label + '<input type="hidden" name="product[]" value="' + ui.item.value + '" /></div>');

            $('#product div:odd').attr('class', 'odd');
            $('#product div:even').attr('class', 'even');

            return false;
        },
        focus: function(event, ui) {
            return false;
        }
    });

    $('#product').delegate('.fa-minus-circle', 'click', function() {
        $(this).parent().remove();

        $('#product div:odd').attr('class', 'odd');
        $('#product div:even').attr('class', 'even');
    });

    $(function() {
        var $typeSelector = $('#type');
        var $toggleArea = $('#mms-media');
        $toggleArea.hide();
        $typeSelector.change(function() {
            if ($typeSelector.val() === 'mms') {
                $toggleArea.show(400);
            } else {
                $toggleArea.hide(400);
            }
        });
    });

    var number = 0;

    function addTelephone() {
        if ($('input[name=\'telephones\']').val()) {
            $('#telephone').append('<div id="telephone' + number + '">' + '<i class="fa fa-minus-circle"></i> ' + $('input[name=\'telephones\']').val() + '<input type="hidden" name="phones[]" value="' + $('input[name=\'telephones\']').val() + '" /></div>');
            number++;
            $('#telephone div:odd').attr('class', 'odd');
            $('#telephone div:even').attr('class', 'even');

            $('input[name=\'telephones\']').val('');
        }
    }

    $('#telephone').delegate('.fa-minus-circle', 'click', function() {
        $(this).parent().remove();

        $('#telephone div:odd').attr('class', 'odd');
        $('#telephone div:even').attr('class', 'even');
    });

    function send(url) {
        $.ajax({
            url: url,
            type: 'post',
            data: $('#bulksmssend select,#bulksmssend input,#bulksmssend textarea'),
            dataType: 'json',
            beforeSend: function() {
                $('#button-send').attr('disabled', true);
                $('#myModal').modal('show');
				$('#myModal #modal-message h4').html('این پنجره تا زمانی که اسکریپت به پایان نرسیده نبندید . در غیر این صورت پیام ها را به تمام مشتریان ارسال نمی شود .');
            },
            complete: function() {
                $('#button-send').attr('disabled', false);
            },
            success: function(result) {
                $('#myModal .modal-body .alert.alert-success, #myModal .modal-body alert.alert.danger').remove();
                if (result.return.status != 200) {
                    $('#myModal #modal-message h4').html('<div class="alert alert-danger" style="display: none;">' + result.return.message + '</div>');
                    $('#myModal .modal-body .alert.alert-danger').fadeIn('slow');
                } else {
                    $('#myModal #modal-message h4').html('<div class="alert alert-success" style="display: none;">' + result.return.message + '</div>');
                    $('#myModal .modal-body .alert.alert-success').fadeIn('slow');

                }

            }
        });
    }

    //-->
</script>





<div id="myModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ارسال پیام</h4>
      </div>
      <div class="modal-body">
      	<div id="modal-message">
		 <h4>
		</h4>
		</div>
		<br />       
      </div>
	 <div class="modal-footer">
        <button type="button" class="btn btn-default" id="myModalClose" data-dismiss="modal">خروج</button>
	 </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->









