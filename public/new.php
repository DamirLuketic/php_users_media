<!-- Working Section Start -->
<section id="new">
    <div class="welcome_section">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row">
                        <!-- About text start -->
                        <div class="section-title">
                            <h2>Create new product data:</h2>
                            <p>New product will be automatically added to your products list.</p>
                        </div>
                        <!-- About text end -->
                    </div>
                    <!-- About service part start-->

                    <!-- user most be logIn to have access page for insert product into db -->

                    <?php if(isset($_COOKIE['user_id'])): ?>

                    <div class="row">

                        <!-- form for new product data -->

                        <form action="create_attach.php" method="post">

                        <input type="hidden" name="user_id" value="<?php echo $_COOKIE['user_id']; ?>">
                        
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <div class="welcome_part wow fadeInLeft">
                                <div class="text-center">

                                    <?php
                                    $categories = $GLOBALS['con']->query(' select * from categories ');
                                    $categories = $categories->fetchAll(PDO::FETCH_OBJ);
                                    ?>

                                    <select required="required" name="category" id="categories">

                                    <?php foreach ($categories as $category): ?>

                                        <option value="<?php echo $category->category_id; ?>"><?php echo $category->name; ?></option>

                                    <?php endforeach; ?>

                                     </select>

                                </div>
                                <h2>Category</h2>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <div class="welcome_part wow fadeInLeft">
                                <div class="text-center">

                                    <?php
                                    $media = $GLOBALS['con']->query(' select * from media ');
                                    $media = $media->fetchAll(PDO::FETCH_OBJ);
                                    ?>

                                    <select required="required" name="media" id="media">

                                        <?php foreach ($media as $m): ?>

                                            <option value="<?php echo $m->media_id; ?>"><?php echo $m->name; ?></option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>
                                <h2>Media</h2>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <div class="welcome_part wow fadeInLeft">
                                <div class="text-center">
                                    <input required="required" type="text" name="title">
                                </div>
                                <h2>Title</h2>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <div class="welcome_part wow fadeInLeft">
                                <div class="text-center">
                                    <input type="date" name="release_date">
                                </div>
                                <h2>Release date</h2>
                            </div>
                        </div>

                        <div class="row">
                            <div class="text-center">
                                <div class="form-group">
                                    <input type="submit" name="submit" class="btn btn-primary" value="Insert">
                                </div>
                            </div>
                        </div>

                        </form>

                        <!-- end of form for new product data -->

                    </div>

                        <!-- if user is not logIn show next -->
                    <?php else: ?>

                    <div class="text-center">
                        <h3>Please logIn and have access to insert new product into db</h3>
                    </div>

                    <?php endif; ?>


                    <!-- About service part end-->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Working Section End -->	