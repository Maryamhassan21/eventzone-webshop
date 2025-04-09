<?php
include 'config/dbaccess.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user information from the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if user is inactive
        if ($user['status'] === 'inactive') {
            $_SESSION['login_error'] = "Your account is inactive. Please contact the administrator.";
            header('Location: login.php');
            exit();
        }

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header('Location: index.php');
            exit();
        } else {
            $_SESSION['login_error'] = "Invalid username or password.";
        }
    } else {
        $_SESSION['login_error'] = "Invalid username or password.";
    }
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/hotel.ico">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <!-- navbar -->
    <?php include 'inc/navbar.php'; ?>

    <!-- container -->
    <main>
        <div class="custom-container" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="login-form" style="max-width: 400px; margin: 0 auto; border-radius: 15px; padding: 20px; border: 1px solid #ccc; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); ">
                <h2 class="text-center">Login</h2>
                <?php if (isset($_SESSION['login_error'])): ?>
                    <div class="alert alert-danger">
                        <?php
                        echo $_SESSION['login_error'];
                        unset($_SESSION['login_error']);
                        ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="login.php">
                     <!--
                    <div class="col-md-6 col-12 mb-3">
                        <label for="role" class="form-label">Role:</label>
                        <select id="role" name="role" class="form-control">
                            <option value="guest">guest</option>
                            <option value="admin">admin</option>
                            <option value="user">user</option>
                        </select>
                    
                    </div>
                    -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" id="username" name="username" required placeholder="Enter your username" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" id="password" name="password" required placeholder="Enter your password" minlength="3" maxlength="20" class="form-control">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include 'inc/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
