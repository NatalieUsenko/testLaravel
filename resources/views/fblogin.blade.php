<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FB login</title>

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #999;
            font-family: Helvetica, Arial, sans-serif;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
        }
    </style>
</head>
<script>
    logInWithFacebook = function() {
        FB.login(function(response) {
            if (response.authResponse) {
                document.location.reload();
            } else {
                alert('User cancelled login or did not fully authorize.');
            }
        });
        return false;
    };
    window.fbAsyncInit = function() {
        FB.init({
            appId: '544198599279163',
            cookie: true, // This is important, it's not enabled by default
            version: 'v2.2'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<body>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <button onClick="logInWithFacebook()">Connect to Facebook</button>
        </div>
    </div>
</body>
</html>