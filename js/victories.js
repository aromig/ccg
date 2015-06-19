$(document).ready(function(){
    var getRunTimes = function() {
        var battle = $("#battle_by_date").val();
        var run_date = $("#run_date").val();
        var timezone = $("#timezone_by_date").val();
        $.ajax({
            type: "POST",
            url: "run_times.php",
            data: "battle="+battle+"&date="+run_date+"&tz="+timezone,
            success: function(html){
                $("#run_time").html(html);
            }
        });
    }

    $(".run_date").change(function(){
        getRunTimes();
    });

    getRunTimes();

    $("#refresh_date").click(function(){
        var run_date = $("#run_date").val();
        var run_time = $("#run_time").val();
        var timezone = $("#timezone_by_date").val();
        var battle = $("#battle_by_date").val();
        $.ajax({
            type: "POST",
            url: "show_reports.php",
            data: "type=by_date&battle="+battle+"&date="+run_date+"&time="+run_time+"&tz="+timezone,
            success: function(html){
                $("#show_reports").html(html);
            }
        });
    });

    $("#refresh_month").click(function(){
        var run_month = $("#run_month").val();
        var timezone = $("#timezone_by_month").val();
        var battle = $("#battle_by_month").val();
        $.ajax({
            type: "POST",
            url: "show_reports.php",
            data: "type=by_month&battle="+battle+"&month="+run_month+"&tz="+timezone,
            success: function(html){
                $("#show_reports").html(html);
            }
        });
    });
});