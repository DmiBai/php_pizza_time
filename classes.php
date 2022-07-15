<?php
 
abstract class Product{
    private $price;

    public function __construct($price) {
        $this->price = $price;
    }

    public function getPrice() : float {
        return $this->price;
    }
    public function setPrice($price){
        $this->price = $price;
    }
}

abstract class Pizza extends Product{
    private $type;
    private $size;

    public function __construct($type, $size, $price) {
        parent::__construct($price);
        $this->type = $type;
        $this->size = $size;
    }

    public function getType() : string {
        return $this->type;
    }
    public function getSize() : int {
        return $this->size;
    }
    public function setSize($size){
        $this->size = $size;
    }
}

abstract class Sause extends Product{
    private $type;
    
    public function __construct($type, $price) {
        parent::__construct($price);
        $this->type = $type;
    }

    public function getType() : string {
        return $this->type;
    }
}
///////////////////////////////Pizzas
class Pepperoni extends Pizza{
    public function __construct($size, $price){
        $type = 'pepperoni';
        parent::__construct($type, $size, $price);
    }
}
class Rustic extends Pizza{
    public function __construct($size, $price){
        $type = 'rustic';
        parent::__construct($type, $size, $price);
    }
}
class Hawaii extends Pizza{
    public function __construct($size, $price){
        $type = 'hawaii';
        parent::__construct($type, $size, $price);
    }
}
class Mushroom extends Pizza{
    public function __construct($size, $price){
        $type = 'mushroom';
        parent::__construct($type, $size, $price);
    }
}
////////////////////////////////Sauses
class Cheese extends Sause{
    public function __construct($price){
        $type = 'cheese';
        parent::__construct($type, $price);
    }
}
class Garlic extends Sause{
    public function __construct($price){
        $type = 'garlic';
        parent::__construct($type, $price);
    }
}
class SweetAndSour extends Sause{
    public function __construct($price){
        $type = 'sweet_and_sour';
        parent::__construct($type, $price);
    }
}
class Bbq extends Sause{
    public function __construct($price){
        $type = 'bbq';
        parent::__construct($type, $price);
    }
}
////////////////////////////////Cashier
class Cashier{
    private $orderPrice;
    private $minSize;
    private string $order;

    public function __construct($minSize){
        $this->orderPrice = 0;
        $this->minSize = $minSize;
    }

    public function calculateOrderPrice(Pizza $pizza, Sause $sause){
        $this->orderPrice = $pizza->getPrice();
        $this->orderPrice *= $pizza->getSize() / $this->minSize;
        $this->orderPrice += $sause->getPrice();
        $this->orderPrice = round($this->orderPrice, 2, PHP_ROUND_HALF_DOWN);
    }

    public function getOrderPrice() : float {
        return $this->orderPrice;
    }
}

?>