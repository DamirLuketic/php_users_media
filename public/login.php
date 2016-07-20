<?php include_once 'config.php'; ?>
<?php include_once 'functions.php'; ?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <?php include 'header.php'; ?>
</head>
<body >

<header id="header_part">
    <div class="header_part" id="head">
        <div class="overlay">
            <div class="start_part">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <!-- Logo Start -->
                                <div class="site_logo">
                                    <a href="#" title=""><img height="80" src="images/logo.png" alt="" title=""/></a>
                                </div>
                                <!-- Logo End-->
                                <!-- Site Title start-->
                                <div class="site_title">
                                    <h1>LogIn</h1>
                                </div>
                                <!-- Site Title end-->



                                <!-- Form for login start -->

                                <div class="text-center">

                                    <form method="post" style="color: floralwhite ">

                                        <h3><?php login_try(); ?></h3>

                                        <div class="form-group">
                                            <label>E-mail:
                                                <input type="email" name="email" class="form-control">
                                            </label>
                                        </div>

                                        <div class="form-group">
                                            <label>Password:
                                                <input type="text" name="password" class="form-control">
                                            </label>
                                        </div>

                                        <div class="form-group">

                                            <input type="submit" name="submit" class="btn btn-primary" value="LogIn" >

                                        </div>

                                    </form>

                                </div>

                                <!-- Form for login end -->
                                
                                <!-- Call a function for login start -->

                                <?php

                                if(isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])
                                )
                                {
                                    logIn($_POST['email'], $_POST['password']);
                                }
                                ?>

                                <!-- Call a function for login end -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'menu.php'; ?>
        </div>
    </div>
</header>

<?php include 'scripts.php' ?>
</body>
</html>