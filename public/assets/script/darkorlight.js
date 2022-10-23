
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.body.className = "dark";
    } else {
        document.body.className = "dark";
    }
    window.matchMedia('(prefers-color-scheme: dark)')
        .addEventListener('change', event => {
    if (event.matches) {
        document.body.className = "dark";
    } else {
        document.body.className = "dark";
    }
    })

function openDark(box) {
    let body = document.body;
    if (box.state == null) {
        box.state = false;
    }
    if (box.state) {

        body.className = "light";
    } else {

        body.className = "dark";
    }
    box.state = !box.state;
}