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
            '#header_part' => 'List',
            '#working' => 'Work page',
            '#users' => 'Users',
            '#contact_section' => 'Contact',
            'log_out.php' => 'Log Out'
        );
    }else
    {
        $pages = array
        (
            'register.php'  => 'Register',
            'login.php'     => 'LogIn',
        );
    }

        foreach ($pages as $address => $name)
        {
            echo '<li><a href="' . $address . '">' . $name . '</a></li>';
        }
};