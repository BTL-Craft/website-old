/* setInterval(() => {
    reg_page('#captcha', '#log', '300px')
}, 2000);
setTimeout(() => {
    setInterval(() => {
        log_page('#reg', '#captcha', '255px')
    }, 2000);
}, 1000); */

var times = 50 //设置失败重试最大次数
var recaptcha_token
var logined

function reg_page() {
    $("#log").attr("style", "opacity: 0; z-index: -1; margin-left: -40px;");
    setTimeout(() => {
        $("#main").attr("style", "height: 402px");
    }, 200);
    setTimeout(function () {
        $("#reg").attr("style", "z-index: 1; opacity: 1; margin-left: 0;");
    }, 550)
}

function log_page() {
    $("#reg").attr("style", "z-index:-1");

    setTimeout(function () {
        $("#main").attr("style", "");
    }, 200)
    setTimeout(() => {
        $("#log").attr("style", "opacity: 1; z-index: 1; margin-left: 0;");
    }, 550);
}

function login() {
    if (logined == 1) {
        return
    }
    document.cookie = "username=John Doe";
    var eml = $('#l-email').val();
    var passwd = $('#l-password').val();
    if (eml == "" || /[^\s+]/g.test(eml) != true || passwd == "" || /[^\s+]/g.test(passwd) != true) {
        show_alert('l-alert', 'l-msg', '请把表单填写完整', '登录', 'login()');
        return false;
    }
    $("#l-alert").attr("style", "background-color:#568de5; pointer-events: none");
    $("#l-alert").attr("onclick", "return false");
    grecaptcha.ready(function () {
        grecaptcha.execute("6LfwxPcgAAAAAItIZYokEteF7Fj0Or2vyv9Bg5pu", { action: 'login' }).then(function (token) {
            recaptcha_token = token;
        })
    })
    $.post("/",
        {
            'email': eml,
            'password': passwd,
            'token': recaptcha_token,
            'type': 'login',
            'source': 'auth',
        },
        function (data, status) {
            data = $.trim(data)
            if (data == '登录成功') {
                $.ajax({ // 向皮肤站发送一次请求来触发登录并设置cookie
                    'type': 'get',
                    'url': 'http://127.0.0.1:91/api/btl',
                    crossDomain: true,
                    withCredential: true,
                    'error': function () { login(); times = times--; return }
                })
                $('#l-alert').attr("style", "background-color:#2da44e; pointer-events: none");
                $('#l-msg').html('继续');
                setTimeout(() => {
                    next_pg('#log', '#remember', '210px')
                }, 1000);
                logined = 1
                return
            }
            else if (data == 'QQ未绑定') {
                $('#l-alert').attr("style", "background-color:#2da44e; pointer-events: none");
                $('#l-msg').html('继续');
                document.cookie = `eml=${eml}`;
                setTimeout(function () {
                    next_pg('#log', '#qid', '255px')
                    $('#l-alert').attr("style", "");
                    $('#l-msg').html('登录');
                    $("#l-alert").attr("onclick", "login()");
                }, 800);
                return
            }
            else {
                show_alert('l-alert', 'l-msg', data, '登录', 'login()');
                return
            }
        }
    ).fail(function () {
        if (times >= 0) {
            times = times--;
            login();
            return
        } else {
            times = 50;
            show_alert('l-alert', 'l-msg', '身份验证失败，请重试登录', '登录', 'login()');
            return
        }
    }
    );
    return;
}

