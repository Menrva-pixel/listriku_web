<?php
session_start();
include '../env/config.php';

// Redirect to login page if not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['privilege'] !== 'Admin') {
    header('Location: login.php');
    exit;
}

// Get user ID from URL parameter
if (!isset($_GET['user_id'])) {
    header('Location: admin.php');
    exit;
}

$user_id = $_GET['user_id'];

// Fetch user data from database
$query = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Update user data if form is submitted
if (isset($_POST['submit'])) {
    $username = $_POST['username'];

    // Perform validation and update user data in database
    // ...

    // Redirect to admin page after successful update
    header('Location: ../pages/admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Edit User</h1>
    <form method="POST" action="edit_user.php?id=<?php echo $user_id; ?>">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Update</button>
    </form>
</body>
</html>
