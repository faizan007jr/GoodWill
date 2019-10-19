function footerAlign() {
    $('footer').css('display', 'block');
    $('footer').css('height', 'auto');
    var footerHeight = $('footer').outerHeight();
    $('body').css('padding-bottom', footerHeight + 8);
    $('footer').css('height', footerHeight + 8);
}


$(document).ready(function(){
    footerAlign();
});

$( window ).resize(function() {
    footerAlign();
});