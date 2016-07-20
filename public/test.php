<?php

include "config.php";

    //function for find user products
function user_products($user_id)
{

    //result is global variable
global $attach_array;

    //catch all products from current user
$test = $GLOBALS['con']->prepare(' select product_id from equipment where user_id = :user_id');
$test->execute([
':user_id' => $user_id
]);

$test_attach = $test->fetchAll(PDO::FETCH_OBJ);

    // array for user products id
$attach_array = array();

    // put all product id in array
foreach($test_attach as $attach)
{
$attach_array[] .= $attach->product_id;
}
    //send result when call function
return $attach_array;
}


header('location: index.php?page=' . $page);