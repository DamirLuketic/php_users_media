<?php include_once 'config.php'; ?>
<?php include_once 'functions.php'; ?>

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
$npp = 8;

?>

<!-- end of first pagination first part -->

<!-- Header Section Start -->
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
                                    <h1>List of media</h1>
                                </div>
                                <!-- Site Title end-->

                                <!-- start table for view products -->
                                
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
                                    <?php $products_data = new Equipment($GLOBALS['con'], $_COOKIE['user_id'], $page, $npp); ?>

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
                                                <form action="detach.php" method="post">
                                                    <input type="hidden" name="user_id" value="<?php echo $_COOKIE['user_id']; ?>">
                                                    <input type="hidden" name="product_id" value="<?php echo $product->product_id; ?>">
                                                    <input type="submit" value="Detach" class="btn btn-danger">
                                                </form>
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

                                <!-- Part for create new product in db / start -->

                                <?php if(isset($_COOKIE['user_id'])): ?>

                                    <div class="text-center">
                                        <a href="#new"><button type="button" class="btn btn-info">Add new product</button></a>
                                    </div>

                                <?php endif; ?>

                                <!-- Part for create new product in db / stop -->
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
    <?php include 'menu.php'; ?>
            
        </div>
    </div>
</header>
<!-- Header Section End -->	