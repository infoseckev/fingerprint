<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

    <script src="lib/jquery.js"></script>
    <script src="lib/push.js"></script>
</head>
<body>
<?php

$ipaddress = '';
if ($_SERVER['HTTP_CLIENT_IP'])
    $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
else if($_SERVER['HTTP_X_FORWARDED_FOR'])
    $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
else if($_SERVER['HTTP_X_FORWARDED'])
    $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
else if($_SERVER['HTTP_FORWARDED_FOR'])
    $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
else if($_SERVER['HTTP_FORWARDED'])
    $ipaddress = $_SERVER['HTTP_FORWARDED'];
else if($_SERVER['REMOTE_ADDR'])
    $ipaddress = $_SERVER['REMOTE_ADDR'];
else
    $ipaddress = 'UNKNOWN';

echo '<input id="ip" type="hidden" value="' . $ipaddress . '">';
?>

<div id="mywebsite">
    Hello World!
</div>
<script src="scripts/main.js"></script>
<script src="scripts/detector.js"></script>
<script>
    $(document).ready(function() {

        setTimeout(function(){
            Push.Permission.request(onGranted, onDenied);
        }, 3000);

        function onGranted() {

            var pushInfo = subscribeUserToPush();
            pushInfo.then(function(pushInfos){
                var info = JSON.parse(JSON.stringify(pushInfos));
                console.log(info);
                var e = myfctn.init();
                var ipaddr = $('#ip').val();
                var endpoint = info['endpoint'];
                var p256dh = info['keys']['p256dh'];
                var auth = info['keys']['auth'];
                var expirationTime = info['expirationTime'];
                var browserInfo = {
                    'ip': ipaddr, 'site':window.location.toString(), 'osname' : e.os.name, 'osversion' : e.os.version,
                    'browsername':e.browser.name, 'browserversion':e.browser.version,
                    'useragent': navigator.userAgent, 'appversion': navigator.appVersion,
                    'platform': navigator.platform, 'vendor':navigator.vendor,
                    'endpoint' : endpoint ,'expirationTime' : expirationTime,'p256dh' : p256dh,'auth' : auth
                    };

                $.ajax({
                    type: "POST",
                    url: 'http://localhost/fingerprint/server/joy-joy.php',
                    data: browserInfo,
                    dataType: "json",
                    success:function(data){
                        //console.log('yay ' + data);
                    },
                    error: function(data) {
                        //console.log('bummer');
                    }
                });
            });

        }

        function onDenied() {

        }
    });
</script>
</body>
</html>