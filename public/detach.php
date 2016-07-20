<?php

include_once 'config.php';
include_once 'functions.php';

if(isset($_POST['user_id']) && isset($_POST['product_id']) &&
    !empty($_POST['user_id']) && !empty($_POST['product_id']))
{
    detach_from_equipment($_POST['user_id'], $_POST['product_id']);
}