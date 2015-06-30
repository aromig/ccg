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
    
    $("#closeEdit").click(function() {
        $("#edit_report").fadeOut("normal");
    });

    var getEditRunTimes = function(select_ctl, report_value) {
        var battle = $("#edit_battle").val();
        var date_val = $("#edit_date").val();
        var time_val = (report_value == '') ? $("#edit_time").val() : report_value;
        var tz = $("#edit_timezone").val();
        $.ajax({
            type: "POST",
            url: "run_times.php",
            data: "battle="+battle+"&date="+date_val+"&tz="+tz,
            success: function(html){
                $("#"+select_ctl).html(html);
                setTimeout(function(){$("#"+select_ctl).val(time_val);}, 500);
            }
        });
    }

    $(".edit_date").change(function(){
        getEditRunTimes("edit_time", "");
    });

    var loadRewards = function(battle, value){
        $.ajax({
            type: "POST",
            url: "battle_rewards.php",
            data: "battle="+battle,
            success: function(html){
                $("#edit_reward").html(html);
                $("#edit_reward").val(value);
            }
        });
    }

    $("#edit_battle").change(function(){
        var battle = $(this).val();
        loadRewards(battle, '');
        populateSuits(battle);
        populateStatuses(battle);
        if (battle == 'VP') {
            $("#edit_skeleround_1,#edit_skeleround_2,#edit_skeleround_3,#edit_skeleround_4,#edit_skeleround_5,#edit_skeleround_6,#edit_skeleround_7,#edit_skeleround_8").each(function(){
                $(this).parent().show();
            });
            $("#edit_cleanupround_1,#edit_cleanupround_2,#edit_cleanupround_3,#edit_cleanupround_4,#edit_cleanupround_5,#edit_cleanupround_6,#edit_cleanupround_7,#edit_cleanupround_8").each(function(){
                $(this).parent().hide();
                if ($(this).prop('checked')) {
                    $(this).prop('checked', false);
                    $(this).parent().toggleClass('active');
                    $(this).blur();
                }
            });
        } else if (battle == 'CEO') {
            $("#edit_cleanupround_1,#edit_cleanupround_2,#edit_cleanupround_3,#edit_cleanupround_4,#edit_cleanupround_5,#edit_cleanupround_6,#edit_cleanupround_7,#edit_cleanupround_8").each(function(){
                $(this).parent().show();
            });
            $("#edit_skeleround_1,#edit_skeleround_2,#edit_skeleround_3,#edit_skeleround_4,#edit_skeleround_5,#edit_skeleround_6,#edit_skeleround_7,#edit_skeleround_8").each(function(){
                $(this).parent().hide();
                if ($(this).prop('checked')) {
                    $(this).prop('checked', false);
                    $(this).parent().toggleClass('active');
                    $(this).blur();
                }
            });
        } else {
            $("#edit_skeleround_1,#edit_skeleround_2,#edit_skeleround_3,#edit_skeleround_4,#edit_skeleround_5,#edit_skeleround_6,#edit_skeleround_7,#edit_skeleround_8").each(function(){
                $(this).parent().hide();
                if ($(this).prop('checked')) {
                    $(this).prop('checked', false);
                    $(this).parent().toggleClass('active');
                    $(this).blur();
                }
            });
            $("#edit_cleanupround_1,#edit_cleanupround_2,#edit_cleanupround_3,#edit_cleanupround_4,#edit_cleanupround_5,#edit_cleanupround_6,#edit_cleanupround_7,#edit_cleanupround_8").each(function(){
                $(this).parent().hide();
                if ($(this).prop('checked')) {
                    $(this).prop('checked', false);
                    $(this).parent().toggleClass('active');
                    $(this).blur();
                }
            });
        }
    });

    var populateSuits = function(battle) {
        $.ajax({
            type: "POST",
            url: "report_suit.php",
            data: "battle="+battle,
            success: function(html){
                $("#edit_suit_1,#edit_suit_2,#edit_suit_3,#edit_suit_4,#edit_suit_5,#edit_suit_6,#edit_suit_7,#edit_suit_8").each(function(){
                    $(this).html(html);

                    var ddl = $(this).prop("name");
                    var ddl_val = $(this).val();
                    var num = ddl.substr(ddl.lastIndexOf("_")+1);

                    $("#edit_suitlevel_"+num).html('');
                });
            }
        });
    }

    var populateSuitLevels = function(select_ctl) {
        var ddl = $(select_ctl).prop("name");
        var ddl_val = $(select_ctl).val();
        var num = select_ctl.substr(select_ctl.lastIndexOf("_")+1);

        $.ajax({
            type: "POST",
            url: "report_suitlevel.php",
            data: "suit="+encodeURIComponent(ddl_val),
            success: function(html){
                $("#edit_suitlevel_"+num).html(html);
                setTimeout(function(){$("#edit_suitlevel_"+num).delay(100).val($("#suitlevel_"+num).val());}, 500);
            }
        });
    }

    $(".suit").change(function(){
        var ddl = $(this).prop("name");
        var ddl_val = $(this).val();
        var num = ddl.substr(ddl.lastIndexOf("_")+1);

        $.ajax({
            type: "POST",
            url: "report_suitlevel.php",
            data: "suit="+encodeURIComponent(ddl_val),
            success: function(html){
                $("#edit_suitlevel_"+num).html(html);
            }
        });
    });

    var populateStatuses = function(battle) {
        $.ajax({
            type: "POST",
            url: "report_status.php",
            data: "battle="+battle,
            success: function(html){
                $("#edit_status_1,#edit_status_2,#edit_status_3,#edit_status_4,#edit_status_5,#edit_status_6,#edit_status_7,#edit_status_8").each(function(){
                    $(this).html(html);
                });
            }
        });
    }

    var populateForm = function(json, tz) {
        var report = $.parseJSON(json);
        var battle = report.battle;
        $("#edit_battle").val(battle);

        if (battle == 'VP') {
            $("#edit_skeleround_1,#edit_skeleround_2,#edit_skeleround_3,#edit_skeleround_4,#edit_skeleround_5,#edit_skeleround_6,#edit_skeleround_7,#edit_skeleround_8").each(function(){
                $(this).parent().show();
            });
            $("#edit_cleanupround_1,#edit_cleanupround_2,#edit_cleanupround_3,#edit_cleanupround_4,#edit_cleanupround_5,#edit_cleanupround_6,#edit_cleanupround_7,#edit_cleanupround_8").each(function(){
                $(this).parent().hide();
                if ($(this).prop('checked')) {
                    $(this).prop('checked', false);
                    $(this).parent().toggleClass('active');
                    $(this).blur();
                }
            });
        } else if (battle == 'CEO') {
            $("#edit_cleanupround_1,#edit_cleanupround_2,#edit_cleanupround_3,#edit_cleanupround_4,#edit_cleanupround_5,#edit_cleanupround_6,#edit_cleanupround_7,#edit_cleanupround_8").each(function(){
                $(this).parent().show();
            });
            $("#edit_skeleround_1,#edit_skeleround_2,#edit_skeleround_3,#edit_skeleround_4,#edit_skeleround_5,#edit_skeleround_6,#edit_skeleround_7,#edit_skeleround_8").each(function(){
                $(this).parent().hide();
                if ($(this).prop('checked')) {
                    $(this).prop('checked', false);
                    $(this).parent().toggleClass('active');
                    $(this).blur();
                }
            });
        } else {
            $("#edit_skeleround_1,#edit_skeleround_2,#edit_skeleround_3,#edit_skeleround_4,#edit_skeleround_5,#edit_skeleround_6,#edit_skeleround_7,#edit_skeleround_8").each(function(){
                $(this).parent().hide();
                if ($(this).prop('checked')) {
                    $(this).prop('checked', false);
                    $(this).parent().toggleClass('active');
                    $(this).blur();
                }
            });
            $("#edit_cleanupround_1,#edit_cleanupround_2,#edit_cleanupround_3,#edit_cleanupround_4,#edit_cleanupround_5,#edit_cleanupround_6,#edit_cleanupround_7,#edit_cleanupround_8").each(function(){
                $(this).parent().hide();
                if ($(this).prop('checked')) {
                    $(this).prop('checked', false);
                    $(this).parent().toggleClass('active');
                    $(this).blur();
                }
            });
        }

        var run_datetime = report.run_datetime;
        var datetime = run_datetime.split(' ');
        var date = datetime[0].split('-');
        var year = date[0]; var month = date[1]; var day = date[2];
        $("#edit_date").datepicker("setDate", new Date(year, month-1, day));

        var time = datetime[1].split(':');
        var hour = (time[0] <= 12) ? time[0] : time[0]-12;
        var hour = (hour < 10) ? '0'+hour : hour;
        var minute = time[1];
        var ampm = (time[0] < 12) ? 'AM' : 'PM';
        var full_time = hour+':'+minute+' '+ampm;
        getEditRunTimes("edit_time", full_time);

        loadRewards(battle, report.reward);
        $("#edit_loaded").val(report.toons_loaded).trigger('change');
        populateSuits(battle);
        populateStatuses(battle);

        var toon = new Array();
        toon[1] = $.parseJSON(report.toon_1);
        toon[2] = $.parseJSON(report.toon_2);
        toon[3] = $.parseJSON(report.toon_3);
        toon[4] = $.parseJSON(report.toon_4);
        toon[5] = $.parseJSON(report.toon_5);
        toon[6] = $.parseJSON(report.toon_6);
        toon[7] = $.parseJSON(report.toon_7);
        toon[8] = $.parseJSON(report.toon_8);
        setTimeout(function(){
            for (var i=1;i<=8;i++) {
                if (toon[i] !== null) {
                    $("#edit_toon_"+i).val(toon[i].name);
                    $("#edit_laff_"+i).val(toon[i].laff);
                    var suit = toon[i].suit;
                    $("#suitlevel_"+i).val(toon[i].suitlevel);
                    $("#edit_suit_"+i).val(suit);
                    populateSuitLevels('#edit_suit_'+i);
                    $("#edit_status_"+i).val(toon[i].status);

                    $("#edit_coground_"+i).prop('checked', false).parent().removeClass('active');
                    if (toon[i].coground) { $("#edit_coground_"+i).prop('checked', true).parent().toggleClass('active'); }
                    $("#edit_skeleround_"+i).prop('checked', false).parent().removeClass('active');
                    if (toon[i].skeleround) { $("#edit_skeleround_"+i).prop('checked', true).parent().toggleClass('active'); }
                    $("#edit_cleanupround_"+i).prop('checked', false).parent().removeClass('active');
                    if (toon[i].cleanupround) { $("#edit_cleanupround_"+i).prop('checked', true).parent().toggleClass('active'); }
                }
            }
        }, 500);
        $("#edit_notes").val(report.notes);
    }

    $("#show_reports").on('click', '.edit_report', function(){
        var callid = $(this).prop("id").split("_");
        var resultid = callid[0];
        var tz = callid[1];
        $("#edit_report_id").val(resultid);
        
        $.ajax({
            type: "POST",
            url: "edit_report.php",
            data: "resultid="+resultid,
            success: function(json){
                populateForm(json, tz);
            }
        });
        $("#edit_report").fadeIn("normal");
        return false;
    });

    $("#edit_loaded").change(function(){
        for (i=1;i<=8;i++) {
            $("#edit_"+i).hide();
        }
        if ($("#loaded").val() != "") {
            for (i=1;i<=parseInt($("#edit_loaded").val());i++) {
                $("#edit_"+i).show();
            }
        }
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

    $("#delete_report").hide();
    $("#show_reports").on('click', '.delete_report', function(){
        var report_id = $(this).prop("id").split("_");
        var resultid = report_id[1];
        $("#delete_result_id").val(resultid);
        $("#delete_report").show();
        return false;
    });

    $("#cancel_delete").click(function(){
        $("#delete_report").hide();
    });

    $("#confirm_delete").click(function(){
        var resultid = $("#delete_result_id").val();
        $.ajax({
            type: "POST",
            url: "delete_report.php",
            data: "result_id="+resultid,
            success: function(html) {
                if (html == 'true') {
                    $("#delete_report").fadeOut("normal");
                    location.href = "victories.php";
                } else {
                    $("#add_err").html("Hmm... Something didn't go right...");
                }
            },
            beforeSend: function() {
                $("#add_err").html("Deleting...");
            }
        });
        return false;
    });
});