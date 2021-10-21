<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();

// get details of dorayaki
try {
    $id = $_GET['id'];
    $stmt = $db->prepare("SELECT * FROM dorayaki WHERE id = $id");
    $stmt->execute();
    $row = $stmt->fetch();
    $name = $row["name"];
    $amountSoldStatement = $db->prepare("SELECT SUM(AMOUNT) as amount_sold FROM riwayat_pembelian GROUP BY id_dorayaki HAVING id_dorayaki = $id");
    $amountSoldStatement->execute();
    $amountSoldRow = $amountSoldStatement->fetch();
    $amountSold = $amountSoldRow["amount_sold"];
    $price = $row["price"];
    $amountRemaining = $row["amount"];
    $description = $row["description"];
    $imagePath = $row["img_path"];
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// select sum(amount) from riwayat_pembelian group by id_dorayaki having id_dorayaki = id;

// buy dorayaki
try{
    // ! method: perubahan or pembelian
    // ! perubahan = perubahan by admin
    // ! pembelian = pembelian by pelanggan

    // * ASUMSI:
    // * - kalo pembelian itu gamasuk ke riwayat perubahan tapi cuma ke riwayat pembelian, vice versa
    // * - pas perubahan by admin inputnya new amount
    // * - pas pembelian inputnya amount yg dibeli
    
    if ($_POST["id"] && $_POST["amount"] && $_POST["method"]) {
        $dorayaki = $db->query("SELECT * FROM dorayaki where id = " . $_POST["id"])->fetch();
        $stmt_dorayaki = $db->prepare("UPDATE dorayaki SET amount = ? WHERE id = ?");
        // TODO: ganti id_user
        if($_POST["method"] == "pembelian"){
            $new_amount = (int) $dorayaki["amount"] - (int) $_POST["amount"];
            $stmt_riwayat = $db->prepare("INSERT INTO riwayat_pembelian (id_dorayaki, id_user, amount) VALUES (?,?,?);");
            $stmt_riwayat->execute(array($_POST["id"], 1, $_POST["amount"]));
        } else if ($_POST["method"] == "perubahan"){
            $new_amount = (int) $_POST["amount"];
            $amount_changed = (int) $_POST["amount"] - (int) $dorayaki["amount"];
            $stmt_riwayat = $db->prepare("INSERT INTO riwayat_perubahan (id_dorayaki, id_user, amount_changed, new_amount) VALUES (?,?,?,?);");
            $stmt_riwayat->execute(array($_POST["id"], 1, $amount_changed, $new_amount));
        } else {
            throw new Exception("method not available", 1);            
        }
        
        // *user id nanti didapet from session?
        $stmt_dorayaki->execute(array($new_amount, $_POST["id"]));
        // echo $stmt->rowCount();
        // TODO: harusnya diredirect
    } else {
        // TODO: harusnya diredirect
        echo "please include id, amount, and method";
    }

} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stand with Dorayaki</title>
    <link href="../styles/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- navbar -->
    <nav>
        <a class="logo">Stand with Dorayaki</a>
        <!-- <a class="logo">Hi, <?php echo $current_user; ?>!</a> -->
        <a href="index.php">Home</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
        <!-- <a href="../cart.php">Cart (<?php echo $totalItems; ?>)</a> -->
        <!-- <a href="../logout.php">Logout</a> -->

    </nav>
    <!-- product -->
    <div class="container">
        <h1 class="headline">Product Details <span id="product-id"><?php echo $_GET["id"]; ?></span></h1>
        <div class="row">
            <div class="column center">
                <!-- foto produk -->
                <img class="product-photo" src="<?php echo $imagePath;?>">
            </div>
            <div class="column">
                <h1 class="product-name"><?php echo $name; ?></h1>
                <h3 class="product-description">Amount sold: <?php echo $amountSold; ?></h3> 
                <h3 class="product-description">Price: Rp<span id="price"><?php echo $price; ?></span></h3>
                <h3 class="product-description">Amount remaining: <span id="dorayaki-stock"></span></h3>
                <br>
                <h4>Description:</h4>
                <p><?php echo $description; ?></p>
                <form action="" method="post" class="cartForm">
                    <input type="hidden" id="method" name="method" value="pembelian">
                    <input type="hidden" id="id" name="id" value="<?php echo $_GET["id"]; ?>">
                    <label for="amount">Amount to buy:</label>
                    <input type="number" id="amount" name="amount" min="1" max="<?php echo $amountRemaining?>" required>
                    <p>Total price: <span id="totalPrice"></span></p>
                    <button type="submit" name="submit" class="btn-jumbotron" style="font-weight: 600; text-transform: uppercase;" onclick="updateStock();">Buy</button>
                </form>

            </div>
        </div>
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