<?php
    require_once('./db/DBConnection.php');
    $db = (new DBConnection())->connect();

    $uname = "";
    
    $stmt = $db->prepare("select d.id as id, d.name as name, d.price as price, d.img_path as img_path, sum(rp.amount_changed) as total_sold from dorayaki as d left join riwayat_dorayaki as rp on d.id = rp.id_dorayaki group by d.id, d.name, d.price order by total_sold desc limit 10");
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
<?php require_once('_header.php')?>

<body>
    <!-- navbar -->
    
    <?php require_once('_navbar.php')?>
    
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
