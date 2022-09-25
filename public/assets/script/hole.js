var p = 100;
function hole() {
    document.getElementById('hole-div').setAttribute("style", "pointer-events:none;");
    var i
    for (var i = 0; i < 11; i++) {
        setTimeout(function(){hide()},i * 70);
        setTimeout(function(){disp()},i * 70 + 35);
    }
    setTimeout(function() {document.getElementById('hole').innerHTML = '<br>';},490)
    setTimeout(function(){  
        p = 100;
        document.getElementById('hole').setAttribute("style", "");
        var str = $.get('/api/hole.php',{},function(data){str = data})
        var str_ = ''
        var i = 0
        var content = document.getElementById('hole')
          setTimeout(()=>{
                var timer = setInterval(()=>{
                if(str_.length<str.length){
                    str_ += str[i++]
                    content.innerHTML = '<p>'+str_+'__</p>'                        //打印时加光标
                }else{ 
                    clearInterval(timer)
                    content.innerHTML = '<p>'+str_+'</p>'
                    document.getElementById('hole-div').setAttribute("style", "")
                }
            
            },50)
        },700)
    },500)
}


function hide() {
    document.getElementById('hole').setAttribute("style", "opacity: 0;");
}

function disp() {
    document.getElementById('hole').setAttribute("style", "opacity: "+p+"%;");
    p = p - 10;
}

