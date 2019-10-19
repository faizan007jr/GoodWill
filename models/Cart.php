<?php

include './models/Product.php';
include './models/CartItem.php';

class Cart {
    private $cartItems;
    private $count;

    public function __construct() {
        $this->cartItems = [];
        $this->count = 0;
    }

    public function getCount() {
        return $this->count;
    }

    public function getCartItemByIndex($key) : Product {
        return $this->cartItems[$key]->getProduct();
    }

    public function getCartItemByID($ID) : Product {
        foreach ($this->cartItems as $item) {
           if($item->getProduct()->getID() == $ID) {
                return $item->getProduct();
           }
        }
        return null;
    }

    public function getCart() {
        return $this->cartItems;
    }

    public function AddItem($productID, $qty) {
        $this->count += $qty;
        foreach ($this->cartItems as $cartItem) {
            if($cartItem->getProduct()->getID() == $productID) {
                $cartItem->getProduct()->setQty($cartItem->getProduct()->getQty() + $qty);
                return;
            }
        }
        array_push($this->cartItems,
            new CartItem($productID, $qty));
    }

    public function RemoveAt($key) {
        if(array_key_exists($key, $this->cartItems)) {
            unset($this->cartItems[$key]);
        }
    }

    public function RemoveByID($ID) {
        for($i = 0; $i < sizeof($this->cartItems); $i++) {
            if($this->cartItems[$i]->getProduct()->getID() == $ID) {
                $this->count -= $this->cartItems[$i]->getProduct()->getQty();
                unset($this->cartItems[$i]);
                $this->cartItems = array_values($this->cartItems);
                return;
            }
        }
    }

    public function Clear() {
        return empty($this->cartItems);
    }

    public function HasProduct($ID) {
        foreach ($this->cartItems as $cartItem) {
            if($cartItem->getProduct()->getID() == $ID) {
                return true;
            }
        }
        return false;
    }

    public function UpdateQuantity($qty) {
        $i = 0;
        $total = 0;
        foreach ($this->cartItems as $cartItem) {
            $cartItem->getProduct()->setQty($qty[$i]);
            $total += $qty[$i];
            $i++;
        }
        $this->count = $total;
    }
}

