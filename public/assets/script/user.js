window.onload = function () {
    $('.sidebar-active').attr('class', 'sidebar-item');
    if (location.pathname == '/user') {
        $('#sidebar-1').attr('class', 'sidebar-item sidebar-active');
    }
    if (location.pathname == '/user/application') {
        $('#sidebar-2').attr('class', 'sidebar-item sidebar-active');
    }
    if (location.pathname == '/user/invite') {
        $('#sidebar-3').attr('class', 'sidebar-item sidebar-active');
    }
    if (location.pathname == '/user/profile') {
        $('#sidebar-4').attr('class', 'sidebar-item sidebar-active');
    }
}

function href(url) {
    close_menu_and_sidebar();
    if (url == null) {
        history.replaceState(1, 1, '/user')
        $.post("/", {
            'source': 'user_center',
            'rua': 'index'
        },
            function (data) {
                act_sidebar('root');
                $('#main').fadeOut(120);
                setTimeout(() => {
                    $('#main').empty();
                    $('#main').append(data);
                    $('#main').fadeIn(120);
                }, 240);
            }
        );
    } else {
        history.replaceState(1, 1, '/user/' + url)
        $.post("/", {
            'source': 'user_center',
            'rua': url
        },
            function (data) {
                act_sidebar(url)
                $('#main').fadeOut(120);
                setTimeout(() => {
                    $('#main').empty();
                    $('#main').append(data);
                    $('#main').fadeIn(120);
                }, 240);
            }
        );
    }
}

function act_sidebar(rua) {
    $('.sidebar-active').attr('class', 'sidebar-item');
    if (rua == 'root') {
        document.title = '仪表盘 - BTL Craft';
        $('#sidebar-1').attr('class', 'sidebar-item sidebar-active');
    }
    if (rua == 'application') {
        document.title = '填写表单 - BTL Craft';
        $('#sidebar-2').attr('class', 'sidebar-item sidebar-active');
    }
    if (rua == 'invite') {
        document.title = '邀请好友 - BTL Craft';
        $('#sidebar-3').attr('class', 'sidebar-item sidebar-active');
    }
    if (rua == 'profile') {
        document.title = '个人资料 - BTL Craft';
        $('#sidebar-4').attr('class', 'sidebar-item sidebar-active');
    }
}