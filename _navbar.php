<?php
if (isset($_COOKIE["admin"]) &&$_COOKIE["admin"] == 1) {
    $isAdmin = true;
}
else {
    $isAdmin = false;
}

?>

<div class="navbar" id="topnav">
    <a class="active">Stand with Dorayaki <?php echo ($_COOKIE["admin"] == 1) ?  "- Admin": "" ?></a>
    <a href="dashboard.php">Home</a>
    <a href="history.php">History</a>
    <?php if($isAdmin) { ?>
    <a href="new-variant.php">Add Variant</a>
    <?php }?>
    <form action="search-result.php">
        <input type="text" name="query" id="query">
        <button type="submit" class="search-btn">Search</button>
    </form>
    <a href="logout.php">Logout</a>
    <a href="javascript:void(0);" class="icon" onclick="responsiveNavbar();">
        <i class="fa fa-bars"></i>
    </a>
</div>  

<script>
    function responsiveNavbar() {
        let nav = document.getElementById("topnav");
        if (nav.className === "navbar") {
            nav.className += " responsive";
        } else {
            nav.className = "navbar";
        }
}
</script>
