// Wait until body charges completely
jQuery(document).ready(function($){
    $("#submit_signup").on("click", function(){ 
        var name = $("#minombre").val();
        var email = $("#email").val();
        console.log(email);
        const regex = /^([a-zA-Z])*@([a-zA-Z])*.[a-zA-Z]{3}$/;
        if (email.match(regex)) {
            $.post("new_user.php", {name: name, email:email}, function(data, status){
                if (status === "success") {
                    console.log(data);
                    $("#signup_form").closest('div').html(data);
                }
            });
        } else {
            $("#signup_form").closest('div').html("Email was incorrectly fullfilled!");
        }
    });
});