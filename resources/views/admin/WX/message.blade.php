<!DOCTYPE html>
<html>
<head>
    <title>主页</title>
</head>
<body>


<table border="1">
    <tr>
        <td><input type="checkbox" id="c"></td>
        <td width="50" align="center"> id</td>
        <td width="250" align="center">openid</td>
    </tr>
    @foreach($data as $k=>$v)
        <tr>
            <td openid="{{$v->openid}}"><input type="checkbox" class="d"></td>
            <td width="50" align="center"> {{$v->nickname}}</td>
            <td width="250" align="center">{{$v->subscribe_time}}</td>
        </tr>
    @endforeach
</table>
<p>请选择要发送的内容:<input type="text" id="text"></p>
<button id="btn">点我发送</button>
{{--<input type="submit" value="点我发送" id="btn">--}}
</body>
</html>
<script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
<script>

    $('#c').click(function(){
        var type=$('#c').prop('checked');
        $('.d').prop('checked',type);
    })
    //全选
    $('.d').click(function(){
        if($(this).prop('checked')==false){
            $('#c').prop('checked',false);
        }
    })
    //点击发送
    $('#btn').click(function(){
        var opid=$('.d');
        var text=$('#text').val();
        var openid='';
        opid.each(function(res){
            if($(this).prop('checked')==true) {
                openid += $(this).parent('td').attr('openid') + ',';
            }
        })
        openid=openid.substr(0,openid.length-1);
        //console.log(openid);
        if(openid==''){
            alert('请选择要发送的人');
            return false;
        }
        if(text==''){
            alert('请输入发送的内容');
            return false;
        }
        $.ajax({
            url : 'messageAss?openid='+openid+'&text='+text,
            type:'get',
            dataType:'json'
        })
   })








</script>