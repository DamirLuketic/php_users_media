<?php include_once 'config.php'; ?>
<?php include 'functions.php'; ?>

<!-- Menu Start -->
<div class="menu_area" id="stick_menu">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <nav class="navbar navbar-default" role="navigation">
                    <div class="container-fluid">
                        <div class="collapse navbar-collapse mainnavmenu" id="bs-example-navbar-collapse-1">
                            <div id="menu-center">
                                <ul class="nav navbar-nav navbar-right mainnav">

                                    <!-- start function for menu link-->

                                    <?php menu(); ?>

                                    <!-- end function for menu link -->

                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Menu End-->