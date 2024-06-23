<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <header>
    <nav class="navbar">
	<div class="containernavigasi">
		<a href="https://sensestudio.cloud" class="logo">SENSE</a>
		<ul class="menu">
			<li><a href="index.php">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
			<li><a href="cart.php">Cart</a></li>
            <li><a href="contact.php">Contact Us</a></li>
			<li><a href="logout.php">Log-out</a></li>
            <?php else: ?>
            <li><a href="contact.php">Contact Us</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
            <?php endif; ?>
		</ul>
		<div class="tombolnavigasi">
			&#9776;
		</div>
 
	</div>
    </nav>
    </header>


	<script type="text/javascript">
		const tombolnavigasi = document.querySelector('.tombolnavigasi');
		const menu = document.querySelector('.menu');
 
		// membuat event click
		// pada saat tombolnavigasi di click, tambahkan class aktif pada class menu
		// saat diklik lagi, maka class aktif dihilangkan dari class menu (toggle)
		tombolnavigasi.addEventListener('click', () => {
			menu.classList.toggle('aktif');
		});
	</script>
</body>
</html>
