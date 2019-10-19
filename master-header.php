<?php
session_start();
require ('./conn.php');

if(isset($_POST["logout"])) {
    session_destroy();
    header('Location: ./login.php');
}

if(empty($_SESSION["username"])) {
    header('Location: ./login.php');
} else {
    if($con) {
        include ('./models/getUserDetails.php');
        require ('./models/Cart.php');
    }
}

$cart = unserialize($_SESSION['cart']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="./images/icons/icons8-shopping-bag-filled-50.png" />
    <link rel="stylesheet" href="./css/bootstrap-flatly.min.css" type="text/css" />
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/main.css?v=7" type="text/css" />
    <script type="text/javascript" src="scripts/jquery.min.js"></script>
    <title>Goodwill: <?php echo $page_title; ?></title>
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Goodwill</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item  <?php echo ($page_title == 'Home') ? 'active' : '' ?>">
                        <a class="nav-link" href="index.php"><i class="fa fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item  <?php echo ($page_title == 'Shop') ? 'active' : '' ?>">
                        <a class="nav-link" href="shop.php"><i class="fa fa-shopping-basket"></i> Shop</a>
                    </li>
                    <li class="nav-item  <?php echo ($page_title == 'Cart') ? 'active' : '' ?>">
                        <a class="nav-link" href="cart.php"><i class="fa fa-shopping-cart"></i> Cart <span class="badge badge-warning"><?php echo $cart->getCount(); ?></span></a>
                    </li>
                    <li class="nav-item  <?php echo ($page_title == 'About') ? 'active' : '' ?>">
                        <a class="nav-link" href="about.php"><i class="fa fa-address-book"></i> About</a>
                    </li>
                </ul>
                <form class="form-inline my-2" method="post">
                    <input type="text" list="products" name="txtSearchBox" id="txtSearchBox" class="form-control mr-sm-2 ml-sm-2" placeholder="Search" onkeyup="showResult(this.value)" />
                    <datalist id="products" name="products"></datalist>
                    <input class="btn btn-secondary my-2 my-sm-0" type="submit" name="search" value="Search" />
                    <?php
                    if(isset($_POST['search'])) {
                        if(!empty($_POST['txtSearchBox'])) {
                            $name = $_POST['txtSearchBox'];
                            $sql = "SELECT ProductID FROM Products WHERE `Name`=? LIMIT 1";
                            $stmt = $con->prepare($sql);
                            $stmt->bind_param("s", $name);
                            $stmt->execute();
                            $stmt->bind_result($ID);
                            $stmt->fetch();
                            $stmt->close();
                            if($ID) {
                                header('Location: ./description.php?id=' . $ID);
                            }
                        }
                    }
                    ?>
                </form>
                <form class="form-inline my-2" method="post">
                    <p class="col-form-label text-light mr-2 my-sm-0 ml-2">
                        <a class="nav-item font-weight-bold" href="./user.php">
                            <i class="fa fa-user-alt"></i> <?php echo strtoupper($firstName . ' ' . $lastName) ?>
                        </a>
                    </p>
                    <input class="btn btn-warning my-2 my-sm-0" type="submit" name="logout" value="Log Out" />
                </form>
            </div>
        </div>
    </nav>
    <main class="container mt-5 pt-5">
