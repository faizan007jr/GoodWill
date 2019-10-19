<?php
session_start();
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
    <link rel="stylesheet" href="css/login.css?v=3" type="text/css" />
    <title>Goodwill: Login</title>
</head>

<body>

    <main class="container">
        <div class="jumbotron">
            <h1 class="display-4">Goodwill Electronics</h1>
            <p class="lead">A Simple way to find the best electronics you need.</p>
        </div>

        <div class="login-page">
            <div class="form-group m-auto col-12">
                <div class="m-auto col-lg-7 col-md-9 col-12">
                    <div class="log-box">
                        <div class="row">
                            <div class="col-xl-6 col-sm-5 col-12">
                                <div class="logo-back"></div>
                            </div>
                            <div class="col-xl-6 col-sm-7 col-12">
                                <form method='post'>
                                    <div class="log-content">
                                        <h2 class="text-primary">LOGIN</h2>
                                        <div class="log-body">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="email" name="txtUsername" class="form-control" placeholder="Enter email" required="" />
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" name="txtPassword" class="form-control" placeholder="Password" required="" />
                                            </div>
                                            <div class="form-group">
                                                <label class="text-danger">
                                                    <?php
                                                    require ('./conn.php');

                                                    if($con) {
                                                        if(isset($_POST['btnLogin'])) {
                                                            $userName = $_POST['txtUsername'];
                                                            $password = $_POST['txtPassword'];
                                                            $isSeller = isset($_POST['ckbSeller']);

                                                            if(!empty($userName) && !empty($password)) {
                                                                $tbl = ($isSeller == 1) ? "Sellers" : "Customers";
                                                                $sql = "SELECT COUNT(*) FROM " . $tbl . " WHERE Email=? AND Pwd=?";
                                                                $stmt = $con->prepare($sql);
                                                                $stmt->bind_param("ss", $userName, $password);

                                                                $stmt->execute();

                                                                $stmt->bind_result($isValid);
                                                                $stmt->fetch();
                                                                if($isValid) {
                                                                    if($isSeller == 1) {
                                                                        $_SESSION["seller"] = $userName;
                                                                        header('Location: ./admin');
                                                                    } else {
                                                                        $_SESSION["username"] = $userName;
                                                                        require ('./models/Cart.php');
                                                                        $_SESSION['cart'] = serialize(new Cart());

                                                                        header('Location: ./index.php');
                                                                    }
                                                                } else {
                                                                    echo 'Incorrect username or password!';
                                                                }
                                                                $stmt->close();
                                                                $con->close();

                                                            } else {
                                                                echo 'Username & Password required';
                                                            }
                                                        }
                                                    } else {
                                                        echo 'Connectivity issue';
                                                    }
                                                    ?>
                                                </label>
                                            </div>
                                            <div class="form-group text-center">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" name="ckbSeller" id="ckbSeller" value="seller" style="cursor: pointer;" />
                                                    <label class="custom-control-label" for="ckbSeller" style="cursor: pointer;">
                                                        Seller?
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="log-btn">
                                                <input type="submit" name="btnLogin" class="btn btn-primary btn-block" value="Login" />
                                            </div>
                                            <div class="log-bottom-content text-center mt-3">
                                                <p>
                                                    Create an account <a href="signup.php">Sign Up</a><br />
                                                    <!--<a href="#">Forgot Password?</a>-->
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="page-footer text-light bg-primary pt-4 mt-2">

        <div class="container mt-3">

            <ul class="list-unstyled list-inline text-center">
                <li class="list-inline-item">
                    <a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-square" style='font-size:2.5em;color: #3B5998;'></i></a>
                </li>
                <li class="list-inline-item">
                    <a href="https://twitter.com/" target="_blank"><i class="fab fa-twitter" style='font-size:2.5em;color: #55ACEE;'></i></a>
                </li>
                <li class="list-inline-item">
                    <a href="https://www.google.com/" target="_blank"><i class="fab fa-google" style='font-size:2.5em;color: #dd4b39;'></i></a>
                </li>
                <li class="list-inline-item">
                    <a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram" style='font-size:2.5em;color: #125688;'></i></a>
                </li>
                <li class="list-inline-item">
                    <a href="https://www.snapchat.com/" target="_blank"><i class="fab fa-snapchat-ghost" style='font-size:2.5em;color: #fffc00;'></i></a>
                </li>
            </ul>

        </div>

        <div class="footer-copyright text-center py-3">&copy; <span>
            <script>
                document.write((new Date()).getFullYear());
            </script>
        </span> Copyright:
            <a href="./index.php"> Goodwill.com </a>
        </div>

    </footer>

    <script type="text/javascript" src="scripts/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="scripts/font-awesome.min.js"></script>
</body>

</html>
