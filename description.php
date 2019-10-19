<?php
$page_title = 'Description';
$cart_items = 0;
include('./master-header.php');
if(isset($_GET['id'])) {
?>
    <form method="post" class="mt-4 mb-5">

        <div class="row">
            <?php
            if($con) {
                $sql = "SELECT `Name`, Price, Description, Quantity FROM Products INNER JOIN Inventories ON Products.ProductID = Inventories.ProductID WHERE Products.ProductID=?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("s", $productID);

                $productID = $_GET['id'];

                $stmt->execute();

                $stmt->bind_result($name, $price, $description, $maxQty);
                $stmt->fetch();
                $stmt->close();
                ?>
                <div class="col-lg-4 col-md-6 mb-4 m-auto">
                    <div class="card h-100">
                        <img class="card-img-top" src="./models/getImage.php?id=<?php echo $productID; ?>"
                             alt="<?php echo $description; ?>">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $name; ?></h4>
                            <h5><?php echo '$' . $price; ?></h5>
                            <p class="card-text"><?php echo $description; ?></p>
                        </div>
                        <div class="list-group list-group-flush">
                            <li class="list-group-item font-weight-bold">Features:</li>
                            <?php
                            $sql = "SELECT * FROM Features WHERE ProductID = " . $productID;
                            $result = $con->query($sql);

                            if($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo '<li class="list-group-item">' . $row['Feature'] . '</li>';
                                }
                            }
                            ?>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">★ ★ ★ ★ ☆</small>
                        </div>
                        <label id="errorMsg" class="text-danger text-center list-group-item">
                            <?php
                            if(isset($_POST['btnAddToCart'])) {
                                if(!empty($_POST['txtQty'])) {
                                    $cart->AddItem($_GET['id'], $_POST['txtQty']);
                                    $_SESSION['cart'] = serialize($cart);

                                    require ('./models/redirect.php');
                                    redirect('./cart.php');
                                } else {
                                    echo '(Hint: Quantity cannot be more than in inventory.)';
                                }
                            } else {
                                echo "<script>$('#errorMsg').hide();</script>";
                            }
                            ?>
                        </label>
                        <div class="form-group">
                            <?php
                            $min = 1;
                            $max = $maxQty;
                            if($cart->HasProduct($productID)) {
                                $min = ($maxQty <= $cart->getCartItemByID($productID)->getQty()) ? 0 : 1;
                                $max = $maxQty - $cart->getCartItemByID($productID)->getQty();
                            }
                            ?>
                            <input type="number" name="txtQty" min="<?php echo $min ?>" max="<?php echo $max; ?>" placeholder="Quantity" class="form-control" required="required" />
                        </div>
                        <input type="submit" name="btnAddToCart" class="btn btn-primary" value="Add to Cart" />
                    </div>
                </div>
                <?php
            } else {
                echo 'Database Connection problem.';
            }
            ?>
        </div>

    </form>
<?php
} else {
    header('Location: ./shop.php');
}
include ('./master-footer.html');
?>
