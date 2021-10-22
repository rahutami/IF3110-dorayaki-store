<?php
    require_once('./db/DBConnection.php');
    $db = (new DBConnection())->connect();

    $uname = "";
    
    if(isset($_GET["query"])){
        $searchQuery = $_GET["query"];
    } else {
        $searchQuery = '';
    }
    $stmt = $db->prepare("select * from (select d.id as id, d.name as name, d.price as price, d.img_path as img_path, sum(rp.amount_changed) as total_sold from dorayaki as d left join riwayat_dorayaki as rp on d.id = rp.id_dorayaki group by d.id, d.name, d.price order by total_sold desc) where name like '%$searchQuery%'");
    $stmt->execute();
    $result = $stmt->fetchall();

    $error = '';
function makeTextIntoPriceText($str)
{
    $j=0;
    $new_string = "";
    for ($i = strlen($str)-1; $i >= 0; $i--) {
        if ($j % 3 === 0 && $j != 0) {
            $new_string = "." . $new_string;
        }
        $new_string = $str[$i] . $new_string;
        $j++;
    };
    $new_string = $new_string . ",00";

    return $new_string;
};
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booksy</title>
    <link href="../styles/style-tami.css" rel="stylesheet" />
    <link href="../styles/styles.css" rel="stylesheet" />
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
    <div class="container">
        <div class="dashboard-container">
        <?php
        foreach ($result as $dorayaki) {
            echo("
            <div class='item'>
            <a href='detail.php?id={$dorayaki["id"]}'>
                <img src='{$dorayaki["img_path"]}'>
                <h2>{$dorayaki["name"]}</h2>
                <h3>Rp".makeTextIntoPriceText($dorayaki["price"])."</h3>
            </a>
            </div>");
        }
        ?>

        </div>
    </div>
</body>
        
    <script>
    </script>
</html>
