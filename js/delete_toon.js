$(document).ready(function(){
	$(".delete_toon").click(function(){
		var toon = $(this).attr("id").split("|");
		var toon_name = toon[0];
		var toon_id = toon[1];
		$("#delete_toon_id").val(toon_id);
		$("#prompt").html('<h4 style="text-align: center;">Are you sure you want to delete<br />"'+toon_name+'"?</h4>');
		$("#delete_toon").fadeIn("normal");
	});

	$("#cancel_delete").click(function(){
		$("#delete_toon").fadeOut("normal");
	});

	$("#confirm_delete").click(function(){
		var toon_id = $("#delete_toon_id").val();
		$.ajax({
			type: "POST",
			url: "delete_toon.php",
			data: "toon_id="+toon_id,
			success: function(html) {
				if (html == 'true') {
					$("#delete_toon").fadeOut("normal");
					location.href ="profile.php";
				} else {
					$("add_err").html("Hmm... Something didn't go right...");
				}
			},
			beforeSend: function() {
				$("#add_err").html("Deleting...");
			}
		});
		return false;
	});
});