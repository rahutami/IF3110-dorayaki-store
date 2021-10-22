<?php
if (isset($_COOKIE["admin"]) &&$_COOKIE["admin"] == 1) {
    $isAdmin = true;
}
else {
    $isAdmin = false;
}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="topnav" id="topnav">
        <a class="logo">Stand with Dorayaki <?php echo ($_COOKIE["admin"] == 1) ?  "- Admin": "" ?></a>
        <a href="dashboard.php">Home</a>
        <a href="history.php">History</a>
        <?php if($isAdmin) { ?>
        <a href="new-variant.php">Add Variant</a>
        <?php }?>
        <a href="logout.php">Logout</a>
        <div class="search-container">
            <form class="form-inline" action="search-result.php">
                <input type="text" name="query" id="query">
                <button type="submit">Search</button>
            </form>
        </div>
        <a href="javascript:void(0);" class="icon" onclick="responsiveNavbar();">
            <i class="fa fa-bars"></i>
        </a>
    </div>  
<script>
    function responsiveNavbar() {
        let nav = document.getElementById("topnav");
        if (nav.className === "topnav") {
            nav.className += " responsive";
        } else {
            nav.className = "topnav";
        }
}
</script>
