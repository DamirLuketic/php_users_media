<?php

namespace App;

class Users
{

    protected $_con;
    protected $_page;
    protected $_npp;

    public $total_pages;

    public function __construct($con, $page, $npp)
    {
        $this->_con = $con;
        $this->_page = $page;
        $this->_npp = $npp;
    }

    public function total_pages()
    {
        $t=new \stdClass();

        $users = $this->_con->query(' select count(name) from users ');

        $pages = ceil($users->fetchColumn() / $this->_npp);

        $t->pages = $pages;

        return $t;
    }

    public function users()
    {

        $users = $this->_con->query('        select * from users
                                                limit '  . (($this->_page * $this->_npp / $this->_npp)<=0 ? 0 : ($this->_page * $this->_npp - $this->_npp)) . ', ' . $this->_npp
        );

        return $products = $users->fetchAll(\PDO::FETCH_OBJ);
    }
}