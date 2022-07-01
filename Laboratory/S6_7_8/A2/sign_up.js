// Wait until body charges completely
jQuery(document).ready(function($){
    $(".btn-primary").on("click", function(){ 
        var name = $("#name").val().trim();
        var email = $("#email").val();
        var password = $("#password").val();    
        $.post("new_user.php", {name: name, email:email, password: password}, function(data, status){
            if (status === "success") {
                $("#signup_form").closest('div').addClass("destResults");
                $("#signup_form").closest('div').prepend(data);
                $("#signup_form").hide();
            }
        });
    });
});