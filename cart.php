<?php
$page_title = 'Cart';
include('./master-header.php');
if(isset($_POST['btnRemove'])) {
    $cart->RemoveByID($_POST['btnRemove']);
    $_SESSION['cart'] = serialize($cart);
    header('Location: ./cart.php');
}

if(isset($_POST['btnSync'])) {
    $cart->UpdateQuantity($_POST['txtQty']);
    $_SESSION['cart'] = serialize($cart);
    header('Location: ./cart.php');
}

if(isset($_POST['btnCheckout'])) {
    $_SESSION['total'] = $_POST['btnCheckout'];
    header('Location: ./checkout.php');
}
?>

<form method="post">
    <div class="text-primary mb-3">
        <span class="h2">Cart</span>
        <span><i class="fa fa-shopping-cart"></i></span>
    </div>
    <table id="cart" class="table table-hover table-condensed">
        <thead>
            <tr>
                <th style="width:50%">Product</th>
                <th style="width:10%">Price</th>
                <th style="width:8%">Quantity</th>
                <th style="width:22%" class="text-center">Subtotal</th>
                <th style="width:10%"></th>
            </tr>
        </thead>
        <tbody>
        <?php
        $total = 0;
        foreach ($cart->getCart() as $cartItem) {
            $sql = "SELECT `Name`, Price, Description, Quantity FROM Products INNER JOIN Inventories ON Products.ProductID = Inventories.ProductID WHERE Products.ProductID=?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $productID);

            $productID = $cartItem->getProduct()->getID();
            $qty = $cartItem->getProduct()->getQty();

            $stmt->execute();

            $stmt->bind_result($name, $price, $description, $maxQty);
            $stmt->fetch();
            $stmt->close();
            ?>
            <tr>
                <td data-th="Product">
                    <div class="row text-center">
                        <div class="col-12">
                            <img src="./models/getImage.php?id=<?php echo $productID; ?>"
                                 alt="<?php echo $description; ?>" class="img-responsive cart-img" />
                        </div>
                        <div class="col-12">
                            <h4 class="mt-2"><?php echo $name; ?></h4>
                            <p><?php echo $description; ?></p>
                        </div>
                    </div>
                </td>
                <td data-th="Price"><?php echo '$' . $price; ?></td>
                <td data-th="Quantity">
                    <input type="number" name="txtQty[]" min="1" max="<?php echo $maxQty; ?>" class="form-control text-center" value="<?php echo $qty; ?>">
                </td>
                <td data-th="Subtotal" class="text-center"><?php echo '$' . $qty * $price; ?></td>
                <td class="actions" data-th="">
                    <div>
                        <button type="submit" name="btnSync" class="btn btn-info btn-sm" value="<?php echo $productID; ?>"><i class="fas fa-sync-alt"></i></button>
                        <button type="submit" name="btnRemove" class="btn btn-danger btn-sm" value="<?php echo $productID; ?>"><i class="fas fa-trash"></i></button>
                    </div>
                </td>
            </tr>
            <?php
            $total += $qty * $price;
        }
        ?>
        </tbody>
        <tfoot>
            <tr class="visible-xs">
                <td class="text-center"><strong><?php echo '$' . $total; ?></strong></td>
            </tr>
            <tr>
                <td><a href="shop.php" class="btn btn-warning"><i class="fas fa-angle-left"></i> Continue Shopping</a></td>
                <td colspan="2" class="hidden-xs"></td>
                <td class="hidden-xs text-center"><strong>Total <?php echo '$' . $total; ?></strong></td>
                <td><button type="submit" name="btnCheckout" class="btn btn-danger btn-sm" value="<?php echo $total; ?>">Checkout <i class="fa fa-angle-right"></i></button></td>
            </tr>
        </tfoot>
    </table>
</form>

<?php
include ('./master-footer.html');
?>
