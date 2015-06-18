$(document).ready(function(){
    var getRunTimes = function() {
        var battle = $("#battle").val();
        var run_date = $("#run_date").val();
        var timezone = $("#timezone").val();
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

    $("#refresh").click(function(){
        var run_date = $("#run_date").val();
        var run_time = $("#run_time").val();
        var timezone = $("#timezone").val();
        var battle = $("#battle").val();
        $.ajax({
            type: "POST",
            url: "show_reports.php",
            data: "battle="+battle+"&date="+run_date+"&time="+run_time+"&tz="+timezone,
            success: function(html){
                $("#show_reports").html(html);
            }
        });
    });
});