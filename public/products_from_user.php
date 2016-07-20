<?php include_once 'config.php'; ?>
<?php include 'functions.php'; ?>

<!-- redirect user to main page if is not logged -->
<?php
if(!isset($_COOKIE['user_id']))
{
    header('location: index.php');
}
?>

<!-- put user id in variable -> id taken by "GET" method -->
<?php
// if is set user id current user will have view on user products,
// else will have view on private products
if(isset($_GET['user_id']))
{
    $user_id = $_GET['user_id'];
}else
{
    $user_id = $_COOKIE['user_id'];
}
?>

<!-- Access namespace class -->
<?php

function __autoload($class)
{
    $parts = explode('\\App', $class);
    require end($parts) . '.php';
}
use App\Equipment;
?>

<!-- Paginate -> first we add basic term -->

<?php

if(!isset($_GET["page"])){
    $page=1;
}else{
    $page = $_GET["page"];
}
if($page==0){
    $page=1;
}

// number per page
$npp = 10;

?>

<!-- end of first pagination first part -->
<!DOCTYPE html>
<html lang="en" >
<head>
    <?php include 'header.php'; ?>
</head>
<body>

<?php user_data($user_id); ?>

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
                                    <h1><?php echo $user_data->name; ?> Products:</h1>
                                </div>
                                <!-- Site Title end-->



                                <!-- start table for view products -->

                                <table class="table" style="color: whitesmoke ;">
                                    <tr>
                                        <th>Category:</th>
                                        <th>Media:</th>
                                        <th>Title:</th>
                                        <th>Release date</th>
                                    </tr>

                                    <!-- second part of pagination -> find all media and find total pages -->

                                    <!-- find all user products through class method -->

                                    <?php if(isset($_COOKIE['user_id'])): ?>
                                        <?php $products_data = new Equipment($GLOBALS['con'], $user_id, $page, $npp); ?>

                                        <!-- find total number of pages through class (number of all products / product per page) -->
                                        <?php $total_pages = $products_data->total_pages()->pages; ?>

                                        <!-- all products -->
                                        <?php $products = $products_data->products(); ?>

                                        <!-- end of pagination second part -->

                                        <!-- show products -->

                                        <?php foreach ($products as $product): ?>

                                            <tr>
                                                <td><?php echo $product->category_name; ?></td>
                                                <td><?php echo $product->media_name; ?></td>
                                                <td><?php echo $product->title; ?></td>
                                                <td><?php echo isset($product->release_date) ? $product->release_date : 'No information'; ?></td>
                                            </tr>

                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </table>

                                <!-- end of showing products -->

                                <!-- pagination part three create part for moving through data -->

                                <?php if(isset($_COOKIE['user_id'])): ?>

                                    <div class="text-center">
                                        <div class="pagination">
                                            <ul class="pagination">
                                                <li><a href="<?php echo $_SERVER["PHP_SELF"] ?>?page=1&user_id=<?php echo $user_id; ?>">First</a></li>
                                                <li class="arrow"><a href="<?php echo $_SERVER["PHP_SELF"] ?>?page=<?php echo $page-1; ?>&user_id=<?php echo $user_id; ?>">&laquo;</a></li>
                                                <?php
                                                for($i=1; $i<=$total_pages;$i++):
                                                    if($i-5<=$page && $i+5>=$page):
                                                        ?>
                                                        <li <?php if($i==$page){ echo "class=\"current\""; } ?>>
                                                            <a href="<?php echo $_SERVER["PHP_SELF"] ?>?page=<?php echo $i; ?>&user_id=<?php echo $user_id; ?>"><?php echo $i; ?></a></li>
                                                    <?php endif; endfor;?>
                                                <li class="arrow"><a href="<?php echo $_SERVER["PHP_SELF"] ?>?page=<?php echo $page < $total_pages ? $page+1 : $page ; ?>&user_id=<?php echo $user_id; ?>">&raquo;</a></li>
                                                <li ><a href="<?php echo $_SERVER["PHP_SELF"] ?>?page=<?php echo $total_pages; ?>&user_id=<?php echo $user_id; ?>">Last</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                <?php endif; ?>

                                <!-- end of pagination -> third part -->
                                

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