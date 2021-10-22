<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();
// require_once('check-login-state.php');
if ($_COOKIE["admin"] == 1) {
    $isAdmin = true;
}
else {
    $isAdmin = false;
}
// get details of dorayaki
try {
    $id = $_GET['id'];
    $stmt = $db->prepare("SELECT * FROM dorayaki WHERE id = $id");
    $stmt->execute();
    $row = $stmt->fetch();

    if($row != 0){
        $found = TRUE;
        $name = $row["name"];
        $amountSoldStatement = $db->prepare("select sum(rp.amount_changed) as total_sold, d.id as id from dorayaki as d left join riwayat_dorayaki as rp on d.id = rp.id_dorayaki where method = 'pembelian' and d.id = $id group by d.id");
        $amountSoldStatement->execute();
        $amountSoldRow = $amountSoldStatement->fetch();
        if($amountSoldRow == 0){
            $amountSold = 0;
        } else {
            $amountSold = $amountSoldRow["total_sold"];
        }
        $price = $row["price"];
        $amountRemaining = $row["amount"];
        $description = $row["description"];
        $imagePath = $row["img_path"];
    } else {
        $found = FALSE;
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<?php require_once('_header.php')?>

<body>
    <!-- navbar -->
    
    <?php require_once('_navbar.php')?>
    
    <!-- product -->
    <div class="container">
    <?php if($found) {?>
        <h1 class="headline">Product Details <span id="product-id"><?php echo $_GET["id"]; ?></span></h1>
        <div class="row">
            <div class="column center">
                <!-- foto produk -->
                <img class="product-photo" src="<?php echo $imagePath;?>">
            </div>
            <div class="column">
                <h1 class="product-name"><?php echo $name; ?></h1>
                <h3 class="product-description">Amount sold: <?php echo (-1) * (int)$amountSold; ?></h3> 
                <h3 class="product-description">Price: Rp<span id="price"><?php echo $price; ?></span></h3>
                <h3 class="product-description">Amount remaining: <span id="dorayaki-stock"></span></h3>
                <br>
                <h4>Description:</h4>
                <p><?php echo $description; ?></p>

                <?php if ($isAdmin) { ?>
                <!-- if admin -->
                 <form method="post" class="cartForm" action="delete-variant.php">
                    <input type="text" value=<?php echo $_GET["id"]?> id="id" name="id" class="hide">
                    <button type="submit" name="submit" class="btn-jumbotron" 
                style="font-weight: 600;text-transform: uppercase;">Hapus Varian</button>
                </form>
                <form method="post" class="cartForm" action="change-amount.php">
                    <label for="amount">New amount:</label>
                    <input type="number" id="amount" name="amount" min="0" required>
                    <input type="text" value=<?php echo $_GET["id"]?> id="id" name="id" class="hide">
                    <input type="text" value="perubahan" id="method" name="method" class="hide">
                    <button type="submit" name="submit" class="btn-jumbotron" 
                        style="font-weight: 600;text-transform: uppercase;">Update</button>
                </form>

                <?php 
                }
                else { ?>
                <!-- if user -->
                <form action="change-amount.php" method="post" class="cartForm">
                    <input type="hidden" id="method" name="method" value="pembelian">
                    <input type="hidden" id="id" name="id" value="<?php echo $_GET["id"]; ?>">
                    <label for="amount">Amount to buy:</label>
                    <input type="number" id="amount" name="amount" min="0" max="<?php echo $amountRemaining?>" required>
                    <p>Total price: <span id="totalPrice"></span></p>
                    <button type="submit" name="submit" class="btn-jumbotron" style="font-weight: 600; text-transform: uppercase;" onclick="updateStock();">Buy</button>
                </form>
                
                <?php } ?>
            </div>
        </div>
    <?php } else {?>
        <h1 style="text-align:center;">404 Not Found</h1>
    <?php }?>
    </div>
    <!-- footer -->
    <footer>Footer</footer>
</body>
<script>
    // get total price
    document.getElementById("amount").addEventListener("change", getTotalPrice);
    function getTotalPrice() {
        let price = document.getElementById("price").textContent;
        let amount = this.value;
        let totalPrice = price*amount;
        document.getElementById("totalPrice").innerHTML = totalPrice.toString();
    }
    // real time stock
    function getDorayakiStock() {
        let id = document.getElementById("product-id").textContent;
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onload = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("dorayaki-stock").innerHTML = this.responseText;
                let amountInput = document.getElementById("amount");
                amountInput.setAttribute("max",(this.responseText));
            }
        }
        xmlhttp.open("GET", "dorayaki-stock.php?id=" + id, true);
        xmlhttp.send();
    }
    getDorayakiStock();
    setInterval(getDorayakiStock,1000); // akan get setiap 1 detik
</script>
</html>