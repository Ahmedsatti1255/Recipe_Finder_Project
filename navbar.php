<link rel="stylesheet" href="style.css">


<nav>
    <a href="index.php">Home</a> |
    <a href="favorites.php">Favorites</a> |

    <?php if(isset($_SESSION['user_id'])): ?>
        Welcome, <?php echo $_SESSION['name']; ?> |
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a> |
        <a href="signup.php">Signup</a>
    <?php endif; ?>
</nav>
<hr>
