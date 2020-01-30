;

function ajax(name , data){
    url = '/ajax-handler/' + name + '?';
    for(i = 0; i < data.length; i++){
        url += i + '=' + $(data[i]).val() + "&";
    }
    var res = $.ajax({url: url , await: true , success: function(res){
        eval(res);
    }});
    console.log(res.text);
}