<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>PhotoPlay</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<?php session_start(); ?>
<header>
    <div class="logo">
        <img src="images/logo.png" alt="PhotoPlay">
    </div>
    <?php include "menu.php"; ?>
</header>
<main>
    <div class="container">
        
    </div>

</main>

<footer class="footer">
    <ul>
        <li><a href="#">Facebook</a></li>
        <li><a href="#">Twitter</a></li>
        <li><a href="#">Instagram</a></li>
    </ul>
    <p>&copy; <?php echo date("Y"); ?> PhotoPlay. All rights reserved.</p>
</footer>
</body>
</html>