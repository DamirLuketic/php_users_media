<?php

include_once 'config.php';
include_once 'functions.php';

insert_new_product($_POST['user_id'], $_POST['category'], $_POST['media'], $_POST['title'], $_POST['release_date']);