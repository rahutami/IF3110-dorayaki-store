    <nav>
        <!-- <a class="logo">Hi, <?php echo $current_user; ?>!</a> -->
        <div class="menu">
            <a class="logo">Stand with Dorayaki</a>
            <a href="dashboard.php">Home</a>
            <a href="history.php">History</a>
            <a href="new-variant.php">Add Variant</a>
        </div>
        <form action="search-result.php">
            <input type="text" name="query" id="query">
            <button type="submit">Search</button>
        </form>
        <!-- <a href="../cart.php">Cart (<?php echo $totalItems; ?>)</a> -->
        <a href="logout.php">Logout</a>
    </nav>