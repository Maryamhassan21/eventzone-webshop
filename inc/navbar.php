<?php
// check if is session not started (php_session_none)
if (session_status() == PHP_SESSION_NONE) {
    //, start it
    session_start();
} //else continue in the same session (aka do nothing)
?>

<?php include 'head.php'; ?>
<!-- looks better than bootstrap alone less spaces inbetween -->
<div class="naviwrap">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="img/logo.png" alt="Eventzone Logo" style="height: 50px;">
                <?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])): ?>
                    <span class="navbar-text">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                <?php endif; ?>

            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php">Protukte</a></li>
                    <li class="nav-item ms-3">
                        <a class="nav-link" href="cart.php">
                            <img src="img/cart.png" alt="Cart icon" style="height: 30px;">
                        </a>
                    </li>
                    <?php if (isset($_SESSION['username'])): ?>

                        <!-- if user is logged in AS ADMIN show: -->
                        <?php if ($_SESSION['role'] == 'admin'): ?>
                            <li class="nav-item"><a class="nav-link" href="accountManaging.php">UserAccounts</a></li>

                            <!-- if user is logged in AS USER show: -->
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="userAccount.php">Account</a></li>
                            <li class="nav-item"><a class="nav-link" href="rooms.php">Booking</a></li>
                            <li class="nav-item"><a class="nav-link" href="bookingsHistory.php">History</a></li>
                            <li class="nav-item"><a class="nav-link" href="news.php">News</a></li>
                        <?php endif; ?>
                        <!--all users that are logged in-->
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>

                        <!-- if user is not logged in  show:-->
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="signup.php">Register</a></li>

                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</div>