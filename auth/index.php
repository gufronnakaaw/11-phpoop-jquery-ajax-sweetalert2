<?php 

session_start();

if( isset($_SESSION['login']) ){
    header('Location: /latihan/PHP-OOP/');
    exit;
}

?>
<?php require '../templates/headerLogin.php'; ?>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <form class="login100-form validate-form" action=" loginCek.php" id="form_login" autocomplete="off" method="post">
                <span class="login100-form-title p-b-43">
                    Login
                </span>
                
                
                <div class="wrap-input100 validate-input" data-validate = "Valid username is required: izzy">
                    <input class="input100" type="text" id="username_login" name="username_login">
                    <span class="focus-input100"></span>
                    <span class="label-input100">Username</span>
                </div>
                
                
                <div class="wrap-input100 validate-input" data-validate="Password is required">
                    <input class="input100" type="password" id="password_login" name="password_login">
                    <span class="focus-input100"></span>
                    <span class="label-input100">Password</span>
                </div>

                <!-- forgot password -->
                <div class="flex-sb-m w-full p-t-3 p-b-32">
                    <div class="contact100-form-checkbox">
                        <input class="input-checkbox100" id="cekbox" type="checkbox" >
                        <label class="label-checkbox100" for="cekbox">
                            Show password
                        </label>
                    </div>

                    <!-- <div>
                        <a href="#" class="txt1">
                            Forgot Password?
                        </a>
                    </div> -->
                </div>
        

                <div class="container-login100-form-btn p-t-5">
                    <button class="login100-form-btn" id="btn-login" type="submit">
                        Login
                    </button>
                </div>
            </form>

            <div class="login100-more" style="background-image: url('../dist/login/bg-02.jpg');">
            </div>
        </div>
    </div>
</div>

<?php require '../templates/footerLogin.php'; ?>