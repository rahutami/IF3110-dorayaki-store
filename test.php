<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="change-amount.php" method="POST">
        <label for="name">ID </label>
        <input type="text" name="id" id="id">
        <label for="price">Method: </label>
        <input type="text" name="method" id="method">
        <label for="amount">Jumlah: </label>
        <input type="text" name="amount" id="amount">
        <button>Submit</button>
    </form>
    <form action="delete-variant.php" method="POST">
        <label for="name">ID </label>
        <input type="text" name="id" id="id">
        <button>Submit</button>
    </form>
</body>
</html>