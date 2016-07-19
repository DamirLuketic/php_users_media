<?php include_once 'config.php'; ?>
<?php include 'functions.php'; ?>
<?php $_SESSION['msg'] = 'Automatic Login after Successful Registration'; ?>
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
                                    <h1>Register</h1>
                                </div>
                                <!-- Site Title end-->

                                <!-- Call a function for registration start -->

                                <?php

                                if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['repeat_password']) &&
                                    !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['repeat_password'])
                                )
                                {
                                    register($_POST['name'], $_POST['email'], $_POST['password'], $_POST['repeat_password']);
                                }
                                ?>

                                <!-- Call a function for registration end -->



                                <!-- Form for registration start -->
                                
                                <div class="text-center">
                                    
                                <form method="post" style="color: floralwhite ">

                                    <h3><?php echo $_SESSION['msg']; ?></h3>

                                        <div class="form-group">
                                            <label>Name:
                                                <input type="text" name="name" class="form-control">
                                            </label>
                                        </div>

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
                                            <label>Repeat password:
                                                <input type="text" name="repeat_password" class="form-control">
                                            </label>
                                        </div>

                                        <div class="form-group">

                                                <input type="submit" name="submit" class="btn btn-primary" value="Register" >

                                        </div>

                                </form>
                                    
                                </div>

                                <!-- Form for registration / end -->


                                <!-- Back to index / start -->
                                <div class="text-center">
                                    <a href="index.php"><button type="button" class="btn btn-info">Back</button></a>
                                </div>
                                <!-- Back to index / stop -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</header>

<?php include 'scripts.php' ?>
</body>
</html>