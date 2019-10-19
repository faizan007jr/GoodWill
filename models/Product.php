<?php

class Product
{
    private $ID;
    private $qty;

    public function getID() {
        return $this->ID;
    }
    public function setID($ID): void {
        $this->ID = $ID;
    }

    public function getQty() {
        return $this->qty;
    }

    public function setQty($qty): void {
        $this->qty = $qty;
    }
}