<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();
require_once('check-login-state.php');

// get details of dorayaki
try {
    // if admin
    $stmt = $db->prepare("SELECT d.name as name, rp.amount_changed as amount, u.name as username, rp.change_time as time, rp.method as method FROM dorayaki as d inner join riwayat_dorayaki as rp on rp.id_dorayaki = d.id inner join user as u on u.id = rp.id_user;");
    $stmt->execute();
    $admin_hist = $stmt->fetchall();
    // if user
    $stmt = $db->prepare("SELECT d.name as name, rp.amount_changed as amount, rp.total_price as total_price, rp.change_time as time FROM dorayaki as d inner join riwayat_dorayaki as rp on rp.id_dorayaki = d.id where method='pembelian'"); //where u.id = loggedin.id
    $stmt->execute();
    $buyer_hist = $stmt->fetchall();
    
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// buy dorayaki

?>
<!DOCTYPE html>
<html lang="en">

<?php require_once('_header.php')?>

<body>
    <!-- navbar -->
    
    <?php require_once('_navbar.php')?>
    
    <div class="container">
        <h1>History</h1>
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
                foreach ($buyer_hist as $row) {
                    echo ("<tr>
                    <td>{$row["name"]}</td>
                    <td>".(-1) * (int)$row["amount"]."</td>
                    <td>{$row["total_price"]}</td>
                    <td>{$row["time"]}</td>
                    </tr>");
                }
                ?>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th>Variant Name</th>
                    <th>Added Amount</th>
                    <th>Changed By</th>
                    <th>Time</th>
                    <th>Method</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($admin_hist as $row) {
                    echo ("<tr>
                    <td>{$row["name"]}</td>
                    <td>{$row["amount"]}</td>
                    <td>{$row["username"]}</td>
                    <td>{$row["time"]}</td>
                    <td>{$row["method"]}</td>
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