<?php
$page_title = 'User';
$cart_items = 0;
include('./master-header.php');
$sql = "SELECT Line1, Line2, City, State, PostalCode FROM Addresses WHERE AddressID = (SELECT AddressID FROM Customers WHERE Email=?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $email);

$email = $_SESSION['username'];

$stmt->execute();

$stmt->bind_result($Line1, $Line2, $City, $State, $PostalCode);
$stmt->fetch();
?>

<div class="container">
    <div class="form-body">
        <div class="row">
            <form method="post" class="col-xs-6 m-auto">
                <h2 class="text-primary">User Information</h2>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $_SESSION['username']; ?>" disabled required="required">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="New Password" required="required">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required="required">
                </div>
                <div class="form-group">
                    <label class="form-text">Address</label>
                    <input type="text" class="form-control" id="line1" name="line1" placeholder="Line 1" value="<?php echo $Line1; ?>" required="required">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="line2" name="line2" placeholder="Line 2" value="<?php echo $Line2; ?>">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6"><input type="text" class="form-control" name="city" placeholder="City" value="<?php echo $City; ?>" required="required"></div>
                        <div class="col-6"><input type="text" class="form-control" name="state" placeholder="State" value="<?php echo $State; ?>" required="required"></div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Postal Code" value="<?php echo $PostalCode; ?>" required="required">
                </div>
                <div class="form-group" id="msg_box">
                    <label class="text-danger">
                        <?php
                        require ('conn.php');
                        if(isset($_POST['submit'])) {
                            $txtEmail = $_SESSION['username'];
                            $txtPassword = $_POST['password'];
                            $txtConfirmPassword = $_POST['confirm_password'];
                            $txtLine1 = $_POST['line1'];
                            $txtLine2 = !empty($_POST['line2']) ? $_POST['line2'] : ' ';
                            $txtCity = $_POST['city'];
                            $txtState = $_POST['state'];
                            $txtPostalCode = $_POST['postal_code'];

                            if(!empty($txtEmail) && !empty($txtPassword) &&
                                !empty($txtConfirmPassword) && !empty($txtLine1) &&
                                !empty($txtCity) && !empty($txtState) &&
                                !empty($txtPostalCode)) {

                                if($txtPassword == $txtConfirmPassword) {

                                    if($con) {
                                        $sql = "CALL UpdateCustomer(?,?,?,?,?,?,?)";
                                        $stmt = $con->prepare($sql);
                                        $stmt->bind_param("sssssss", $txtEmail, $txtPassword,
                                            $txtLine1, $txtLine2, $txtCity, $txtState, $txtPostalCode);

                                        $stmt->execute();

                                        $stmt->bind_result($isUpdated);
                                        $stmt->fetch();

                                        if($isUpdated) {
                                            $_SESSION["username"] = $txtEmail;

                                            // User Detail Update email
                                            require_once ('./models/mail.php');
                                            $mail->Subject = 'Welcome to Goodwill Electronics';
                                            $mail->Body = '<h5>Your Updated credentials:</h5><br /><p>Username: ' . $txtEmail . '<br />Password: ' . $txtPassword . '</p>';
                                            $mail->AddAddress($txtEmail);
                                            $mail->Send();

                                            require ('models/redirect.php');
                                            redirect('./index.php');
                                        } else {
                                            echo "Unable to update user info.";
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
                    <input type="submit" name="submit" class="btn btn-primary btn-lg btn-block" value="Update" />
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include ('./master-footer.html');
?>
