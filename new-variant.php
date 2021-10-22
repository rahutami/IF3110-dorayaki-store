<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();
require_once('check-login-state.php');

if ($COOKIE["admin"] != 1) {
    // TODO: selain admin ga bisa add variant, redirect
}

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

<?php require_once('_header.php')?>

<body>
    <!-- navbar -->
    
    <?php require_once('_navbar.php')?>
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
</script>
</html>