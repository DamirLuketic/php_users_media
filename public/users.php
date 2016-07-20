<!-- redirect user to main page if is not logged -->
<?php
if(!isset($_COOKIE['user_id']))
{
	header('location: index.php');
}
	?>


<?php include_once 'config.php'; ?>

<!-- Access namespace class -->
<?php

function __autoload($class)
{
	$parts = explode('\\App', $class);
	require end($parts) . '.php';
}
use App\Users;
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
									<h1>Other users:</h1>
								</div>
								<!-- Site Title end-->


								<!-- show all user data -->


								<table class="table" style="color: whitesmoke ;">
									<tr>
										<th>Name:</th>
										<th>E-mail::</th>
										<th></th>
									</tr>

									<!-- second part of pagination -->

									<!-- find all users through class method -->

									<?php if(isset($_COOKIE['user_id'])): ?>
										<?php $users_data = new Users($GLOBALS['con'], $page, $npp); ?>

										<!-- find total number of pages through class (number of all users / users per page) -->
										<?php $total_pages = $users_data->total_pages()->pages; ?>

										<!-- all users -->
										<?php $users = $users_data->users(); ?>

										<!-- end of pagination second part -->

										<!-- show users -->

										<?php foreach ($users as $user): ?>

											<?php if($_COOKIE['user_id'] != $user->user_id): ?>

											<tr>
												<td><?php echo $user->name; ?></td>
												<td><?php echo $user->email; ?></td>
												<td>

													<!-- start form for view user list -->

													<form action="products_from_user.php" method="get">
														<input type="hidden" name="user_id" value="<?php echo $user->user_id; ?>">
														<input type="submit" value="View products" class="btn btn-primary">
													</form>

													<!-- end form for view user list -->

												</td>
											</tr>

											<?php endif; ?>

										<?php endforeach; ?>
									<?php endif; ?>
								</table>

								<!-- end of showing users -->

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