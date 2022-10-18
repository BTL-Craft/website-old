/* setInterval(() => {
    reg_page('#captcha', '#log', '300px')
}, 2000);
setTimeout(() => {
    setInterval(() => {
        log_page('#reg', '#captcha', '255px')
    }, 2000);
}, 1000); */
function reg_page() {
    document.getElementById("log").setAttribute("style", "opacity: 0; z-index: -1; margin-left: -40px;");
    setTimeout(() => {
        document.getElementById("main").setAttribute("style", "height: 402px");
    }, 200);
    setTimeout(function () {
        document.getElementById("reg").setAttribute("style", "z-index: 1; opacity: 1; margin-left: 0;");
    }, 550)
}

function log_page() {
    document.getElementById("reg").setAttribute("style", "z-index:-1");

    setTimeout(function () {
        document.getElementById("main").setAttribute("style", "");
    }, 200)
    setTimeout(() => {
        document.getElementById("log").setAttribute("style", "opacity: 1; z-index: 1; margin-left: 0;");
    }, 550);
}

function login() {
    var eml = document.getElementById('l-email').value;
    var passwd = document.getElementById('l-password').value;
    if (eml == "" || /[^\s+]/g.test(eml) != true || passwd == "" || /[^\s+]/g.test(passwd) != true) {
        show_alert('l-alert', 'l-msg', '请把上面的所有内容填写完整', '登录', 'login()');
        return false;
    }
    document.getElementById("l-alert").setAttribute("style", "background-color:#568de5; pointer-events: none");
    document.getElementById("l-alert").setAttribute("onclick", "return false");
    document.getElementById("l-msg").innerHTML = '登录中';
    setTimeout(function () {
        $.post("/app/login.php",
            {
                'email': eml,
                'password': passwd,
                'type': 'login'
            },
            function (data) {
                if (data == '登录成功') {
                    document.getElementById('l-alert').setAttribute("style", "background-color:#94c86b; pointer-events: none");
                    document.getElementById('l-msg').innerHTML = data;
                }
                else if (data == 'QQ未绑定') {
                    document.getElementById('l-alert').setAttribute("style", "background-color:#94c86b; pointer-events: none");
                    document.getElementById('l-msg').innerHTML = '继续';
                    document.cookie = `eml=${eml}`;
                    setTimeout(function () {
                        next_pg('#log', '#captcha', '255px')
                        document.getElementById('l-alert').setAttribute("style", "");
                        document.getElementById('l-msg').innerHTML = '登录';
                        document.getElementById("l-alert").setAttribute("onclick", "login()");
                    }, 800);
                }
                else {
                    show_alert('l-alert', 'l-msg', data, '登录', 'login()');
                }
            }
        );
    }, 800)
}

