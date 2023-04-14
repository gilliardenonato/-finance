<?php
    include_once('../includes_php/connect_db.php');

    header('Content-Type: application/json');
    $response = array();
    $request_body = file_get_contents('php://input');
    $data     = json_decode($request_body);
    $name     = $data->name;
    $email    = $data->email;
    $password = $data->password;
    $confirmPassword = $data->confirmPassword;

    $response = array();
    if (empty($name)) {
        $response['error_name'] = 'por favor insira um nome de usuario';
    } else if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $name)){
        $response['error_name'] = 'o nome de usuario deve ter entre 3 e 23 caracteres e não pode conter caracteres especiais.';
    }

    if (empty($email)) {
        $response['error_email'] = 'por favor insira um email';
    } else {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $resultado = mysqli_query($connect, $sql);

        // Verifica se ocorreu algum erro na consulta
        if (!$resultado) {
            $response['connect_failed'] = "error";
        }

        // Verifica se o e-mail já está cadastrado
        if (mysqli_num_rows($resultado) > 0) {
            $response['error_email'] = "Este e-mail já está cadastrado no sistema.";
        } 
    }
    
    if (empty($password)) {
        $response['password_error'] = 'Por favor, insira sua senha.';
    } elseif (strlen($password) < 6) {
        $response['password_error'] = 'A senha deve ter pelo menos 6 dígitos.';
    } elseif (!preg_match('/[0-9]/', $password) || !preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)) {
        $response['password_error'] = 'A senha deve conter pelo menos um número e um caractere especial.';
    }

    if (empty($confirmPassword)) {
        $response['confirm_password_error'] = 'Por favor, confirme sua senha.';
    } elseif ($password !== $confirmPassword) {
        $response['confirm_password_error'] = 'As senhas não coincidem.';
    }

    // Se não houver erros, adiciona o usuário ao banco de dados
    if (count($response) == 0) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (user_name, email, password) VALUES ('$name', '$email', '$password_hash')";
        $resultado = mysqli_query($connect, $sql);

        // Verifica se ocorreu algum erro na inserção
        if (!$resultado) {
            $response['connect_failed'] = "error";
            $response['status'] = 'error';
        } else {
            $response['status'] = 'success';
            $response['redirect'] = '/login.php';
        }
    } else {
        $response['status'] = 'error';
    }
   
    echo json_encode($response);

    // if (count($response) == 0) {
    //     header('Location: /login.php');
    //     exit;
    //  }
     
    
