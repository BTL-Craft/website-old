

setInterval(() => {
    height = $('.pg0').height() + $('.pg1').height() + $('.pg2').height() + $('.pg3').height() + $('.pg4').height() - $(window).height() - 10
    if ($(".parent-container").scrollTop() >= height) {
        $('#pg5').attr('style', 'bottom: 0;')
    }
    else {
        $('#pg5').attr('style', 'bottom: -55px;')
    }
}, 50);