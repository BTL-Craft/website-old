function show_menu() {
    if ($('#btn').attr('class') == 'icon menu')
    {
        $('#menu-li-1').attr('style', 'margin-left: -3rem; opacity: 0;')
        $('#menu-li-2').attr('style', 'margin-left: -3rem; opacity: 0;')
        $('#menu-li-3').attr('style', 'margin-left: -3rem; opacity: 0;')
        $('#menu-li-4').attr('style', 'margin-left: -3rem; opacity: 0;')
        $('#menu').attr('style', 'top: 35px')
        $('.icon-icon').attr('style','pointer-events: none;')
        $('#btn').fadeOut(100)
        setTimeout(() => {
            $('#btn').attr('class','icon xmark')
            
            $('.icon-icon').attr('style','pointer-events: auto;')
        }, 100); 
        $('#menu').fadeIn(100)
        $('#btn').fadeIn(100)
        setTimeout(() => {
            $('#menu').attr('style', 'top: 80px; display:block')
        }, 100);
        setTimeout(() => {
            $('#menu-li-1').attr('style', '')
        }, 200);
        setTimeout(() => {
            $('#menu-li-2').attr('style', '')
        }, 270);
        setTimeout(() => {
            $('#menu-li-3').attr('style', '')
        }, 340);
        setTimeout(() => {
            $('#menu-li-4').attr('style', '')
        }, 410);
    } else
    {
        $('#menu-li-1').attr('style', 'opacity: 0;')
        $('#menu-li-2').attr('style', 'opacity: 0;')
        $('#menu-li-3').attr('style', 'opacity: 0;')
        $('#menu-li-4').attr('style', 'opacity: 0;')
        $('#menu').attr('style', 'top: 35px;display: block')
        $('.icon-icon').attr('style','pointer-events: none;')
        $('#btn').fadeOut(100)
        setTimeout(() => {
            $('#btn').attr('class','icon menu')
            $('.icon-icon').attr('style','pointer-events: auto;')
        }, 100); 
        $('#menu').fadeOut(200)
        $('#btn').fadeIn(100)
    }
}