<?php
$page_title = 'Cart';
include('./master-header.php');

$orderID = 0;

if(empty($_SESSION['orderID'])) {
    header('Location: index.php');
} else {
    $orderID = $_SESSION['orderID'];
}

if($con) {
    $sql = "SELECT Products.ProductID AS ProductID, Quantity, Name, Price 
            FROM OrderItems INNER JOIN Products 
            ON OrderItems.ProductID = Products.ProductID
            WHERE OrderID = " . $orderID . " ";

    $result = $con->query($sql);
    ?>

    <div class="text-primary mb-3">
        <h2>Order Successful</h2>
        <span class="h4 text-primary">Order Details</span>
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
        if ($result->num_rows > 0) {
            $total = 0;
            while ($row = $result->fetch_assoc()) {
                ?>

                <tr>
                    <td data-th="Product">
                        <div class="row text-center">
                            <div class="col-12">
                                <img src="./models/getImage.php?id=<?php echo $row['ProductID']; ?>"
                                     alt="<?php echo $row['Name']; ?>" class="img-responsive cart-img"/>
                            </div>
                            <div class="col-12">
                                <h4 class="mt-2"><?php echo $row['Name']; ?></h4>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price"><?php echo '$' . $row['Price']; ?></td>
                    <td data-th="Quantity">
                        <p class="form-control-plaintext text-center"><?php echo $row['Quantity']; ?></p>
                    </td>
                    <td data-th="Subtotal" class="text-center"><?php echo '$' . $row['Quantity'] * $row['Price']; ?></td>
                    <?php $total += ($row['Quantity'] * $row['Price']); ?>
                </tr>

                <?php
            }
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
        </tr>
        </tfoot>

    </table>


    <?php
}
include ('./master-footer.html');
?>