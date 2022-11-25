<?php require_once './database/connection.php'; ?>
<?php
session_start();

if (isset ($_SESSION['id'])) {
    header('location: ./index.php');
}

$error = $success = $name = $email = '';

if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $cPassword = htmlspecialchars($_POST['cPassword']);

    if (empty($name)) {
        $error = 'Provide your name';
    } elseif (empty($email)) {
        $error = 'Provide your email';
    } elseif (empty($password)) {
        $error = 'Provide your password';
    } else {
        $sql = "SELECT * FROM `users` WHERE `email` = '${email}'";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            
            if (strlen($password) < 4) {
                $error = 'Password should be 4 or more';
            } else {
                if ($password === $cPassword) {
                    $new_password = md5($password);
                    $sql = "INSERT INTO `users`(`name`, `email`, `password`) VALUES ('${name}', '${email}', '${new_password}')";

                    if ($conn->query($sql)) {
                        $success = 'User has been succesfully resgistered!';
                    } else {
                        $error = 'User has failed to resgister!';
                    }
                    
                } else {
                    $error = 'Password does not match!';
                }
            }

        } else {
            $error = 'E-mail already exists!';
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
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Register</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-danger"><?php echo $error; ?></div>
                        <div class="text-success"><?php echo $success; ?></div>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                            <div class="mb-2">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name!" value="<?php echo $name; ?>">
                            </div>

                            <div class="mb-2">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your Email!" value="<?php echo $email; ?>">
                            </div>

                            <div class="mb-2">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your Password!">
                            </div>

                            <div class="mb-2">
                                <label for="cPassword">Confirm Password</label>
                                <input type="password" class="form-control" name="cPassword" id="cPassword" placeholder="Please confrim your Password!">
                            </div>

                            <div class="mb-2">
                                <input type="submit" value="Submit" name="submit" class="btn btn-primary">
                            </div>

                            Already registered? <a href="./login.php">Login</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</html>