window.onload = function () {
    /* href(location.pathname) */
}

function href(url) {
    if (url == null) {
        history.replaceState(1, 1, '/user')
        $.post("/", {
            'url': 'user'
        },
            function (data) {
                alert(data);
                /* $('main').replaceWith(data); */
            }
        );
    } else {
        history.replaceState(1, 1, '/user/' + url)
        $.post("/index.php", {
            'url': 'user/' + url
        },
            function (data) {
                alert(data);
                /* $('main').replaceWith(data); */
            }
        );
    }
}