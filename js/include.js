$(document).ready(function () {
    console.log("ready!");
    alert('document ready');
    // $('a[href="#login-form"]').click(function(event) {
    $('#login-form').click(function (event) {
        alert('modal');
        console.log("clicou modal!");
        event.preventDefault();
        this.blur(); // Manually remove focus from clicked link.
        $.get(this.href, function (html) {
            $(html).appendTo('body').modal();
        });

        //$('#login-form-iframe').css('height',$(".modal").height()-40);
    });
});

function modalIframeSrc(src) {
    $('#login-form-iframe').attr('src', src);
}

function modalStyle(style) {
    $('#login-form').attr('style', style);
    $('#login-form-iframe').css('height', $(".modal").height() - 40);
}