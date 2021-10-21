
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booksy</title>
    <link href="../styles/styles.css" rel="stylesheet" />
    <link href="../styles/style-tami.css" rel="stylesheet" />
</head>

<body>
    <!-- navbar -->
    <nav>
        <a class="logo">Booksy </a>
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
        <form action="add-variant.php" method="POST">
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