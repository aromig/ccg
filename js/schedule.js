$(document).ready(function(){
	var getRunSchedule = function(day) {
		//var day = $("#schedule_day option:selected").val();
		$.ajax({
			type: "POST",
			url: "run_schedule.php",
			data: "day="+day,
			success: function(html){
				$("#schedule_info").html(html);
			}
		});	
	}

	var weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
	var d = new Date();
	var today = weekday[d.getDay()];
	$("#schedule_day").val(today);

	getRunSchedule(today);

	$("#schedule_day").change(function(){
		getRunSchedule($("#schedule_day option:selected").val());
	});
});