<?php 
session_start();
if (!isset($_SESSION["login"])) {
  header("Location: ../login.php");
}
$current_user = $_SESSION["username"];
$cart = $_SESSION["cart"];
$totalItems = count($cart);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booksy</title>
    <link href="../styles/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
<body>
    <!-- navbar from scratch -->
    <nav>
      <a class="logo">Booksy </a>
      <a class="logo">Hi, <?php echo $current_user; ?>!</a>
      <a href="#home" class="active">Home</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
      <a href="../cart.php">Cart (<?php echo $totalItems; ?>)</a>
      <a href="../logout.php">Logout</a>
    </nav>

    <!-- jumbotron -->
    <div class="jumbotron">
        <h1 class="headline">Book your success with <span>Booksy</span></h1>
        <p>Using a series of utilities, you can create this jumbotron, just like the one in previous versions of Bootstrap. Check out the examples below for how you can remix and restyle it to your liking.</p>
        <button class="btn-jumbotron"><a href="product.html">Shop Now</a></button>
    </div>

    <!-- product, scratch -->
    <div class="container">
      <h1 class="headline">Our Products</h1>
      <div class="products" id="ourProducts">
      
      </div>
    </div>

    <!-- footer -->
    <footer>13519040 - Shafira Naya Aprisadianti</footer>
    <script src="../script/index.js"></script>
</body>
</html>