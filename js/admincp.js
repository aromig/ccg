$(document).ready(function(){
    $("#user_details").hide();

    $("#search_user").keypress(function(event){
        if (event.which == 13) {
            event.preventDefault();
            $("#search_user_btn").trigger("click");
        }
    });
    $("#search_user_btn").click(function(){
        var query = $("#search_user").val();
        var type = "user";
        $.ajax({
            type: "POST",
            url: "cp_search.php",
            data: "type="+type+"&query="+query,
            success: function(html){
                $("#user_results").html(html);
            }
        });
    });

    $("#user_results").on('click', '.user_result', function(){
        var userid = $(this).prop('id');
        $.ajax({
            type: "POST",
            url: "cp_user.php",
            data: "userid="+userid,
            success: function(json){
                // populate form elements from json object
                var user = $.parseJSON(json);
                $("#ccg_id").val(user.ccg_id);
                $("#orig_username").val(user.mcf_username);
                $("#username").val(user.mcf_username);
                $("#forum_title").html(user.mcf_title);
                $("#reg_date").val(user.reg_date);
                $("#reg_ip").val(user.reg_ip);
                $("#last_login").val(user.last_login);
                $("#last_ip").val(user.last_ip);
                if (parseInt(user.bassie) === 1) { $("#bassie").prop('checked', true); } else { $("#bassie").prop('checked', false); }
                if (parseInt(user.admin) === 1) { $("#admin").prop('checked', true); } else { $("#admin").prop('checked', false); }
                $("#user_details").show();
            }
        });
    });

    $("#user_form").submit(function(){
        var original_username = $("#username").val();
        var new_username = $("#orig_username").val();

        if (new_username != original_username) {
            var response = confirm("You are about to change this user's username. This only should be done when the user's forum account has been renamed. Doing so otherwise will leave the user unable to access their profile.\r\n\r\nAre you sure you want to do this?");
            if (!response) {
                return false;
            }
        }
    });

    $("#trash_toon").click(function(){
        var toonid = $("#toon_id").val();
        var toonname = $("#toon").val();
        var response = confirm("You are about to delete this toon. This operation cannot be undone.\r\n\r\nAre you sure you want to do this?");
        if (!response) {
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "cp_del_toon.php",
                data: "toon_id="+toonid+"&toon="+toonname,
                success: function(html){
                    $("#toon_results").html(html);
                    $("#toon_details").hide();
                }
            });
        }
    });

    $("#toon_details").hide();

    $("#search_toon").keypress(function(event){
        if (event.which == 13) {
            event.preventDefault();
            $("#search_toon_btn").trigger("click");
        }
    });
    $("#search_userstoon").keypress(function(event){
        if (event.which == 13) {
            event.preventDefault();
            $("#search_userstoon_btn").trigger("click");
        }
    });
    $("#search_toon_btn").click(function(){
        var query = $("#search_toon").val();
        var type = "toon";
        $.ajax({
            type: "POST",
            url: "cp_search.php",
            data: "type="+type+"&query="+query,
            success: function(html){
                $("#toon_results").html(html);
            }
        });
    });
    $("#search_userstoon_btn").click(function(){
        var query = $("#search_userstoon").val();
        var type= "toon";
        $.ajax({
            type: "POST",
            url: "cp_search.php",
            data: "type="+type+"&query="+query+"&user=1",
            success: function(html){
                $("#toon_results").html(html);
            }
        });
    });

    $("#toon_results").on('click', '.toon_result', function(){
        var toonid = $(this).prop('id');
        $.ajax({
            type: "POST",
            url: "cp_toon.php",
            data: "toonid="+toonid,
            success: function(json){
                var toon = $.parseJSON(json);
                $("#toon_id").val(toon.toon_id);
                $("#toon").val(toon.toon);
                $("#toon_username").val(toon.mcf_username);
                $("#laff").val(toon.laff);
                $("#gags_toonup").val(toon.max_toonup);
                $("#gags_trap").val(toon.max_trap);
                $("#gags_lure").val(toon.max_lure);
                $("#gags_sound").val(toon.max_sound);
                $("#gags_throw").val(toon.max_throw);
                $("#gags_squirt").val(toon.max_squirt);
                $("#gags_drop").val(toon.max_drop);
                $("#suit_sell").val(toon.sellsuit);
                $("#suit_cash").val(toon.cashsuit);
                $("#suit_law").val(toon.lawsuit);
                $("#suit_boss").val(toon.bosssuit);
                $("#toon_details").show();
            }
        })
    });
});