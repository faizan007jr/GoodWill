<?php
$page_title = 'Shop';
$cart_items = 0;
include('./master-header.php');
?>

<div>

    <div class="row">

        <div class="col-lg-3">

            <h1 class="my-4 text-primary">Goodwill Electronics</h1>
            <div class="list-group">

                <a href="./shop.php" class="list-group-item">All</a>
                <?php
                if($con) {
                    $sql = "SELECT * FROM Categories";
                    $result = $con->query($sql);

                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {

                ?>
                    <a href="<?php echo './shop.php?id=' . $row['CategoryID'] ?>" class="list-group-item"><?php echo $row['CategoryName']; ?></a>
                <?php
                        }
                    }
                }
                ?>

            </div>

        </div>

        <div class="col-lg-9 mt-4">

            <div class="row">

                <?php
                if($con) {
                    $sql = "SELECT * FROM Products WHERE ProductID IN (SELECT ProductID FROM Inventories WHERE Quantity > 0)";
                    if(isset($_GET['id'])) {
                        $sql .= " AND CategoryID=" . $_GET['id'];
                    }
                    $result = $con->query($sql);
                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                ?>
                <div class="col-lg-4 col-md-6 mb-4 product">
                    <div class="card h-100 shadow">
                        <a href="./description.php?id=<?php echo $row['ProductID']; ?>">
                            <img class="card-img-top" src="./models/getImage.php?id=<?php echo $row['ProductID']?>" alt="<?php echo $row['Description']; ?>">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h4 class="card-title mt-auto">
                                <a href="./description.php?id=<?php echo $row['ProductID']; ?>"><?php echo $row['Name']; ?></a>
                            </h4>
                            <h5><?php echo '$' . $row['Price']; ?></h5>
                            <p class="card-text"><?php echo $row['Description']; ?></p>
                        </div>
                       <div class="card-footer">
                            <small class="text-muted">★ ★ ★ ★ ☆</small>
                        </div>
                    </div>
                </div>
                <?php
                        }
                    }
                }
                ?>

            </div>
        </div>
    </div>
</div>

<?php
include ('./master-footer.html');
?>
