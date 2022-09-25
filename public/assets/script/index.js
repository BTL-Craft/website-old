$('#about').animate({opacity:'0'})
$('#pg2').animate({opacity:'0'})
$('#pg3').animate({opacity:'0'})
$('#pg4').animate({opacity:'0'})
var a = 0
var b = 0
var c = 0
var d = 0
setInterval(() => {
    if ($('.parent-container').scrollTop() >= 200 && a != 1) {
        a = 1
        $('#about').animate({opacity:'1'})
    }
    if ($('.parent-container').scrollTop() >= 500 && b != 1) {
        b = 1
        $('#pg2').animate({opacity:'1'})
    }
    if ($('.parent-container').scrollTop() >= 1000 && c != 1) {
        c = 1
        $('#pg3').animate({opacity:'1'})
    }
    if ($('.parent-container').scrollTop() >= 1500 && d != 1) {
        d = 1
        $('#pg4').animate({opacity:'1'})
    }
}, 100);