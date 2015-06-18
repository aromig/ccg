$(document).ready(function(){
    if (window.location.href.indexOf('logout.php') > -1) {
    	$("#myccg").html("<li><a href='register.php'>Register</a></li><li><a href='#'' id='login_a'>Login</a></li>");
	}

    $("#login_a").click(function(){
        $("#login_form").fadeIn("normal");
        $("#user_name").focus();
    });

    $("#cancel_hide").click(function(){
    	$("#login_form").fadeOut("normal");
    });

    $("#login").click(function(){
    	var username = $("#user_name").val();
    	var password = $("#password").val();
        var rememberme = $("#rememberme").prop('checked') ? "Yes" : "No";
    	$.ajax({
        	type: "POST",
    		url: "login.php",
    		data: "username="+username+"&pwd="+password+"&rememberme="+rememberme,
    		success: function(html){
    			if (html == 'true') {
    				$("#login_form").fadeOut("normal");
    				$("#myccg").html("<li><a href='profile.php'>Profile</a></li><li><a href='logout.php'>Logout</a></li>");
    				location.href = "profile.php";
    			} else {
    				$("#add_err").html("Invalid username or password.");
    			}
    		},
    		beforeSend: function() {
        		$("#add_err").html("Verifying...");
    		}
   		});
        return false;
   	});
});