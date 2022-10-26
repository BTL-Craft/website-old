

setInterval(() => {
    height = $('.pg0').height() + $('.pg1').height() + $('.pg2').height() + $('.pg3').height() + $('.pg4').height() - $(window).height() - 10
    if ($(".parent-container").scrollTop() >= height) {
        $('#pg5').attr('style', 'bottom: 0;')
    }
    else {
        $('#pg5').attr('style', 'bottom: -69px;')
    }
    /* 滚动到底部后顶部透明 */
    if ($("body").scrollTop() >= 0) {
        $('.top').attr('style', '')
        $('.top ul.list .a').attr('style', '')
    }
    else {
        $('.top').attr('style', 'background-color: #00000000;')
        $('.top ul.list .a').attr('style', 'color: #fff;')
    }
/*  滚动超过一个页面顶部变透明
    if ($(".parent-container").scrollTop() >= $(window).height()) {
        $('.top').attr('style', '')
        $('.top ul.list .a').attr('style', '')
    }
    else {
        $('.top').attr('style', 'background-color: #00000000;')
        $('.top ul.list .a').attr('style', 'color: #fff;')
    } */
}, 50);