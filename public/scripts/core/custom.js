
$(document).on("click",".datepicker",function(){
	$(this).datepicker({
    	format:"dd-mm-yyyy",
    	todayHighlight:true,
    	autoclose: true,
    });
	$(this).datepicker("show");
});

$(".check-form").validate();

$.validator.addMethod('groupno', function(value, element) {
    return (/^([0-9,]+)$/.test(value) || value == '')
}, "Allows only numbers and comma");

$.validator.addMethod('eod', function(value, element) {
	var extension = value.substr( (value.lastIndexOf('.') +1) ).toLowerCase();
    return this.optional(element) || (extension == 'eod') 
}, "Please select a valid EOD file");

$.validator.addMethod('password_pat', function(value, element) {
	return /^(?=.*\d)(?=.*[A-Z])(?=.*[~!@#$%&_^*]).{8,}$/.test(value);
}, "Password must be atleast 8 charaters long. It must contain atleast one Uppercase letter (A-Z), one special charaters ( ! @ # $ % _ ^ * & ~ ) ,and one number(0-9)");



$(document).on("click",".details",function(){
	$("#detailsModal").modal("show");
	var title = $(this).attr("data-title");
	var action = $(this).attr("action");

	$("#detailsModal .modal-title").html(title);
	$("#detailsModal .modal-body").html("Loading....");

	var formAction = base_url+"/"+action;
	console.log(action);

	$.ajax({
	    type: "GET",
	    url : formAction,
	    success : function(data){
	    	
	    	if(!data.success) bootbox.alert(data.message);
	    	else {
	    		$("#detailsModal .modal-body").html(data.message);
	    	}
	    }
	},"json");
});

$(document).on("click", ".delete-div", function() {
	var btn = $(this);

	bootbox.confirm("Are you sure?", function(result) {
      if(result) {
      	
			var initial_html = btn.html();
			btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
			var deleteDiv = btn.attr('div-id');
			
			var formAction = base_url+'/'+btn.attr('action');

			$.ajax({
			    type: "DELETE",
			    data: {
			    	_token : CSRF_TOKEN
			    },
			    url : formAction,
			    success : function(data){
			    	data = JSON.parse(data);
			    	if(!data.success) bootbox.alert(data.message);
			    	else {
			    		
			    		$("#"+deleteDiv).hide('500', function(){
			    			$("#"+deleteDiv).remove();
				    	});
				    	
			    	}
			    	btn.html(initial_html);

			    }
			},"json");
      	}
    });
});

$(document).on("click",".toggleNotificationFreeze",function(){
	var btn = $(this);

	bootbox.confirm("Are you sure?", function(result) {
      if(result) {
      	
			var initial_html = btn.html();
			btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
			var editDiv = btn.attr('div-id');
			
			var formAction = base_url+'/'+btn.attr('action');

			$.ajax({
			    type: "GET",
			    data: {
			    	_token : CSRF_TOKEN
			    },
			    url : formAction,
			    success : function(data){
			    	data = JSON.parse(data);
			    	if(!data.success) bootbox.alert(data.message);
			    	else {
			    		$("#"+editDiv).replaceWith(data.message)
			    	}
			    	btn.html(initial_html);
			    }
			},"json");
      	}
    });
});

$(document).on("click",".show-filters",function(){
	$(".filters").toggle();
});

// $(document).on("change","#dir_rem",function(){
// 	var btn = $(this);
// 	var year = btn.attr("year");
// 	console.log(year);
// 	if(btn.val()){
// 		for (var i = year; i >= year-4; i--) {
// 			$(".rem_"+i).hide();
// 			$(".rem_"+i).hide();
// 		}
// 		$(".rem_"+btn.val()).show();
// 	}
// });

$(document).on("change","#att_year",function(){
	var btn = $(this);
	$("#attendance_div").html("Loading....");
	var year = btn.val();
	var com_id = btn.attr('com-id');
	var type_id = btn.attr('type-id');
	var formAction = base_url+"/ses/notification/get-attendance/"+com_id+"/"+btn.val()+'?type_id='+type_id;

	$.ajax({
	    type: "GET",
	    url : formAction,
	    success : function(data){
	    	
	    	if(!data.success) bootbox.alert(data.message);
	    	else {
	    		$("#attendance_div").html(data.message);
	    	}
	    }
	},"json");
});

$(document).on("change","#att_type",function(){
	var btn = $(this);
	$("#attendance_div").html("Loading....");
	var com_id = btn.attr('com-id');
	var year = btn.attr('year');
	console.log(year);

	var formAction = base_url+"/ses/notification/get-attendance/"+com_id+"/"+year+'?type_id='+btn.val();

	$.ajax({
	    type: "GET",
	    url : formAction,
	    success : function(data){
	    	
	    	if(!data.success) bootbox.alert(data.message);
	    	else {
	    		$("#attendance_div").html(data.message);
				if(btn.val()){
					for (var i = 1; i <= 6; i++) {
						$(".att_"+i).hide();
						$(".att_"+i).hide();
					}
					$(".att_"+btn.val()).show();
				}

	    	}
	    }
	},"json");
});

$(document).on("change","#dir_rem",function(){
	var btn = $(this);
	$("#rem_div").html("Loading....");
	var year = btn.val();
	var com_id = btn.attr('com-id');
	var formAction = base_url+"/ses/notification/get-remuneration/"+com_id+"/"+btn.val();

	$.ajax({
	    type: "GET",
	    url : formAction,
	    success : function(data){
	    	
	    	if(!data.success) bootbox.alert(data.message);
	    	else {
	    		$("#rem_div").html(data.message);
	    	}
	    }
	},"json");
});



$(document).on("change","#com_financials",function(){
	var btn = $(this);
	$("#financial_div").html("Loading....");
	var year = btn.val();
	var com_id = btn.attr('com-id');
	var formAction = base_url+"/ses/notification/get-financial-year-wise/"+com_id+"/"+btn.val();

	$.ajax({
	    type: "GET",
	    url : formAction,
	    success : function(data){
	    	
	    	if(!data.success) bootbox.alert(data.message);
	    	else {
	    		$("#financial_div").html(data.message);
	    	}
	    }
	},"json");
});


$( function() {
    
    $( "#getProject" ).autocomplete({alert(1);
          source: function( request, response ) {
            console.log(request);
            $.ajax( {
              url: base_url+"/api/getProject",
              method: "POST",
              data: {
                term: request.term,
                _token:CSRF_TOKEN
              },
              success: function( data ) {
                response( data );
              }
            } );
          },
          minLength: 3,
          select: function( event, ui ) {
            console.log( "Selected: " + ui.item.value);
            $("input[name=com_id]").val(ui.item.com_id);
          }
        });

  } );



$(document).on("change","#board_year",function(){
	var btn = $(this);
	$("#dir_board").html("Loading....");
	var year = btn.val();
	var com_id = btn.attr('com-id');
	var formAction = base_url+"/ses/notification/directors_attendance_board/"+com_id+"/"+btn.val();

	$.ajax({
	    type: "GET",
	    url : formAction,
	    success : function(data){
	    	
	    	if(!data.success) bootbox.alert(data.message);
	    	else {
	    		$("#dir_board").html(data.message);
	    	}
	    }
	},"json");
});



$(document).on("change",".change-qtr",function(){
	var btn = $(this);

	var year = $("#com_fin").attr('year');
	
	var current_year = $("#com_fin").val();

	var qtr = $("#com_qtr").val();
	year = parseInt(year);
	for (var i = year; i >= year-4; i--) {
		console.log(i);
		for (var q = 3; q <= 12; q+=3) {
		console.log(q);
			$(".st_"+i+'_'+q).hide();
			$(".con_"+i+'_'+q).hide();
		}
	}

	$(".st_"+current_year+'_'+qtr).show();
	$(".con_"+current_year+'_'+qtr).show();

	
});

$(document).on("change",".portfolio_type",function(){

	var portfolio_type = $("select[name=portfolio_type]").val();
	console.log(portfolio_type);
	if( portfolio_type == 1 ){
		$(".portfolio_setting_div").show();
	} else {
		$(".portfolio_setting_div").hide();
	}
});

$(document).on("change",".portfolio_setting",function(){

	var portfolio_setting = $("select[name=portfolio_setting]").val();
	var portfolio_type = $("select[name=portfolio_type]").val();

	if(portfolio_setting != 1 && portfolio_type == 1 ){
		$(".restrict_pm").show();
	} else {
		$(".restrict_pm").hide();
	}
});


$(document).on("change",".self_combined",function(){

	var val = $(this).val();

	if(val == 'self'){
		$(".self_format").show();
		$(".combined_format").hide();
	} else {
		$(".self_format").hide();
		$(".combined_format").show();
	}
});


$(document).on("change","input[type=checkbox][name=check_all]",function(){

	if($(this).is(":checked")){
		$("input:checkbox").prop("checked",true);
	}else{
		$("input:checkbox").prop("checked",false);

	}
});


$('.selectize').selectize({
    create: true,
    sortField: 'text'
});

$(document).on("click", ".hide-use-da", function() {
	var btn = $(this);

	if(btn.attr('type') ==2){
		bootbox.prompt("Leave a remark for this action", function(result) {
	      if(result) {
	      	
				var initial_html = btn.html();
				btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
				var deleteDiv = btn.attr('div-id');
				
				var formAction = base_url+'/'+btn.attr('action');

				$.ajax({
				    type: "POST",
				    data: {
				    	_token : CSRF_TOKEN,
				    	remark:result
				    },
				    url : formAction,
				    success : function(data){
				    	data = JSON.parse(data);
				    	if(!data.success) bootbox.alert(data.message);
				    	else {
				    		
				    		$("#"+deleteDiv).hide('500', function(){
				    			$("#"+deleteDiv).remove();
					    	});
					    	
				    	}
				    	btn.html(initial_html);

				    }
				},"json");
	      	}
	    });
	}else{

		bootbox.confirm("Are you sure?", function(result) {
	      if(result) {
	      	
				var initial_html = btn.html();
				btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
				var deleteDiv = btn.attr('div-id');
				
				var formAction = base_url+'/'+btn.attr('action');

				$.ajax({
				    type: "POST",
				    data: {
				    	_token : CSRF_TOKEN
				    },
				    url : formAction,
				    success : function(data){
				    	data = JSON.parse(data);
				    	if(!data.success) bootbox.alert(data.message);
				    	else {
				    		
				    		$("#"+deleteDiv).hide('500', function(){
				    			$("#"+deleteDiv).remove();
					    	});
					    	
				    	}
				    	btn.html(initial_html);

				    }
				},"json");
	      	}
	    });
	}

});

$(document).on("change",".change_shareholding_view",function(){
	var qtr = $("#sh_quarter_id").val();
	var year = $("#sh_year").val();
	console.log("#tb_"+year+qtr);
	for (var i = 2030; i >= 2015; i--) {
		$("#tb_"+i+'03').hide();
		$("#tb_"+i+'06').hide();
		$("#tb_"+i+'09').hide();
		$("#tb_"+i+'12').hide();
	}

	$("#tb_"+year+qtr).show();

});

$(document).on("click",".viewShareholding",function(){
	$("#detailsModal2").modal("show");
	var title = $(this).attr("data-title");
	var action = $(this).attr("action");

	$("#detailsModal2 .modal-title").html(title);
	$("#detailsModal2 .modal-body").html("Loading....");

	var formAction = base_url+"/"+action;
	console.log(action);

	$.ajax({
	    type: "GET",
	    url : formAction,
	    success : function(data){
	    	
	    	if(!data.success) bootbox.alert(data.message);
	    	else {
	    		$("#detailsModal2 .modal-body").html(data.message);
	    	}
	    }
	},"json");
});

$(document).on("click", ".edit-div", function() {
    var btn = $(this);
	$(".modal-body").html('Loading');
    $("#detailsModal").modal('show');
    
	var initial_html = btn.html();
	editDiv = btn.attr('div-id');
	var title = btn.attr('modal-title');
	count = btn.attr('count');
	var formAction = base_url+'/'+btn.attr('action');
	$(".modal-title").html(title);
	$.ajax({
	    type: "GET",
	    url : formAction,
	    success : function(data){
	    	$(".modal-body").html(data);
	    	initialize();
	    }
	},"json");

});

function initialize(){
	
}

$(document).on('click','form.ajax_update_pop button[type=submit]', function(e){
    e.preventDefault();
    if($(".ajax_check_form").valid()){
    	var btn = $(this);
    	var initial_html = btn.html();
    	btn.html(initial_html+' <i class="fa fa-spin fa-spinner"></i>');
    	var form = jQuery(this).parents("form:first");
		var dataString = form.serialize();
		dataString = dataString+'&count='+count;
		var formAction = form.attr('action');
		$.ajax({
		    type: "PUT",
		    url : formAction,
		    data : dataString,
		    success : function(data){
		    	data = JSON.parse(data);
		    	if(data.success){
		    		if(data.message == 'remove'){
		    			$("#"+editDiv).remove();
		    		} else {

		    			$("#"+editDiv).replaceWith(data.message);
		    		}
			    	$(".modal").modal("hide");
		    	} else {
		    		bootbox.alert(data.message);
		    	}
			    btn.html(initial_html);
		    }
		},"json");
    }
});