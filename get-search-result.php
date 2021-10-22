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
    
    echo(json_encode($result));
?>

