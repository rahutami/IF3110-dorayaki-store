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
    $amountSold = ''; // TODO bikin query-nya
    $price = $row["price"];
    $amountRemaining = $row["amount"];
    $description = $row["description"];
    $imagePath = $row["img_path"];
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// buy dorayaki

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booksy</title>
    <link href="../styles/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- navbar -->
    <nav>
        <a class="logo">Booksy </a>
        <!-- <a class="logo">Hi, <php echo $current_user; ?>!</a> -->
        <a href="index.php">Home</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
        <!-- <a href="../cart.php">Cart (?php echo $totalItems; ?>)</a> -->
        <!-- <a href="../logout.php">Logout</a> -->

    </nav>
    <!-- product -->
    <div class="container">
        <h1 class="headline">Product Details <?php echo $_GET["id"]; ?></h1>
        <div class="row">
            <div class="column center">
                <!-- foto produk -->
                <img class="product-photo" src="<?php echo $imagePath;?>">
            </div>
            <div class="column">
                <h1 class="product-name"><?php echo $name; ?></h1>
                <h3 class="product-description">Amount sold: <?php echo $amountSold; ?> TODO</h3> 
                <h3 class="product-description">Price: Rp<span id="price"><?php echo $price; ?></span></h3>
                <h3 class="product-description">Amount remaining: <?php echo $amountRemaining; ?></h3>

                <br>
                <h4>Description:</h4>
                <p><?php echo $description; ?></p>

                <form method="post" class="cartForm" action="change-amount.php">
                    <label for="amount">New amount:</label>
                    <input type="number" id="amount" name="amount" min="0" required>
                    <input type="text" value=<?php echo $_GET["id"]?> id="id" name="id" class="hide">
                    <input type="text" value="perubahan" id="method" name="method" class="hide">
                    <button type="submit" name="submit" class="btn-jumbotron" 
                style="font-weight: 600;text-transform: uppercase;">Update</button>
                </form>

                <form method="post" class="cartForm" action="delete-variant.php">
                    <input type="text" value=<?php echo $_GET["id"]?> id="id" name="id" class="hide">
                    <button type="submit" name="submit" class="btn-jumbotron" 
                style="font-weight: 600;text-transform: uppercase;">Hapus Varian</button>
                </form>
            </div>
        </div>
    </div>
    <!-- footer -->
    <footer>Footer</footer>
</body>
<script>
    document.getElementById("quantity").addEventListener("change", getTotalPrice);
    function getTotalPrice() {
        let price = document.getElementById("price").textContent;
        let quantity = this.value;
        let totalPrice = price*quantity;
        document.getElementById("totalPrice").innerHTML = totalPrice.toString();
    }
</script>
</html>