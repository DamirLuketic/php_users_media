<?php include_once 'config.php'; ?>

<!-- Access namespace class -->
<?php

function __autoload($class)
{
    $parts = explode('\\App', $class);
    require end($parts) . '.php';
}
use App\AllProducts;
?>

<!-- All products Start -->
<?php include_once 'config.php'; ?>
<?php include 'functions.php'; ?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <?php include 'header.php'; ?>
</head>
<body >

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
$npp = 8;

?>

<!-- end of first pagination first part -->

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
                                    <h1>All Products:</h1>
                                </div>
                                <!-- Site Title end-->


                                <!-- show all products data -->


                                <table class="table" style="color: whitesmoke ;">
                                    <tr>
                                        <th>Category:</th>
                                        <th>Media:</th>
                                        <th>Title:</th>
                                        <th>Release date</th>
                                        <th></th>
                                    </tr>

                                    <!-- second part of pagination -> find all media and find total pages -->

                                    <!-- find all user products through class method -->

                                    <?php if(isset($_COOKIE['user_id'])): ?>
                                        <?php $products_data = new AllProducts($GLOBALS['con'], $page, $npp); ?>

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
                                                <td>




                                                    <?php user_products($_COOKIE['user_id']); ?>

                                                    <?php if(in_array($product->product_id, $attach_array)): ?>


                                                    <form action="detach_when_all_products.php" method="post">
                                                        <input type="hidden" name="user_id" value="<?php echo $_COOKIE['user_id']; ?>">
                                                        <input type="hidden" name="product_id" value="<?php echo $product->product_id; ?>">
                                                        <input type="hidden" name="page" value="<?php echo $page; ?>">
                                                        <input type="submit" value="Detach" class="btn btn-danger">
                                                    </form>

                                                    <?php else: ?>

                                                    <form action="attach_when_all_products.php" method="post">
                                                        <input type="hidden" name="user_id" value="<?php echo $_COOKIE['user_id']; ?>">
                                                        <input type="hidden" name="product_id" value="<?php echo $product->product_id; ?>">
                                                        <input type="hidden" name="page" value="<?php echo $page; ?>">
                                                        <input type="submit" value="Attach" class="btn btn-primary">
                                                    </form>

                                                    <?php endif; ?>

                                                </td>
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
                                                <li><a href="<?php echo $_SERVER["PHP_SELF"] ?>?page=1">First</a></li>
                                                <li class="arrow"><a href="<?php echo $_SERVER["PHP_SELF"] ?>?page=<?php echo $page-1; ?>">&laquo;</a></li>
                                                <?php
                                                for($i=1; $i<=$total_pages;$i++):
                                                    if($i-5<=$page && $i+5>=$page):
                                                        ?>
                                                        <li <?php if($i==$page){ echo "class=\"current\""; } ?>>
                                                            <a href="<?php echo $_SERVER["PHP_SELF"] ?>?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                                    <?php endif; endfor;?>
                                                <li class="arrow"><a href="<?php echo $_SERVER["PHP_SELF"] ?>?page=<?php echo $page < $total_pages ? $page+1 : $page ; ?>">&raquo;</a></li>
                                                <li ><a href="<?php echo $_SERVER["PHP_SELF"] ?>?page=<?php echo $total_pages; ?>">Last</a></li>
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
<!-- All products Section End -->