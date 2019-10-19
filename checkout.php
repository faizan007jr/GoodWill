<?php
$page_title = 'CheckOut';
include('./master-header.php');
$total = 0;
if(!empty($_SESSION['total'])) {
    $total =  $_SESSION['total'];
}
?>

<div class="container mt-5 mb-5">
    <div class="form-body">
        <div class="row">
            <form method="post" class="col-xs-6 m-auto">
                <h2 class="text-primary">Checkout Information</h2>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $_SESSION['username']; ?>" disabled required="required">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-3 offset-3">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="radioCredit" name="radioCard" class="custom-control-input" value="Credit" checked="">
                                <label class="custom-control-label" for="radioCredit">Credit</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="radioDebit" name="radioCard" class="custom-control-input" value="Debit">
                                <label class="custom-control-label" for="radioDebit">Debit</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="number" min="1000000000000000" max="9999999999999999" class="form-control" name="cardno" placeholder="Card Number" required="required">
                </div>
                <div class="form-group">
                    <input type="text"  maxlength="5" minlength="5" class="form-control" name="expdate" placeholder="Expiration Date (mm/yy)" required="required">
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" min="100" max="999" name="cvv" placeholder="cvv" required="required">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="total" placeholder="total" value="<?php echo '$' . $total; ?>" disabled="" required="required">
                </div>
                <div class="form-group" id="msg_box">
                    <label class="text-danger">
                        <?php
                        require ('conn.php');
                        if(isset($_POST['submit'])) {
                            $txtEmail = $_SESSION['username'];
                            $rBtnCard = $_POST['radioCard'];
                            $txtCardNo = $_POST['cardno'];
                            $txtExpDate = $_POST['expdate'];
                            $txtCvv = $_POST['cvv'];

                            if(!empty($txtEmail) && !empty($txtCardNo) &&
                                !empty($txtExpDate) && !empty($txtCvv)) {

                                    if($con) {
                                        $sql = "CALL GetOrderID(?)";
                                        $stmt = $con->prepare($sql);
                                        $stmt->bind_param("s", $txtEmail);

                                        $stmt->execute();

                                        $stmt->bind_result($orderID);
                                        $stmt->fetch();
                                        $stmt->close();

                                        if($orderID) {
                                            $i = 1;
                                            foreach ($cart->getCart() as $cartItem) {
                                                $sql = "INSERT INTO OrderItems (OrderID, ProductID, Quantity) VALUE (?,?,?)";
                                                $stmt = $con->prepare($sql);
                                                $stmt->bind_param("sss", $orderID, $productID, $qty);

                                                $productID = $cartItem->getProduct()->getID();
                                                $qty = $cartItem->getProduct()->getQty();

                                                $stmt->execute();
                                            }
                                            $stmt->close();

                                            $sql = "INSERT INTO Payments VALUE (DEFAULT,?,?,?,?,?)";
                                            $stmt = $con->prepare($sql);
                                            $stmt->bind_param("sssss", $rBtnCard, $txtCardNo, $txtExpDate, $txtCvv, $orderID);

                                            $stmt->execute();
                                            $stmt->close();

                                            // Sign Up email
                                            require_once ('./models/mail.php');
                                            $mail->Subject = 'Welcome to Goodwill Electronics';
                                            $mail->Body = '<h5>Your Order Details:</h5><br /><p>Username: ' . $txtEmail . '<br />Total: ' . $total . '</p>';
                                            $mail->AddAddress($txtEmail);
                                            $mail->Send();

                                            $_SESSION['cart'] = serialize(new Cart());
                                            $_SESSION['orderID'] = $orderID;

                                            require ('./models/redirect.php');
                                            redirect('./detail.php');
                                        } else {
                                            echo "Sorry! There is an error completing your checkout.";
                                        }
                                        $con->close();
                                    } else {
                                        echo "Database connection problem.";
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
                    <input type="submit" name="submit" class="btn btn-primary btn-lg btn-block" value="Checkout" />
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include ('./master-footer.html');
?>
