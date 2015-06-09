<!doctype html>
<html lang="zh_CN">
<head>

    <meta charset="UTF-8">

    <title>Shu Weather API</title>

    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="renderer" content="webkit">    <!-- 强制双核浏览器使用webkit内核 -->
    <meta http-equiv="Cache-Control" content="no-siteapp"> <!-- 禁止百度手机版转码 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
    
    <h1>Shu Weather API</h1>
    <h3>API URL: http://lab.geeku.net/weather/get.php?id=cityID</h3>

    <div id="getID">
        Search City ID
        <input type="text" id="name" placeholder="enter city's name">
        <input type="button" id="submit" value="search">
    </div>
    
    <div class="id">
        City ID: <span></span>
    </div>

    <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
    <script>
        $(document).ready(function() {
            
            var url = "http://lab.geeku.net/weather/getID.php?city=";
            var $name = $("#name");
            
            $("#submit").click(function() {
                $.get("http://lab.geeku.net/weather/getID.php?city=" + $name.val() , function(result){
                    $(".id span").html(result);
                });
            })
        })

    </script>
</body>
</html>