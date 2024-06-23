<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="css/styles.css">
</head>


<body>
<?php include 'includes/header.php'; ?>

<div class="wrapper">
<div class="form-title">Register</div>
    <form method="POST" action="scripts/register_script.php">
    <div class="form-field">
    <input type="text" name="username" placeholder="Username" required>
    </div>
    <div class="form-field">
    <input type="email" name="email" placeholder="Email" required>
    </div>
    <div class="form-field">
        <input type="password" name="password" placeholder="Password" required> 
    </div>
    
    <div class="form-field">
        <input type="submit"></input>
    </div>
    <div class="link">
        Already have an account? <a href="login.php" title="Log in Now">Log-In</a>
    </div>
    </form>
</div>


<?php include 'includes/footer.php'; ?>
</body>
</html>