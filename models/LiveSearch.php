<?php

require('../conn.php');
if($con) {
    $productsName = [];
    $productsID = [];

    $sql = "SELECT ProductID, Name FROM Products";
    $result = $con->query($sql);

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($productsID, $row['ProductID']);
            array_push($productsName, $row['Name']);
        }
    }
    $products = [$productsID, $productsName];

    $q=$_GET["q"];

    if (strlen($q)>0) {
        $hint="";
        for($i=0; $i<sizeof($products[0]); $i++) {
            $Name = $products[1][$i];
            $ID = $products[0][$i];
            if (stristr($Name,$q)) {
                $hint .= "<option id='" . $ID . "'>" . $Name . "</option>";
            }
        }
    }

    if ($hint=="") {
        $response="no suggestion";
    } else {
        $response=$hint;
    }
    echo $response;
}