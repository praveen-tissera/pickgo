$(document).ready(function(){
    $('.form-register').submit(function(){
        var recaptcha = $("#g-recaptcha-response").val();

        if (recaptcha === "") {
            event.preventDefault();
            alert("Please Solve The Captcha to Continue!");    
        }
    });
});