<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="tntsannexicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:600">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <style>
        body, html {
        margin: 0;
        color: rgb(255, 255, 255);
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('img/365312550_779895047479706_5683602959482120186_n.jpg') no-repeat center center fixed;
        background-size: cover;
        font: 600 16px/18px 'Open Sans', sans-serif;
        position: relative;
        height: auto; /* Allow height to adjust based on content */
        overflow-y: auto; /* Enable vertical scrolling */
        margin-bottom: 10px;
    }
        *, :after, :before {
            box-sizing: border-box;
        }
        .clearfix:after, .clearfix:before {
            content: '';
            display: table;
        }
        .clearfix:after {
            clear: both;
            display: block;
        }
        a {
            color: inherit;
            text-decoration: none;
        }
        .login-wrap {
            width: 100%;
            margin: auto;
            margin-top: 150px;
            max-width: 525px;
            min-height: 500px;
            position: relative;
            box-shadow: 0 12px 15px 0 rgba(0, 0, 0, .24), 0 17px 50px 0 rgba(0, 0, 0, .19);
        }
        .login-html {
            width: 100%;
            height: 100%;
            position: absolute;
            padding: 90px 70px 50px 70px;
            background: rgba(204, 198, 168, 0.8);
        }
        .login-html .sign-in-htm,
        .login-html .sign-up-htm {
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            position: absolute;
            -webkit-transform: rotateY(180deg);
            transform: rotateY(180deg);
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            transition: all .4s linear;
        }
        .login-html .sign-in,
        .login-html .sign-up,
        .login-form .group .check {
            display: none;
        }
        .login-html .tab,
        .login-form .group .label,
        .login-form .group .button {
            text-transform: uppercase;
        }
        .login-html .tab {
            font-size: 22px;
            margin-right: 15px;
            padding-bottom: 5px;
            margin: 0 15px 10px 0;
            display: inline-block;
            border-bottom: 2px solid transparent;
        }
        .login-html .sign-in:checked + .tab,
        .login-html .sign-up:checked + .tab {
            color: #22211c;
            border-color: #22211c;
        }
        .login-form {
            min-height: 345px;
            position: relative;
            -webkit-perspective: 1000px;
            perspective: 1000px;
            -webkit-transform-style: preserve-3d;
            transform-style: preserve-3d;
        }
        .login-form .group {
            margin-bottom: 15px;
        }
        .login-form .group .label,
        .login-form .group .input,
        .login-form .group .button {
            width: 100%;
            color: #fff;
            display: block;
        }
        .login-form .group .input,
        .login-form .group .button {
            border: none;
            padding: 15px 20px;
            border-radius: 25px;
            background: #22211c;
        }
        .login-form .group input[data-type="password"] {
            text-security: circle;
            -webkit-text-security: circle;
        }
        .login-form .group .label {
            color: #22211c;
            font-size: 12px; 
        }
        .login-form .group .button {
            background: #fff;
            color: #22211c;
            font-weight: bold;
        }
        .login-form .group .button:hover {
            background: #f0f0f0;
        }
        .login-form .group label .icon {
            width: 15px;
            height: 15px;
            border-radius: 2px;
            position: relative;
            display: inline-block;
            background: #22211c;
        }
        .login-form .group label .icon:before,
        .login-form .group label .icon:after {
            content: '';
            width: 10px;
            height: 2px;
            background: #fff;
            position: absolute;
            transition: all .2s ease-in-out 0s;
        }
        .login-form .group label .icon:before {
            left: 3px;
            width: 5px;
            bottom: 6px;
            -webkit-transform: scale(0) rotate(0);
            transform: scale(0) rotate(0);
        }
        .login-form .group label .icon:after {
            top: 6px;
            right: 0;
            -webkit-transform: scale(0) rotate(0);
            transform: scale(0) rotate(0);
        }
        .login-form .group .check:checked + label {
            color:#22211c;
        }
        .login-form .group .check:checked + label .icon {
            background: #22211c;
        }
        .login-form .group .check:checked + label .icon:before {
            -webkit-transform: scale(1) rotate(45deg);
            transform: scale(1) rotate(45deg);
        }
        .login-form .group .check:checked + label .icon:after {
            -webkit-transform: scale(1) rotate(-45deg);
            transform: scale(1) rotate(-45deg);
        }
        .login-html .sign-in:checked + .tab + .sign-up + .tab + .login-form .sign-in-htm {
            -webkit-transform: rotate(0);
            transform: rotate(0);
        }
        .login-html .sign-up:checked + .tab + .login-form .sign-up-htm {
            -webkit-transform: rotate(0);
            transform: rotate(0);
        }
        .hr {
            height: 2px;
            margin: 10px 0 50px 0;
            background: #22211c;
            
        }
        .foot-lnk {
            text-align: center;
            margin-top: -25px;
        }
        .home-button {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 10px 15px;
            border-radius: 15px;
            background: #22211c;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
        }
        .home-button:hover {
            background: #777362;
        }
    </style>
</head>
<body>
    <div class="login-wrap">
        <div class="login-html">
            <a href="index.php" class="home-button">Home</a>
            <input id="tab-1" type="radio" name="tab" class="sign-in" checked>
            <label for="tab-1" class="tab">Sign In</label>
            <input id="tab-2" type="radio" name="tab" class="sign-up">
            <label for="tab-2" class="tab"></label>
            <div class="login-form">
                <form class="sign-in-htm" action="req/login.php" method="post">
                    <div class="group">
                        <label for="user" class="label">Username</label>
                        <input id="username" name="uname" type="text" class="input" required>
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Password</label>
                        <input id="password" name="pass" type="password" class="input" data-type="password" required>
                    </div>
                    <div class="group">
                        <input id="check" type="checkbox" class="check" checked>
                        <label for="check"><span class="icon"></span> Keep me Signed in</label>
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="Sign In">
                    </div>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <div id="g_id_onload"
                             data-client_id="YOUR_GOOGLE_CLIENT_ID"
                             data-context="signin"
                             data-ux_mode="popup"
                             data-callback="handleCredentialResponse"
                             data-auto_prompt="false">
                        </div>
                        <div class="g_id_signin"
                             data-type="standard"
                             data-shape="rectangular"
                             data-theme="outline"
                             data-text="sign_in_with"
                             data-size="large">
                        </div>
                    </div>
                </form>
                <form class="sign-up-htm" action="req/signup.php" method="post">
                    <div class="group">
                        <label for="user" class="label">Username</label>
                        <input id="username" name="username" type="text" class="input" required>
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Password</label>
                        <input id="password" name="password" type="password" class="input" data-type="password" required>
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Confirm Password</label>
                        <input id="pass" type="password" class="input" data-type="password" required>
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="Sign Up">
                    </div>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <label for="tab-1">Already Member?</label>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function handleCredentialResponse(response) {
            console.log("Encoded JWT ID token: " + response.credential);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>