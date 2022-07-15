<?php
    require 'classes.php';  

    if (isset($_POST["pizza_type"]) && isset($_POST["pizza_size"]) && isset($_POST["sause_type"]) ) { 
    
    try {
        $db = new PDO('mysql:dbname=store;host=localhost','root','');
    } catch (PDOException $exception) {
        print 'EXCEPTION HERE' . $exception->getMessage();
    }
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlPriceQuery = 'SELECT price FROM products WHERE name=? AND type=?';

    
    $pizza_type = $_POST['pizza_type'];
    $pizza_size = $_POST['pizza_size'];
    $sause_type = $_POST['sause_type'];

    $q1 = $db->prepare($sqlPriceQuery);
    $q1->execute(array('pizza', $pizza_type));
    $row = $q1->fetch();
    $pizza_price = $row[0];

    $q2 = $db->prepare($sqlPriceQuery);
    $q2->execute(array('sause', $sause_type));
    $row = $q2->fetch();
    $sause_price = $row[0];
    
    $minSize = 21;

    $pizza = new $pizza_type($pizza_size, $pizza_price);
    $sause = new $sause_type($sause_price);
    $cashier = new Cashier($minSize);
    $cashier->calculateOrderPrice($pizza, $sause);
    
    $nbrb = curl_init('https://www.nbrb.by/api/exrates/rates/431');
    curl_setopt($nbrb, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($nbrb, CURLOPT_SSL_VERIFYHOST, false); 
    curl_setopt($nbrb, CURLOPT_RETURNTRANSFER , true);
    curl_setopt($nbrb, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $apiRes = curl_exec($nbrb);
    curl_close($nbrb);
    $entry = strripos($apiRes, 'Cur_OfficialRate');
    $len = strlen('Cur_OfficialRate') + 2;
    $rate = substr($apiRes, $entry + $len, 6);

    $result = array(
        'price' => (int)$rate * $cashier->getOrderPrice()
    ); 

    // Переводим массив в JSON
    echo json_encode($result); 
}
?>