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

        .one-news{
            width: 33%;
            padding: 0 25px 35px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content">
        <h3> <?php echo $userName;?></h3>
        <?php foreach ($userPosts as $userPost) {?>
        <div class="one-news flex-center">
            <div class="date">Date: <?php echo $userPost['created_time']->format('d.m.Y');?></div>
        </div>
        <?php }?>
    </div>
</div>



</body>
</html>