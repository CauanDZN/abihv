<?php
/**
 * Template Name: Página de Login
 */

if (is_user_logged_in()) {
    echo "Usuário já está logado! Redirecionando...<br>";
    echo "<script>window.alert('Você já está logado. Redirecionando...');</script>";
    sleep(3);
    wp_redirect(home_url('/area-associados'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    echo "Processando login...<br>";

    // Captura o valor do campo de login
    $login_value = $_POST['username'];

    // Verifica se o valor é um e-mail
    if (is_email($login_value)) {
        // Verifica se o e-mail existe no sistema
        $user = get_user_by('email', $login_value);
        if ($user) {
            $creds = array(
                'user_login'    => $user->user_login,  // Usa o login do usuário relacionado ao e-mail
                'user_password' => $_POST['password'],
                'remember'      => true
            );
        } else {
            $error_message = "E-mail não encontrado!";
        }
    } else {
        $creds = array(
            'user_login'    => $login_value,
            'user_password' => $_POST['password'],
            'remember'      => true
        );
    }
    
    // Processa o login
    if (!isset($error_message)) {
        $user = wp_signon($creds, false);

        if (!is_wp_error($user)) {
            echo "Login bem-sucedido! Redirecionando...<br>";
            echo "<script>window.alert('Login realizado com sucesso! Redirecionando...');</script>";
            sleep(3);
            wp_redirect(home_url('/area-associados'));
            exit;
        } else {
            echo "Erro no login: " . $user->get_error_message() . "<br>";
            $error_message = "Usuário ou senha incorretos.";
        }
    }
}

get_header();
?>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
    }

    .background-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('https://abihv.org.br/wp-content/uploads/2023/09/bg-principal.png');
        background-size: cover;
        background-position: center;
        z-index: -1;
    }

    .login-container {
        max-width: 400px;
        margin: 100px auto;
        padding: 40px;
        background-color: rgba(0, 0, 0, 0.7);
        color: #fff;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .login-container h2 {
        font-size: 28px;
        margin-bottom: 20px;
        color: #fff;
    }

    .login-container p {
        font-size: 16px;
        color: red;
        margin-bottom: 20px;
    }

    .login-container input {
        width: 100%;
        padding: 15px;
        margin: 10px 0;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        background-color: #fff;
        color: #333;
    }

    .login-container button {
        width: 100%;
        padding: 15px;
        background-color: #f44336;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .login-container button:hover {
        background-color: #d32f2f;
    }

    .login-container .forgot-password {
        color: #bbb;
        font-size: 14px;
        margin-top: 10px;
        text-decoration: none;
    }

    .login-container .forgot-password:hover {
        color: #fff;
    }
</style>

<div class="background-overlay"></div>

<div class="login-container">
    <h2>Login de Afiliados</h2>
    
    <?php if (isset($error_message)) echo "<p>$error_message</p>"; ?>

    <form method="post">
        <input type="text" name="username" placeholder="Nome de Usuário ou E-mail" required>
        <input type="password" name="password" placeholder="Senha" required>
        <button type="submit" name="login">Entrar</button>
    </form>

    <a href="#" class="forgot-password">Esqueceu a senha?</a>
</div>

<?php get_footer(); ?>
