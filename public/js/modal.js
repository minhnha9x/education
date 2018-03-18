$(function() {
    var $divForms = $('.form-w3-agile');
    var $modalAnimateTime = 300;
    var $msgAnimateTime = 150;
    var $msgShowTime = 2000;
    
    $('#login_register_btn').click( function () { modalAnimate($('#login-form'), $('#register-form')) });
    $('#register_login_btn').click( function () { modalAnimate($('#register-form'), $('#login-form')); });
    $('#login_lost_btn').click( function () { modalAnimate($('#login-form'), $('#lost-form')); });
    $('#lost_login_btn').click( function () { modalAnimate($('#lost-form'), $('#login-form')); });
    $('#lost_register_btn').click( function () { modalAnimate($('#lost-form'), $('#register-form')); });
    $('#register_lost_btn').click( function () { modalAnimate($('#register-form'), $('#lost-form')); });
    
    function modalAnimate ($oldForm, $newForm) {
        var $oldH = $oldForm.height();
        var $newH = $newForm.height() + 120;
        $oldForm.fadeToggle($modalAnimateTime, function(){
            $divForms.animate({height: $newH}, $modalAnimateTime, function(){
                $newForm.fadeToggle($modalAnimateTime);
            });
        });
    }
});