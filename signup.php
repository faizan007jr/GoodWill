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
    <link rel="stylesheet" href="./css/signup.css?v=1" type="text/css" />
    <link rel="stylesheet" href="./css/datepicker.css" type="text/css" />
    <script type="text/javascript" src="scripts/jquery.min.js"></script>
    <title>Goodwill: Sign Up</title>
</head>

<body>

    <main class="container">
        <div class="jumbotron">
            <h1 class="display-4">Goodwill Electronics</h1>
            <p class="lead">A Simple way to find the best electronics you need.</p>
        </div>

        <div class="form-body">
            <div class="signup-form">
                <form method="post">
                    <h2>Register</h2>
                    <p class="hint-text">Create your account. It's free and only takes a minute.</p>
                    <div class="form-group text-center">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="ckbSeller" id="ckbSeller" value="seller" <?php echo isset($_POST['ckbSeller']) == 1 ? "checked" : '' ?> style="cursor: pointer;" />
                            <label class="custom-control-label" for="ckbSeller" style="cursor: pointer;">
                                Seller?
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6"><input type="text" class="form-control" name="first_name" value="<?php echo isset($_POST['first_name']) ? $_POST['first_name'] : '' ?>" placeholder="First Name" required="required"></div>
                            <div class="col-6"><input type="text" class="form-control" name="last_name" value="<?php echo isset($_POST['last_name']) ? $_POST['last_name'] : '' ?>" placeholder="Last Name" required="required"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>" placeholder="Email" required="required">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" required="required">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required="required">
                    </div>

                    <div id="customer">

                        <div class="form-group">
                            <div class="input-append date" id="dp3" data-date="2019-02-12" data-date-format="yyyy-mm-dd">
                                <input class="span2 form-control" id="dp" name="dob" value="<?php echo isset($_POST['dob']) ? $_POST['dob'] : '' ?>" size="16" type="text" placeholder="DOB">
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3 offset-3">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radioMale" name="radioGender" class="custom-control-input" value="Male" checked="">
                                        <label class="custom-control-label" for="radioMale">Male</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radioFemale" name="radioGender" class="custom-control-input" value="Female">
                                        <label class="custom-control-label" for="radioFemale">Female</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="form-text">Address</label>
                        <input type="text" class="form-control" id="line1" name="line1" value="<?php echo isset($_POST['line1']) ? $_POST['line1'] : '' ?>" placeholder="Line 1" required="required">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="line2" name="line2" value="<?php echo isset($_POST['line2']) ? $_POST['line2'] : '' ?>" placeholder="Line 2">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6"><input type="text" class="form-control" name="city" value="<?php echo isset($_POST['city']) ? $_POST['city'] : '' ?>" placeholder="City" required="required"></div>
                            <div class="col-6"><input type="text" class="form-control" name="state" value="<?php echo isset($_POST['state']) ? $_POST['state'] : '' ?>" placeholder="State" required="required"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="postal_code" name="postal_code" value="<?php echo isset($_POST['postal_code']) ? $_POST['postal_code'] : '' ?>" placeholder="Postal Code" required="required">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="ckbTerms" name="ckbTerms" required="required">
                            <label class="custom-control-label" for="ckbTerms"> I accept the <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></label>
                        </div>
                    </div>
                    <div class="form-group" id="msg_box">
                        <label class="text-danger">
                            <?php
                            require ('conn.php');
                            if(isset($_POST['submit'])) {
                                $txtFirstName = $_POST['first_name'];
                                $txtLastName = $_POST['last_name'];
                                $txtEmail = $_POST['email'];
                                $txtPassword = $_POST['password'];
                                $txtConfirmPassword = $_POST['confirm_password'];
                                $txtDOB = $_POST['dob'];
                                $rBtnGender = $_POST['radioGender'];
                                $txtLine1 = $_POST['line1'];
                                $txtLine2 = $_POST['line2'];
                                $txtCity = $_POST['city'];
                                $txtState = $_POST['state'];
                                $txtPostalCode = $_POST['postal_code'];

                                 if(!empty($txtFirstName) && !empty($txtLastName) &&
                                     !empty($txtEmail) && !empty($txtPassword) &&
                                     !empty($txtConfirmPassword) && !empty($txtDOB) &&
                                     !empty($txtLine1) && !empty($txtLine2) &&
                                     !empty($txtCity) && !empty($txtState) && !empty($txtPostalCode)) {

                                     if($txtPassword == $txtConfirmPassword) {

                                         if($con) {
                                             $sql = "CALL InsertCustomer(?,?,?,?,?,?,?,?,?,?,?)";
                                             $stmt = $con->prepare($sql);
                                             $stmt->bind_param("sssssssssss", $txtFirstName, $txtLastName,
                                                 $txtEmail, $txtPassword, $txtDOB, $rBtnGender, $txtLine1, $txtLine2,
                                                 $txtCity, $txtState, $txtPostalCode);

                                             $stmt->execute();

                                             $stmt->bind_result($isInserted);
                                             $stmt->fetch();

                                             if($isInserted) {
                                                 $_SESSION["username"] = $txtEmail;

                                                 // Sign Up email
                                                 require_once ('./models/mail.php');
                                                 $mail->Subject = 'Welcome to Goodwill Electronics';
                                                 $mail->Body = '<h5>Your credentials:</h5><br /><p>Username: ' . $txtEmail . '<br />Password: ' . $txtPassword . '</p>';
                                                 $mail->AddAddress($txtEmail);
                                                 $mail->Send();

                                                 require ('./models/Cart.php');
                                                 $_SESSION['cart'] = serialize(new Cart());

                                                 require ('models/redirect.php');
                                                 redirect('./index.php');
                                             } else {
                                                 echo "Unable to create user. <br /> Hint: Email must be unique.";
                                             }

                                             $stmt->close();
                                             $con->close();
                                         } else {
                                             echo "Database connection problem.";
                                         }
                                     } else {
                                         echo "Password should be equal to Confirm Password.";
                                     }
                                 } else {
                                     echo 'All the fields are Required';
                                 }
                            } else {
                                echo "
                                    <script>
                                        $('#msg_box').hide();
                                    </script>
                                ";
                            }
                            ?>
                        </label>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary btn-lg btn-block" value="Register Now" />
                    </div>
                </form>
                <div class="text-center">Already have an account? <a href="#">Sign in</a></div>
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

    <script type="text/javascript" src="scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="scripts/font-awesome.min.js"></script>
    <script type="text/javascript" src="scripts/date-picker.js"></script>
    <script>
        var today = new Date();

        var maxDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
        $('#dp').datepicker({
            format: 'yyyy-mm-dd'
        }).on('changeDate', function(ev) {
            if (ev.date.valueOf() > maxDate.valueOf()) {
                alert('DOB must be smaller than today\'s date');
            }
            $('#dp').datepicker('hide');
        });

        function ifSeller(isVal) {
            if(isVal) {
                $("#customer").hide();
            } else {
                $("#customer").show();
            }
        }

        $(() => {
            var sel = ($("#ckbSeller").is(':checked')) ? true : false;
            ifSeller(sel);

            $("#ckbSeller").change(() => {
                var seller = ($("#ckbSeller").is(':checked')) ? true : false;
                ifSeller(seller);
            });
        });

    </script>
</body>

</html>
