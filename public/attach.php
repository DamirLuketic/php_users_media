<?php

include_once 'config.php';
include_once 'functions.php';

if(isset($_POST['user_id']) && isset($_POST['product_id']) && isset($_POST['page']) &&
    !empty($_POST['user_id']) && !empty($_POST['product_id']) && !empty($_POST['page']))
{
    attach($_POST['user_id'], $_POST['product_id'], $_POST['page']);
}