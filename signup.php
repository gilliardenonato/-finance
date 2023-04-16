<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/signup.css">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <title>signUp</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Criar conta</h2>
        </div>
        <form action="assets/php/register.php" class="form" id="form" method="POST">
            <div class="form-control">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username">
                <i class="img-success"><img src="assets/img/success-icon.svg" alt=""></i>
                <i class="img-error"><img src="assets/img/error-icon.svg" alt=""></i>
                <div class="error-msg"></div>
            </div>
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

            <div class="form-control">
                <label for="Confpassword">Confirm password</label>
                <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm password">
                <i class="img-success"><img src="assets/img/success-icon.svg" alt=""></i>
                <i class="img-error"><img src="assets/img/error-icon.svg" alt=""></i>
                <div class="error-msg"></div>
            </div>
            <button type="submit" id="btn">Registrar</button>

            <div class="modal">
                <div class="modal-content">
                    <p>Cadastro efetuado com sucesso!</p>
                </div>
            </div>

        </form>
        <p>já tem uma conta? <a href="login.php">faça o login</a></p>
    </div>

    <script src="assets/js/signup_validation.js"></script>

</body>
</html>