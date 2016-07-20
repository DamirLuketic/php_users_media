<?php

namespace App;

class AllProducts
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

        $products = $this->_con->query(' select count(title) from products ');

        $pages = ceil($products->fetchColumn() / $this->_npp);

        $t->pages = $pages;

        return $t;
    }

    public function products()
    {

        $products = $this->_con->query('        select a.title, a.product_id, a.release_date,  b.name as "category_name", c.name as "media_name" 
                                                from products as a inner join categories as b on a.category = b.category_id 
                                                inner join media as c on a.media = c.media_id
                                                limit '  . (($this->_page * $this->_npp / $this->_npp)<=0 ? 0 : ($this->_page * $this->_npp - $this->_npp)) . ', ' . $this->_npp
        );

        return $products = $products->fetchAll(\PDO::FETCH_OBJ);
    }
}