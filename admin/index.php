<?php
include('./master-header.php');

if(isset($_POST['btnRemove'])) {

    $sql = "CALL DeleteProduct(?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $productID);
    $productID = $_POST['btnRemove'];
    $stmt->execute();

    header('Location: ./index.php');
}
?>

<form method="post" class="card">
    <h3 class="card-header text-center font-weight-bold text-uppercase py-4">Your Products</h3>
    <div class="card-body">
        <div id="table" class="table-editable">
            <span class="table-add float-right mb-3 mr-2"><a href="./add.php" class="text-success"><i class="fas fa-plus fa-2x" aria-hidden="true"></i></a></span>
            <table class="table table-bordered table-responsive-md table-striped text-center">
                <thead>
                    <tr>
                        <th class="text-center">Name</th>
                        <th class="text-center">Price($)</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Quantity</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if($con) {
                    $sql = "SELECT Products.ProductID, `Name`, Price, Description, Quantity FROM Products 
                        INNER JOIN Inventories ON Products.ProductID = Inventories.ProductID 
                        WHERE Products.SellerID=(SELECT SellerID FROM Sellers WHERE Email='" . $_SESSION['seller'] . "')";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td class="pt-3-half" contenteditable="true"><?php echo $row['Name']; ?></td>
                                <td class="pt-3-half" contenteditable="true"><?php echo $row['Price']; ?></td>
                                <td class="pt-3-half" contenteditable="true"><?php echo $row['Description']; ?></td>
                                <td class="pt-3-half" contenteditable="true"><?php echo $row['Quantity']; ?></td>
                                <td class="pt-3-half"><button type="submit" name="btnRemove" class="btn btn-danger btn-sm" value="<?php echo $row['ProductID']; ?>"><i class="fas fa-trash"></i></button></td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</form>

<?php
include('./master-footer.html');
?>