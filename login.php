<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>



<body>
<?php include 'includes/header.php'; ?>
<div class="wrapper">
<div class="form-title">Login</div>
    <form method="POST" action="scripts/login_script.php">
    <div class="form-field">
        <input type="text" name="username" placeholder="Username" required>
    </div>
    <div class="form-field">
        <input type="password" name="password" placeholder="Password" required> 
    </div>
    
    <div class="form-field">
        <input type="submit"></input>
    </div>
    <div class="link">
        Not a member? <a href="register.php" title="Sign up now">Signup now</a>
    </div>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color:red;">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']); // Hapus pesan kesalahan setelah ditampilkan
    }
    ?>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>