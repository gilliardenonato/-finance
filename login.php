<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>login</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Entrar em sua conta</h2>
        </div>
        <form action="assets/php/action_php/login_authenticator.php" class="form" id="loginForm" method="POST">
            <div class="form-control">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email">
                <i class="img-success"><img src="assets/img/success-icon.svg" alt=""></i>
                <i class="img-error"><img src="assets/img/error-icon.svg" alt=""></i>
                <div class="error-msg"></div>
            </div>
            <div class="form-control">
                <label for="password">Password</label>
                <input type="password" id="password" class="password" name="password" placeholder="Password">
                <i class="img-success"><img src="assets/img/success-icon.svg" alt=""></i>
                <i class="img-error"><img src="assets/img/error-icon.svg" alt=""></i>
                <div class="error-msg"></div>
            </div>

            <button type="submit">Login</button>
        </form>
        <p>ainda não tem uma conta? <a href="signup.php">Criar conta</a></p>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/login_validation.js"></script>
</body>

</html>