<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<p><span onclick="dialog('http://www.baidu.com','','','','','')">打开</span></p>

</body>
</html>
<script>
    function dialog(URL,viewField,hidField,isOnly,dialogWidth,dialogHeight)
    {
        dialogWidth || (dialogWidth = 1200)
            ,dialogHeight || (dialogHeight = 600)
            ,loc_x = (window.innerWidth-dialogWidth)/2
            ,loc_y = (window.innerHeight-dialogHeight)
            ,window._viewField = viewField
            ,window._hidField= hidField;
        var selectValue = window.open(URL, 'newwindow','height='+dialogHeight+',width='+dialogWidth+',top='+loc_y+',left='+loc_x+',toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');

        //
        // // loc_x = document.body.scrollLeft+event.clientX-event.offsetX;
        // //loc_y = document.body.scrollTop+event.clientY-event.offsetY;
        // if(window.ActiveXObject){ //IE
        //     var selectValue = window.showModalDialog(URL,self,"edge:raised;scroll:1;status:0;help:0;resizable:1;dialogWidth:"+dialogWidth+"px;dialogHeight:"+dialogHeight+"px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
        //     if(selectValue){
        //         callbackSuperDialog(selectValue);
        //     }
        // }else{  //非IE
        //
        //
        // }
    }
</script>