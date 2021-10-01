<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="add-variant.php" method="POST">
        <label for="name">Nama Variant: </label>
        <input type="text" name="name" id="name">
        <label for="price">Harga: </label>
        <input type="text" name="price" id="price">
        <label for="amount">Jumlah: </label>
        <input type="text" name="amount" id="amount">
        <label for="deskripsi">Deskripsi: </label>
        <textarea id="w3review" name="description" rows="4" cols="50"></textarea>
        <label for="img_path">Gambar: </label>
        <input type="text" name="img_path" id="img_path">
        <button>Submit</button>
    </form>
    <div>
        <?php if ($_GET["success"] == "true") {?>
        <h3>Varian baru telah berhasil diunggah</h3>
        <?php } else if ($_GET["success"] == "false"){ ?>
        <h3>Data tidak lengkap</h3>
        <?php } ?>

    </div>
</body>
</html>