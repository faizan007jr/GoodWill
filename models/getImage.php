<?php
header("Content-type: image/");
if(isset($_GET['id'])) {
    require ('../conn.php');

    if($con) {
        $sql = "SELECT ImageFile FROM Images WHERE ProductID=?";
        $stmt = $con->prepare($sql);
        $id = (int)$_GET['id'];
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $stmt->bind_result($img);
        $stmt->fetch();
        echo $img;
    }
}