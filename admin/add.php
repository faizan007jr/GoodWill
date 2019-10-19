<?php
include('./master-header.php');
require ('../models/redirect.php');
$seller = $_SESSION["seller"];

if($con) {
    $sql = "SELECT SellerID FROM Sellers WHERE Email=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $seller);
    $stmt->execute();
    $stmt->bind_result($sellerID);
    $stmt->fetch();
    $stmt->close();
}
?>

<form method="post" enctype="multipart/form-data" class="form-group container-fluid border rounded m-2 p-4">
    <h3 class="text-primary">Product Details:</h3>
    <div class="form-group pt-3">

        <div class="form-group row">
            <label class="col-form-label col-sm-3 offset-sm-1">Category</label>
            <select class="form-control col-sm-5 col-md-3" name="category" required>
                <?php
                if($con) {
                    $sql = "SELECT * FROM Categories";
                    $result = $con->query($sql);

                    if($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['CategoryID'] . "'>" . $row['CategoryName'] . "</option>";
                        }
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-3 offset-sm-1">Name</label>
            <input type="text" name="txtName" class="form-control col-sm-5 col-md-3" placeholder="Name" value="<?php if(isset($_POST['btnAdd'])){ echo $_POST['txtName']; }; ?>" required>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-3 offset-sm-1">Price</label>
            <input type="number" min="1" name="price" class="form-control col-sm-5 col-md-3" placeholder="$0" value="<?php if(isset($_POST['btnAdd'])){ echo $_POST['price']; }; ?>" required>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-3 offset-sm-1">Description</label>
            <textarea name="txtDesc" class="form-control col-sm-5 col-md-3" rows="3" placeholder="Description" required><?php if(isset($_POST['btnAdd'])){ echo $_POST['txtDesc']; }; ?></textarea>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-3 offset-sm-1">Image</label>
            <div class="custom-file col-sm-5 col-md-3">
                <input type="file" class="custom-file-input" id="imageFile" name="image" required>
                <label class="custom-file-label" for="imageFile">Choose file</label>
            </div>
            <script>
                $('#imageFile').on('change', function(e){
                    var fileName = e.target.files[0].name;
                    $(this).next('.custom-file-label').html(fileName);
                });
            </script>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-3 offset-sm-1">Quantity</label>
            <input type="number" min="1" name="quantity" class="form-control col-sm-5 col-md-3" placeholder="0" value="<?php if(isset($_POST['btnAdd'])){ echo $_POST['quantity']; }; ?>" required>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-3 offset-sm-1">Features</label>
            <input type="text" name="features[]" class="form-control col-sm-5 col-md-3" placeholder="feature" required>
        </div>

        <div id="moreFeatures">

        </div>

        <div class="form-group row">
            <button onclick="addFeature()" class="btn btn-danger col-sm-5 col-md-3 offset-sm-4">More Feature</button>
            <script>
                function addFeature() {
                    var input = '<div class="form-group row">\n' +
                        '            <input type="text" name="features[]" class="form-control offset-sm-4 col-sm-5 col-md-3" placeholder="feature" required>\n' +
                        '        </div>';
                    $('#moreFeatures').append(input);
                }
            </script>
        </div>

        <div class="form-group row">
            <label class="col-sm-5 col-md-3 offset-sm-4 text-danger">
                <?php
                if(isset($_POST['btnAdd'])) {
                    $categoryID = $_POST['category'];
                    $name = $_POST['txtName'];
                    $price = $_POST['price'];
                    $description = $_POST['txtDesc'];
                    $image_name = $_FILES['image']['name'];
                    $qty = $_POST['quantity'];
                    $features = $_POST['features'];

                    if(!empty($categoryID) && !empty($name)
                        && !empty($price) && !empty($description)
                        && !empty($image_name) && !empty($qty)
                        && !empty($features)) {
                        if($con) {
                            if ($_FILES['image']['type'] == "image/jpeg" || $_FILES['image']['type'] == "image/jpg" || $_FILES['image']['type'] == "image/png")
                            {
                                if ($content = file_get_contents($_FILES['image']['tmp_name']))
                                {
                                    $image = addslashes($content);
                                    $sql = "CALL InsertProduct(?, ?, ?, ?, ?, ?, ?)";

                                    $stmt = $con->prepare($sql);
                                    $stmt->bind_param("iisdsbi", $sellerID, $categoryID, $name, $price, $description, $image, $qty);
                                    $stmt->execute();
                                    $stmt->bind_result($isInserted);
                                    $stmt->fetch();

                                    if($isInserted) {
                                        redirect('./index.php');
                                    } else {
                                        echo "Error Adding Product! " . $isInserted;
                                    }
                                    $stmt->close();
                                }
                            } else {
                                echo 'Image must of jpeg/png/jpg type only.';
                            }
                        }
                    } else {
                        echo "All Fields are Required";
                    }
                }
                ?>
            </label>
        </div>

        <div class="form-group row">
            <button type="submit" class="btn btn-primary col-sm-5 col-md-3 offset-sm-4" name="btnAdd">Add</button>
        </div>

    </div>
</form>

<?php
include('./master-footer.html');
?>
