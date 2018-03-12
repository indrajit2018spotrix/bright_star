<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $GLOBALS['_-_-_manifest_-_-_']['_-_-_app_-_-_']; ?></title>

        <?php
            $background = $GLOBALS['_-_-_path_-_-_']['_-_-_asset_-_-_']['_-_-_img_-_-_'] . "app/img10.jpg";
        ?>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #000;
                background: url(<?php echo $background; ?>) no-repeat;
                background-size: 100% 100%;
                color: #FFF;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
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

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">

                <div class="title m-b-md">
                    405 Method Not Allowed
                </div>
                <font style="font-family: Palatino Linotype;font-size: 16px;"><?php echo $compact['message']; ?></font>

            </div>
        </div>

        <div style="position: fixed;bottom: 0;left: 0;width: 100%;padding: 15px 0;font-family: Palatino Linotype;font-size: 14px;text-align: center;background: rgba(0, 0, 0, 0.7);">Copyright &copy;<font style="color: #00aeff;">armsg</font>, 2016</div>
    </body>
</html>
