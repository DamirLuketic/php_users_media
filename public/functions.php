<?php

include_once 'config.php';

// First is function for login, because function register call function login

// function for logIn

function logIn($email, $password)
{
    if(isset($email) && isset($password) && !empty($email) && !empty($password))
    {
        $user = $GLOBALS['con']->prepare(' select * from users where email = :email and password = md5(:password) ');
        $user->execute([
            ':email'     => $email,
            ':password' => $password
        ]);

        $user = $user->fetch(PDO::FETCH_OBJ);

        // set user cookie for one weekend
        if(isset($user->user_id))
        {

            setcookie('user_id', $user->user_id, time() + 86400);
            setcookie('user_role', $user->role, time() + 86400);
            setcookie('user_email', $user->email, time() + 86400);

            header('location: index.php');
        }
    }
};

//function for show error in logIn

function login_try()
{
    if(!isset($_POST['email']) || !isset($_POST['password']) || empty($_POST['password']) || empty($_POST['email']))
    {
        echo 'Enter email and password';
    }else
    {
        if(!isset($_COOKIE['user_id']))
        {
            echo 'Wrong e-mail\password';
        }
    }
}

// function for registration
function register ($name, $email, $password, $repeat_password = '')
{
    //check all required field and continue after success
    if(isset($name) && isset($email) && isset($password) && isset($repeat_password) &&
    !empty($name) && !empty($email) && !empty($password) && !empty($repeat_password)
    )
    {
        //check if password is matched with repeat password
        if($password === $repeat_password)
        {
            //check e-mail in db
            $check_email = $GLOBALS['con']->prepare(' select email from users where email = :email ');
            $check_email->execute(array(
                'email' => $_POST['email']
            ));
            $check_emails = $check_email->fetchAll(PDO::FETCH_OBJ);
            foreach($check_emails as $check)
            {
                // if e-email is already in use registration is abort and user have message
                if($email == $check->email)
                {
                    return $_SESSION['msg'] = 'Email address already in use';
                }
            }

            // if test who compare current e-mail with all e-mail in db is not positive, function continue

            $register = $GLOBALS['con']->prepare(' insert into users(name, email, password) values 
                                                (:name, :email, md5(:password))
                                              ');
            $register->execute([
                ':name'     => $name,
                ':email'    => $email,
                ':password' => $password
                    ]);

                // logIn user after successful registration

                logIn($email, $password);
            
        }else
        {
            // if password don't match this is the message for show
            $_SESSION['msg'] = 'Password and confirm password not match';
        }
    }
}

// function for log off
function log_off()
{
    // set variable time to past
    $past = time() - 3600;

    // unset all cookie

        foreach ( $_COOKIE as $key => $value )
        {
            setcookie( $key, $value, $past);
        }

    header('location: index.php');
}

//function for menu link

function menu()
    {

    if(isset($_COOKIE['user_id']))
    {
        $pages = array
        (
            'index.php'           => 'Index',
            'all_products.php'    => 'All Products',
            'users.php'           => 'Users',
            'log_out.php'         => 'Log Out'
        );
    }else
    {
        $pages = array
        (
            'index.php'     => 'Index',
            'register.php'  => 'Register',
            'login.php'     => 'LogIn',
        );
    }

        foreach ($pages as $address => $name)
        {
            echo '<li><a href="' . $address . '">' . $name . '</a></li>';
        }
};

//attach product to user

function attach($user_id, $product_id)
{
    $attach = $GLOBALS['con']->prepare(' insert into equipment (user_id, product_id) values (:user_id, :product_id) ');
    $attach->execute([
                    ':user_id'      => $user_id,
                    ':product_id'   => $product_id
                    ]);

    header('location: all_products.php');
}

//function for attach products from all product -> when come from all products page
// when come from all products pages we also need page number, and headers location is different
function attach_when_all_products($user_id, $product_id, $page)
{
    $attach = $GLOBALS['con']->prepare(' insert into equipment (user_id, product_id) values (:user_id, :product_id) ');
    $attach->execute([
        ':user_id'      => $user_id,
        ':product_id'   => $product_id
    ]);

    header('location: all_products.php?page=' . $page);
}

//insert new product

function insert_new_product($user_id, $category, $media, $title, $release_date)
{

    $insert = $GLOBALS['con']->prepare(' insert into products (category, media, title, release_date) values 
                                        (:category, :media, :title, :release_date)
                                      ');
    $insert->execute([
                                    ':category'     => $category,
                                    'media'         => $media,
                                    'title'         => $title,
                                    'release_date'  => $release_date
                                    ]);

    $product_id = $GLOBALS['con']->lastInsertId();


    // after insert products into db, add product to user equipment
    attach($user_id, $product_id);

    header('location: index.php');
}

//function for detach products from equipment list -> when come from user list page
function detach_from_equipment($user_id, $product_id)
{
    if(isset($user_id) && isset($product_id)&& !empty($user_id)&&!empty($product_id))
    {
        $detach = $GLOBALS['con']->prepare(' delete from equipment where user_id = :user_id and product_id = :product_id ');
        $detach->execute([
                        ':user_id'       => $user_id,
                        ':product_id'    => $product_id
                        ]);
        header('location: index.php');
    }
}

//function for detach products from equipment list -> when come from all products page
    // when come from all products pages we also need page number, and headers location is different
function detach_when_all_products($user_id, $product_id, $page)
{
    if(isset($user_id) && isset($product_id)&& !empty($user_id)&&!empty($product_id))
    {
        $detach = $GLOBALS['con']->prepare(' delete from equipment where user_id = :user_id and product_id = :product_id ');
        $detach->execute([
            ':user_id'       => $user_id,
            ':product_id'    => $product_id
        ]);
        header('location: all_products.php?page=' . $page );
    }
}

//function for find user products -> for option of attach or detach product
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

//function for fast access on user data
function user_data($user_id)
{
    global $user_data;
    
    $user = $GLOBALS['con']->prepare(' select * from users where user_id = :user_id ');
    $user->execute([
                    ':user_id' => $user_id
                    ]);
    $user_data = $user->fetch(PDO::FETCH_OBJ);
    
    return $user_data;
}

