function register() {
    var eml = $('#r-email').val();
    var passwd = $('#r-password').val();
    var repasswd = $('#r-repassword').val();
    var usrname = $('#r-username').val();
    grecaptcha.ready(function () {
        grecaptcha.execute("6LfwxPcgAAAAAItIZYokEteF7Fj0Or2vyv9Bg5pu", { action: 'login' }).then(function (token) {
            recaptcha_token = token;
        })
    })
    $("#r-alert").attr("style", "background-color:#568de5; pointer-events: none");
    if (eml == "" || /[^\s+]/g.test(eml) != true || passwd == "" || /[^\s+]/g.test(passwd) != true || repasswd == '' || /[^\s+]/g.test(repasswd) != true || usrname == '' || /[^\s+]/g.test(usrname) != true) {
        show_alert('r-alert', 'r-msg', '请把表单填写完整', '下一步', 'register()');
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
                $.post("/",
                    {
                        'type': 'reg',
                        'email': eml,
                        'password': passwd,
                        'username': usrname,
                        'token': recaptcha_token,
                        'source': 'auth'
                    },
                    function (data) {
                        data = $.trim(data)
                        if (data == '注册完成') {
                            $('#r-alert').attr("style", "background-color:#2da44e; pointer-events: none");
                            $('#r-msg').html('继续');
                            $("#i").attr("style", "color: #828282; pointer-events: none");
                            document.cookie = "reg=false;expires=Thu, 18 Dec 2032 12:00:00 GMT";
                            setTimeout(function () {
                                next_pg('#reg', '#qid', '255px')
                            }, 800);
                        }
                        else {
                            show_alert('r-alert', 'r-msg', data, '注册', 'register()');
                        }
                    }
                ).fail(function () {
                    if (times >= 0) {
                        times = times--;
                        register();
                        return
                    } else {
                        times = 50;
                        show_alert('r-alert', 'r-msg', '身份验证失败，请重试', '注册', 'register()');
                        return
                    }
                }
                );
                return;
            }
        }, 800)
    }
}
function qid() {
    var code = $('#r-code').val();
    grecaptcha.ready(function () {
        grecaptcha.execute("6LfwxPcgAAAAAItIZYokEteF7Fj0Or2vyv9Bg5pu", { action: 'login' }).then(function (token) {
            recaptcha_token = token;
        })
    })
    $('#c-alert').attr("style", "background-color:#568de5; pointer-events: none")
    if (code == '' || /[^\s+]/g.test(code) != true) {
        show_alert('c-alert', 'c-msg', '请把表单填写完整', '下一步', 'qid()');
        return false;
    }
    else {
        $.post("/",
            {
                'type': 'qid',
                'code': code,
                'token': recaptcha_token,
                'source': 'auth'
            },
            function (data) {
                data = $.trim(data)
                if (data == '1') {
                    $('#c-alert').attr("style", "background-color:#2da44e; pointer-events: none");
                    $('#c-msg').html('继续');
                    setTimeout(function () {
                        next_pg('#qid', '#log', '300px')
                    }, 800);

                } else if (data == '请重新登录') {
                    show_alert('c-alert', 'c-msg', '会话过期，请重新登录', '下一步', 'register()');
                    next_pg('#qid', '#log', '300px')
                }
                else if (data == '-1') {
                    show_alert('c-alert', 'c-msg', '你已经注册过了，请直接登录', '你已经注册过了，请直接登录', 'qid()');
                    setTimeout(function () {
                        next_pg('#qid', '#log', '300px')
                    }, 800);
                }
                else {
                    show_alert('c-alert', 'c-msg', data, '下一步', 'qid()');
                }
            }
        ).fail(function () {
            if (times >= 0) {
                times = times--;
                qid();
                return
            } else {
                times = 50;
                show_alert('c-alert', 'c-msg', '身份验证失败，请重试', '下一步', 'qid()');
                return
            }
        }
        );
        return;
    }
}

function next_pg(id1, id2, height) {
    $("#log").attr("style", "opacity: 0; z-index: -1;");
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
    $("#log").attr("style", "opacity: 0; z-index: -1;");
    setTimeout(function () {
        $("#main").attr("style", "height: 280px");
        $("#forg").attr("style", "z-index: 1; opacity: 1; margin-top: 0;");
    }
        , 300)
}

function login_page() {
    $("#forg").attr("style", "z-index:-1;");
    $("#main").attr("style", "");
    setTimeout(function () {

        $("#log").attr("style", "opacity: 1; z-index: 1; margin-left: 0;");
    }, 350)
}

function remember(selected) {
    $.post("/",
        {
            'selected': selected,
            'token': recaptcha_token,
            'type': 'remember',
            'source': 'auth',
        }, function (data) {
            if (data == '1') {
                window.location.replace("/")
            }
            else {
                alert(data)
                window.location.replace("/")
            }
        })
}

window.onload = function () {
    $.get("https://bs.btlcraft.top/auth/login",
        function (data) {
            $('#bs').html(data)
        }
    );
}

function abc() {
    $.post(
        'http://127.0.0.1:91/api/auth/login',
        {
            email: 'kxscluabcbook@outldook.com',
            password: '2'
        }, function (data) {
            console.log(data)
        })
}

/* function getCookie(cname)
{
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i=0; i<ca.length; i++) 
  {
    var c = ca[i].trim();
    if (c.indexOf(name)==0) return c.substring(name.length,c.length);
  }
  return "";
} */