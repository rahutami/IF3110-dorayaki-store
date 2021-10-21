<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();
require_once('check-login-state.php');

// get details of dorayaki
try {
    // if admin
    // $stmt = $db->prepare("SELECT * FROM dorayaki as d inner join riwayat_perubahan as rp on rp.id_dorayaki = d.id");
    // $stmt->execute();
    // $result = $stmt->fetchall();
    // if user
    // TODO: buy time
    $stmt = $db->prepare("SELECT d.name, rp.amount, (rp.amount*d.price) as total_price FROM dorayaki as d inner join riwayat_pembelian as rp on rp.id_dorayaki = d.id");
    $stmt->execute();
    $result = $stmt->fetchall();
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
        <h1>Riwayat Pembelian</h1>
        <table>
            <thead>
                <tr>
                    <th>Variant Name</th>
                    <th>Amount</th>
                    <th>Total Price</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($result as $row) {
                    echo ("<tr>
                    <td>{$row["name"]}</td>
                    <td>{$row["amount"]}</td>
                    <td>{$row["total_price"]}</td>
                    <td>{$row["change_time"]}</td>
                    </tr>");
                }
                ?>
            </tbody>
        </table>
        <!-- <h1>History</h1>
        <table>
            <thead>
                <tr>
                    <th>Variant Name</th>
                    <th>Added Amount</th>
                    <th>New Amount</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($result as $row) {
                    echo ("<tr>
                    <td>{$row["name"]}</td>
                    <td>{$row["amount_changed"]}</td>
                    <td>{$row["new_amount"]}</td>
                    <td>{$row["change_time"]}</td>
                    </tr>");
                }
                ?>
            </tbody>
        </table> -->
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