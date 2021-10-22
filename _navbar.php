<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="navbar" id="topnav">
        <a class="active">Stand with Dorayaki <?php echo ($_COOKIE["admin"] == 1) ?  "- Admin": "" ?></a>
        <a href="dashboard.php">Home</a>
        <a href="history.php">History</a>
        <a href="new-variant.php">Add Variant</a>
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