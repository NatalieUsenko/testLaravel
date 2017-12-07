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
            color: #000;
            font-family: Helvetica, Arial, sans-serif;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
        }

        .one-news{
            width: 30%;
            display: inline-flex;
            flex-direction: column;
            border: 1px solid #999;
            margin: 15px 1.2% 25px;
        }

        .image img{
            width: 100%;
            height: auto;
            max-width: 130px;
        }
        .bottom{
            display: inline-flex;
            flex-direction: row;
        }
        .bottom>.bottom-item{
            width: 33%;
            border: 1px solid #999;
        }

    </style>
    <script>

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
</head>
<body>
<div class="position-ref full-height">
    <div class="content">
        <h3> <?php echo $userName;?></h3>
        <?php foreach ($userPosts as $userPost) {?>

        <div class="one-news">
            <div class="date">Date: <?php echo $userPost['created_time']->format('d.m.Y');?></div>
            <?php if (!empty($userPost['picture'])){?>
            <div class="image"><img src="<?php echo $userPost['picture']; ?>"></div>
            <?php } ?>
            <div class="description">
                <?php if (!empty($userPost['story'])){?>
                    <?php echo $userPost['story']; ?>
                 <?php } ?>
            </div>

            <div class="bottom">
                <div class="bottom-item">
                    <?php if (!empty($userPost['likes'])){
                        echo count($userPost['likes']).' likes';
                    } else {
                        echo '0 like';
                    }?>
                </div>
                <div class="bottom-item">
                    <?php if (!empty($userPost['shares'])){
                        echo count($userPost['shares']).' shares';
                    } else {
                        echo '0 shares';
                    }?>
                </div>
                <div class="bottom-item"><a href="<?php echo $userPost['permalink_url']; ?>" target="_blank">See on FB -></a></div>
            </div>
        </div>
        <?php }?>
    </div>
</div>



</body>
</html>