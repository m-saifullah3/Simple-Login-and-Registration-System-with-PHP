<?php require_once './database/connection.php'; ?>
<?php
session_start();

if (isset ($_SESSION['id'])) {
    header('location: ./index.php');
}

$error = $success = $name = $email = '';

if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($email)) {
        $error = 'Provide your email';
    } elseif (empty($password)) {
        $error = 'Provide your password';
    } else {
        $new_password = md5($password);
        $sql = "SELECT * FROM `users` WHERE `email` = '${email}' AND `password` = '${new_password}'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['id'] = $user['id'];
            header('location: ./index.php');
        } else {
            $error = 'Invalid combination';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Login</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-danger"><?php echo $error; ?></div>
                        <div class="text-success"><?php echo $success; ?></div>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                            <div class="mb-2">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your Email!" value="<?php echo $email; ?>">
                            </div>

                            <div class="mb-2">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your Password!">
                            </div>

                            <div class="mb-2">
                                <input type="submit" value="Submit" name="submit" class="btn btn-primary">
                            </div>

                            Not registered? <a href="./register.php">Register</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</html>