<?php

class CartItem {
    private $product;

    public function __construct($productID, $qty) {
        $this->product = new Product();
        $this->product->setID($productID);
        $this->product->setQty($qty);
    }

    public function addQty($qty) {

        $this->product->setQty($this->product->setQty() +  $qty);
    }

    public function getProduct(): Product {
        return $this->product;
    }
}