function register() {
    var eml = document.getElementById('r-email').value;
    var passwd = document.getElementById('r-password').value;
    var repasswd = document.getElementById('r-repassword').value;
    var usrname = document.getElementById('r-username').value;
    document.getElementById("r-alert").setAttribute("style", "background-color:#568de5; pointer-events: none");
    if (eml == "" || /[^\s+]/g.test(eml) != true || passwd == "" || /[^\s+]/g.test(passwd) != true || repasswd == '' || /[^\s+]/g.test(repasswd) != true || usrname == '' || /[^\s+]/g.test(usrname) != true) {
        show_alert('r-alert', 'r-msg', '请把上面的所有内容填写完整', '下一步', 'register()');
        return false;
    }
    else {
        setTimeout(function () {
            if (passwd != repasswd) {
                show_alert('r-alert', 'r-msg', '密码和确认的密码不一样诶？', '下一步', 'register()');
            } else if (passwd.length < 8) {
                show_alert('r-alert', 'r-msg', '密码应当不少于八位', '下一步', 'register()');
            }
            else {
                $.post("/app/register.php",
                    {
                        'type': 'reg',
                        'email': eml,
                        'password': passwd,
                        'username': usrname
                    },
                    function (data) {
                        if (data == '注册完成') {
                            document.getElementById('r-alert').setAttribute("style", "background-color:#94c86b; pointer-events: none");
                            document.getElementById('r-msg').innerHTML = '继续';
                            document.getElementById("i").setAttribute("style", "color: #828282; pointer-events: none");
                            document.cookie = "reg=false;expires=Thu, 18 Dec 2032 12:00:00 GMT";
                            setTimeout(function () {
                                next_pg('#reg', '#captcha', '255px')
                            }, 800);

                        }
                        else {
                            show_alert('r-alert', 'r-msg', data, '注册', 'register()');
                        }
                    }
                );
            }
        }, 800)
    }
}
function captcha() {
    var eml = document.cookie.replace(/.*(?=eml=)+(eml=)/g, '');
    var code = document.getElementById('r-code').value;
    $('#c-alert').attr("style", "background-color:#568de5; pointer-events: none")
    if (code == '' || /[^\s+]/g.test(code) != true) {
        show_alert('c-alert', 'c-msg', '请把上面的所有内容填写完整', '下一步', 'captcha()');
        return false;
    }
    else {
        $.post("/app/register.php",
            {
                'type': 'captcha',
                'code': code,
                'eml': eml
            },
            function (data) {
                if (data == '1') {
                    document.getElementById('c-alert').setAttribute("style", "background-color:#94c86b; pointer-events: none");
                    document.getElementById('c-msg').innerHTML = '继续';
                    setTimeout(function () {
                        next_pg('#captcha', '#log', '300px')
                    }, 800);

                }
                else if (data == '-1') {
                    show_alert('c-alert', 'c-msg', '你已经注册过了，请直接登录', '你已经注册过了，请直接登录', 'captcha()');
                    setTimeout(function () {
                        next_pg('#captcha', '#log', '300px')
                    }, 800);
                }
                else {
                    show_alert('c-alert', 'c-msg', data, '下一步', 'captcha()');
                }
            }
        )
    }
}

function next_pg(id1, id2, height) {
    document.getElementById("log").setAttribute("style", "opacity: 0; z-index: -1;");
    $(id1).attr('style', 'z-index: -1; margin-left: -40px')
    setTimeout(() => {
        $('#loading').attr('style', 'opacity: 0;')
        $('#main').attr('style', 'height: ' + height)
    }, 200);
    setTimeout(() => {
        $(id2).attr('style', 'z-index: 1; opacity: 1; margin-left: 0')
    }, 550);
}

function animation(id) {
    var btn = $(id);
    var time = 50;
    for (let i = 0; i < 4; i++) {
        btn.animate({ 'margin-left': '5px' }, time);
        btn.animate({ 'margin-left': '-5px' }, time);
    }
    btn.animate({ 'margin-left': '0' }, time);
}

function show_alert(id1, id2, msg, msg2, callback) {
    document.getElementById(id1).setAttribute("onclick", "return false");
    document.getElementById(id1).setAttribute("style", "background-color:#c00; pointer-events: none");
    document.getElementById(id2).innerHTML = msg;
    animation('#' + id1);
    setTimeout(function () {
        document.getElementById(id2).innerHTML = msg2;
        document.getElementById(id1).setAttribute("style", "background-color: #007bff; pointer-events: all");
        document.getElementById(id1).setAttribute("onclick", callback);
    }, 1500)
}
function forget_page() {
    document.getElementById("log").setAttribute("style", "opacity: 0; z-index: -1;");
    setTimeout(function () {
        document.getElementById("main").setAttribute("style", "height: 220px");
        document.getElementById("forg").setAttribute("style", "z-index: 1; opacity: 1; margin-top: 0;");
    }
        , 300)
}

function login_page() {
    document.getElementById("forg").setAttribute("style", "z-index:-1;");
    document.getElementById("main").setAttribute("style", "");
    setTimeout(function () {
        
        document.getElementById("log").setAttribute("style", "opacity: 1; z-index: 1; margin-left: 0;");
    }, 350)
}

function remember(selected) {
    $.post("/app/login.php",
    {
        'selected': selected,
        'type': 'remember'
    })
}
