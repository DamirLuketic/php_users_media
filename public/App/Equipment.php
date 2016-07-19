<?php

namespace App;

class Equipment
{

    protected $_con;
    protected $_user_id;
    protected $_page;
    protected $_npp;

    public $total_pages;

    public function __construct($con, $user_id, $page, $npp)
    {
        $this->_con = $con;
        $this->_user_id = $user_id;
        $this->_page = $page;
        $this->_npp = $npp;
    }

    public function total_pages()
    {
        $t=new \stdClass();

        $products = $this->_con->prepare('      select count(c.title)
                                                from users as a inner join equipment as b on a.user_id = b.user_id
                                                inner join products as c on b.product_id = c.product_id
                                                inner join categories as d on c.category = d.category_id
                                                inner join media as e on c.media = e.media_id
                                                where b.user_id = :user_id
                                         ');

        $products->execute([':user_id' => $this->_user_id]);

        $pages = ceil($products->fetchColumn() / $this->_npp);

        $t->pages = $pages;

        return $t;
    }

    public function products()
    {

        $products = $this->_con->prepare('      select c.title, d.name as "category_name", e.name as "media_name" 
                                                from users as a inner join equipment as b on a.user_id = b.user_id
                                                inner join products as c on b.product_id = c.product_id
                                                inner join categories as d on c.category = d.category_id
                                                inner join media as e on c.media = e.media_id
                                                where b.user_id = :user_id
                                                limit '  . (($this->_page * $this->_npp / $this->_npp)<=0 ? 0 : ($this->_page * $this->_npp - $this->_npp)) . ', ' . $this->_npp
                                            );

        $products->execute([':user_id' => $this->_user_id]);

        return $products = $products->fetchAll(\PDO::FETCH_OBJ);
    }



}