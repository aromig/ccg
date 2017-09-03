$(document).ready(function(){
	$('a[data-toggle="pill"]').on('shown.bs.tab', function(e){
		var target = $(e.target).attr("href").substr(1) + '_';
		var prev = $(e.relatedTarget).attr("href").substr(1) + '_';
		$("#run_report").val(target);
		$('#'+target+'time').prop('required', true);
		$('#'+target+'reward').prop('required', true);
		$('#'+prev+'time').removeAttr('required');
		$('#'+prev+'reward').removeAttr('required');

		$.ajax({
			type: "POST",
			url: "report_status.php",
			data: "battle="+$(e.target).attr("href").substr(1),
			success: function(html){
				$("#status_1,#status_2,#status_3,#status_4,#status_5,#status_6,#status_7,#status_8").each(function(){
					$(this).html(html);
				});
			}
		});

		$.ajax({
			type: "POST",
			url: "report_suit.php",
			data: "battle="+$(e.target).attr("href").substr(1),
			success: function(html){
				$("#suit_1,#suit_2,#suit_3,#suit_4,#suit_5,#suit_6,#suit_7,#suit_8").each(function(){
					$(this).html(html);

		 			var ddl = $(this).prop("name");
					var ddl_val = $(this).val();
					var num = ddl.substr(ddl.lastIndexOf("_")+1);

					$.ajax({
						type: "POST",
						url: "report_suitlevel.php",
						data: "suit="+encodeURIComponent(ddl_val),
						success: function(html){
							$("#suitlevel_"+num).html(html);
						}
					});
				});
			}
		});

		if (target == 'vp_') {
			$("#skeleround_1,#skeleround_2,#skeleround_3,#skeleround_4,#skeleround_5,#skeleround_6,#skeleround_7,#skeleround_8").each(function(){
				$(this).parent().show();
			});
			$("#cleanupround_1,#cleanupround_2,#cleanupround_3,#cleanupround_4,#cleanupround_5,#cleanupround_6,#cleanupround_7,#cleanupround_8").each(function(){
				$(this).parent().hide();
				if ($(this).prop('checked')) {
					$(this).prop('checked', false);
					$(this).parent().toggleClass('active');
					$(this).blur();
				}
			});
		} else if (target == 'ceo_') {
			$("#cleanupround_1,#cleanupround_2,#cleanupround_3,#cleanupround_4,#cleanupround_5,#cleanupround_6,#cleanupround_7,#cleanupround_8").each(function(){
				$(this).parent().show();
			});
			$("#skeleround_1,#skeleround_2,#skeleround_3,#skeleround_4,#skeleround_5,#skeleround_6,#skeleround_7,#skeleround_8").each(function(){
				$(this).parent().hide();
				if ($(this).prop('checked')) {
					$(this).prop('checked', false);
					$(this).parent().toggleClass('active');
					$(this).blur();
				}
			});
		} else {
			$("#skeleround_1,#skeleround_2,#skeleround_3,#skeleround_4,#skeleround_5,#skeleround_6,#skeleround_7,#skeleround_8").each(function(){
				$(this).parent().hide();
				if ($(this).prop('checked')) {
					$(this).prop('checked', false);
					$(this).parent().toggleClass('active');
					$(this).blur();
				}
			});
			$("#cleanupround_1,#cleanupround_2,#cleanupround_3,#cleanupround_4,#cleanupround_5,#cleanupround_6,#cleanupround_7,#cleanupround_8").each(function(){
				$(this).parent().hide();
				if ($(this).prop('checked')) {
					$(this).prop('checked', false);
					$(this).parent().toggleClass('active');
					$(this).blur();
				}
			});
		}
	});

	$('input[type=submit]').click(function(){
		
	});

    $('input[type=checkbox]').change(function(){
    	var $box = $(this);
		if ($box.prop('checked')) {
			var group = "input:checkbox[name='"+$box.prop("name").substring(0, $box.prop("name").lastIndexOf("_")+1);
			var count = 0;
			for (i=1;i<=8;i++) {
				var boxname = group+i+"']";
				if ($(boxname).prop('checked')) {
					count++;
				}
			}
			if (count > 4) {
				$box.parent().tooltip({
					title: "Cannot select more than four toons for this group.",
					trigger: "click"
				}).tooltip('show');
				setTimeout(function(){$box.parent().tooltip('hide').tooltip('destroy')}, 3000);

				$box.prop('checked', false);
				$box.parent().toggleClass('active');
				$box.blur();
			}
		}
		$box.blur();
	});

	var getRunTimes = function(select_ctl) {
		var battle = select_ctl.substring(0,select_ctl.indexOf('_'));
		var date_val = $("#"+battle+"_date").val();
		var time_val = $("#"+select_ctl).val();
		var tz = $("#"+battle+"_timezone").val();
		$.ajax({
			type: "POST",
			url: "run_times.php",
			data: "battle="+battle+"&date="+date_val+"&tz="+tz,
			success: function(html){
				$("#"+select_ctl).html(html);
				$("#"+select_ctl).val(time_val);
			}
		});
	}

	var isPostBack = function() {
		return document.referrer.indexOf(document.location.href) > -1;
	}

	var  today = GetMonth() + "/" + getDate() + "/" + getFullYear();
	$("#vp_date").val(today);
	$("cfo_date").val(today);
	$("cj_date").val(today);
	$("ceo_date").val(today);

	getRunTimes("vp_time");
	getRunTimes("cfo_time");
	getRunTimes("cj_time");
	getRunTimes("ceo_time");

	$(".run_date").change(function(){
		var select_ctl = $(this).attr('id');
		var battle = select_ctl.substring(0,select_ctl.indexOf('_'));
		getRunTimes(battle+"_time");
	});

	if (!isPostBack()) {
		$(".toon_info").hide();
	} else {
		$(".toon_info").hide();
		for (i=1;i<=8;i++) {
			$("#toon_"+i).hide();
		}
		if ($("#loaded").val() != "") {
			for (i=1;i<=parseInt($("#loaded").val());i++) {
				$("#toon_"+i).show();
			}
		}
	}

	$("#loaded").change(function(){
		for (i=1;i<=8;i++) {
			$("#toon_"+i).hide();
		}
		if ($("#loaded").val() != "") {
			for (i=1;i<=parseInt($("#loaded").val());i++) {
				$("#toon_"+i).show();
			}
		}
	});
	$("#danced").change(function(){
		var danced = parseInt($("#danced").val(), 10);
		var loaded = parseInt($("#loaded").val(), 10);

		if (danced > loaded) {
			$("#danced").tooltip({
				title: "That's more toons than loaded.",
				trigger: "manual"
			}).tooltip('show');
			setTimeout(function(){$("#danced").tooltip('hide').tooltip('destroy')}, 3000);
		}
	});

	$("#report_run").submit(function(){
		var danced = parseInt($("#danced").val(), 10);
		var loaded = parseInt($("#loaded").val(), 10);

		if (danced > loaded) {
			$("#danced").tooltip({
				title: "That's more toons than loaded.",
				trigger: "manual"
			}).tooltip('show');
			setTimeout(function(){$("#danced").tooltip('hide').tooltip('destroy')}, 3000);
			return false;
		}
	});

	$(".suit").change(function(){
		var ddl = $(this).prop("name");
		var ddl_val = $(this).val();
		var num = ddl.substr(ddl.lastIndexOf("_")+1);

		$.ajax({
			type: "POST",
			url: "report_suitlevel.php",
			data: "suit="+encodeURIComponent(ddl_val),
			success: function(html){
				$("#suitlevel_"+num).html(html);
			}
		});
	});

	$("#report_copy").hide();
	$("#report_copy_btn").click(function(){
		$("#report_copy").show()
		$("#report_copy_text").focus().select();

	});

	$("#cleanupround_1,#cleanupround_2,#cleanupround_3,#cleanupround_4,#cleanupround_5,#cleanupround_6,#cleanupround_7,#cleanupround_8").each(function(){
		$(this).parent().hide();
		if ($(this).prop('checked')) {
			$(this).prop('checked', false);
			$(this).parent().toggleClass('active');
			$(this).blur();
		}
	});
});