<?php
include '../includes/session.php';
include '../config/database.php';

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

// Handle the delete user action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Delete related rows in the `cart` table
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $delete_id);
    $stmt->execute();

    // Now delete the user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindParam(':id', $delete_id);
    $stmt->execute();

    header("Location: manage_users.php");
    exit;
}

// Handle the update role action
if (isset($_POST['update_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['role'];
    $stmt = $conn->prepare("UPDATE users SET role = :role WHERE id = :id");
    $stmt->bindParam(':role', $new_role);
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    header("Location: manage_users.php");
    exit;
}

// Fetch all users
$users = $conn->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
<?php include '../includes/adminheader.php'; ?>
    <div class="container-managed">
        <h1>Manage Users</h1>
        <a href="dashboard.php" class="back-link">Back to Dashboard</a><br><br>
        <div class="user-list-header">
            <span class="header-username">Username</span>
            <span class="header-email">Email</span>
            <span class="header-role">Role</span>
            <span class="header-delete">Delete</span>
            <span class="header-change">Change</span>
            <span class="header-update">Update</span>
        </div>
        <ul class="user-list">
            <?php foreach ($users as $user): ?>
                <li>
                    <span class="user-username"><?php echo htmlspecialchars($user['username']); ?></span>
                    <span class="user-email"><?php echo htmlspecialchars($user['email']); ?></span>
                    <span class="user-role"><?php echo htmlspecialchars($user['role']); ?></span>
                    <a href="manage_users.php?delete_id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')" class="delete-link">Delete</a>
                    <form action="manage_users.php" method="post" class="role-form">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <select name="role">
                            <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
                            <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                        </select>
                        <button type="submit" name="update_role">Update</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
