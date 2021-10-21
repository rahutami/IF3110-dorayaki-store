<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();

if(isset($_POST["name"]) && isset($_POST["amount"]) && isset($_POST["price"]) && isset($_POST["description"]) && isset($_POST["img_path"])){
    try{
            // TODO: uncomment once frontend is ok
        if ($_POST["name"] && $_POST["amount"] && $_POST["price"] && $_POST["description"] && $_POST["img_path"]) {
            $stmt = $db->prepare("INSERT INTO dorayaki (name, amount, price, description, img_path) VALUES (?,?,?,?,?)");

            // TODO: to be replaced by $_POST
            $stmt->execute(array($_POST["name"], $_POST["amount"], $_POST["price"], $_POST["description"], $_POST["img_path"]));
            header('Location: add-variant-page.php?success=true');
        } else {
            header('Location: add-variant-page.php?success=false');
        }


    } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    }
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
    <link href="../styles/style-tami.css" rel="stylesheet" />
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
        <h1>Add New Variant</h1>
        <form action="" method="POST">
            <div class="input-set">
                <label for="name">Nama Variant</label>
                <input type="text" name="name" id="name">
            </div>
            <div class="input-set">
                <label for="price">Harga</label>
                <input type="text" name="price" id="price">
            </div>
            <div class="input-set">
                <label for="amount">Jumlah</label>
                <input type="text" name="amount" id="amount">
            </div>
            <div class="input-set">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="w3review" name="description" rows="4" cols="50"></textarea>
            </div>
            <div class="input-set">
                <label for="img_path">Gambar</label>
                <input type="text" name="img_path" id="img_path">
            </div>
            <button class="btn-jumbotron">Submit</button>

        </form>
    <div>
        <?php if (!isset($_GET["success"])) { 

        } else if ($_GET["success"] == "true") {?>
        <h3>Varian baru telah berhasil diunggah</h3>
        <?php } else if ($_GET["success"] == "false"){ ?>
        <h3>Data tidak lengkap</h3>
        <?php } ?>

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