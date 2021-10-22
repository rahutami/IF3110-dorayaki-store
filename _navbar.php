<<<<<<< HEAD
<?php
if (isset($_COOKIE["admin"]) &&$_COOKIE["admin"] == 1) {
    $isAdmin = true;
}
else {
    $isAdmin = false;
}

?>
<nav>
    <!-- <a class="logo">Hi, <?php echo $current_user; ?>!</a> -->
    <div class="menu">
        <a class="logo">Stand with Dorayaki</a>
=======
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="navbar" id="topnav">
        <a class="active">Stand with Dorayaki <?php echo ($_COOKIE["admin"] == 1) ?  "- Admin": "" ?></a>
>>>>>>> shafira
        <a href="dashboard.php">Home</a>
        <a href="history.php">History</a>
        <?php if($isAdmin) { ?>
        <a href="new-variant.php">Add Variant</a>
<<<<<<< HEAD
        <?php }?>
    </div>
    <form action="search-result.php">
        <input type="text" name="query" id="query">
        <button type="submit">Search</button>
    </form>
    <!-- <a href="../cart.php">Cart (<?php echo $totalItems; ?>)</a> -->
    <a href="logout.php">Logout</a>
</nav>
=======
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
>>>>>>> shafira
