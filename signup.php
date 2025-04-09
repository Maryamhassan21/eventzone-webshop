<?php
include 'config/dbaccess.php'; // File to establish a connection.
session_start();

$errorMessage = ""; // Error message default initialization.

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Checks if the form is submitted.
    // Collecting user inputs
    $salutation = $_POST['salutation'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $adress = $_POST['adress'];
    $zip = $_POST['zip'];
    $place = $_POST['place'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $status = 'active'; // Set default status to 'active'
    $role = 'user'; // Set default role to 'user'

    // Check if selected fields are empty
    if (empty($salutation) || empty($firstName) || empty($lastName) || empty($username) || empty($email) || empty($password) || empty($adress) || empty($zip) || empty($place)) {
        $errorMessage = "All required fields must be filled out.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  // Check if email is valid
        $errorMessage = "Invalid email format.";
    } elseif ($password !== $confirmPassword) {  // Check if password and confirm password match
        $errorMessage = "Passwords do not match!";
    } else {
        // Check if username or email already exists
        $checkUserExistance = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?"); // ? = placeholder
        $checkUserExistance->bind_param("ss", $username, $email);
        $checkUserExistance->execute();
        $result = $checkUserExistance->get_result();

        if ($result->num_rows > 0) { // If there is a row in the table, user exists
            $errorMessage = "Username or email already exists!";
        } else {
            // Hash the password before storing it
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Add user to db
            $addUser = $conn->prepare("INSERT INTO users (salutation, firstName, lastName, username, email, password, adress, zip, place, status, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $addUser->bind_param("sssssssssss", $salutation, $firstName, $lastName, $username, $email, $hashedPassword, $adress, $zip, $place, $status, $role);
            if ($addUser->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $errorMessage = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/hotel.ico">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>

<body>
    <!-- navbar -->
    <?php include 'inc/navbar.php'; ?>

    <main>
        <div class="custom-container" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="signup-form"
                style="width: 70%; margin: 0 auto; border-radius: 15px; padding: 20px; border: 1px solid #ccc; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); ">
                <h2 class="text-center">Sign Up</h2>
                <form name="registrationForm" method="POST" action="signup.php">
                    <?php if (!empty($errorMessage)): ?>
                        <p style="color: red;"><?php echo $errorMessage; ?></p>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['signup_error'])): ?>
                        <div class="alert alert-danger">
                            <?php
                            echo $_SESSION['signup_error'];
                            unset($_SESSION['signup_error']);
                            ?>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="mb-4">
                            <label for="salutation" class="form-label">Salutation:</label>
                            <select id="salutation" name="salutation" class="form-control">
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Ms">Ms</option>
                            </select>
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <label for="firstName" class="form-label">First Name:</label>
                            <input type="text" id="firstName" name="firstName" required
                                placeholder="Enter your first name" class="form-control">
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <label for="lastName" class="form-label">Last Name:</label>
                            <input type="text" id="lastName" name="lastName" required placeholder="Enter your last name"
                                class="form-control">
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" id="username" name="username" required placeholder="Enter your username"
                                minlength="2" maxlength="20" class="form-control">
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <label for="adress" class="form-label">Address:</label>
                            <input type="text" id="adress" name="adress" required placeholder="Enter your address"
                                class="form-control">
                        </div>

                        <div class="col-md-3 col-12 mb-3">
                            <label for="zip" class="form-label">ZIP Code:</label>
                            <input type="text" id="zip" name="zip" required placeholder="Enter ZIP code"
                                class="form-control">
                        </div>

                        <div class="col-md-3 col-12 mb-3">
                            <label for="place" class="form-label">City/Place:</label>
                            <input type="text" id="place" name="place" required placeholder="Enter your city/place"
                                class="form-control">
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" required placeholder="Enter your email"
                                class="form-control">
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" id="password" name="password" required
                                placeholder="Enter your password" minlength="8" maxlength="25" class="form-control">
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password:</label>
                            <input type="password" id="confirmPassword" name="confirmPassword" required
                                placeholder="Confirm your password" class="form-control">
                        </div>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include 'inc/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>