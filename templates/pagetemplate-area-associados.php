<?php
/**
 * Template Name: Área de Afiliados
 */

if (!is_user_logged_in()) {
    echo "Usuário não logado! Redirecionando para restrito...<br>";
    echo "<script>window.alert('Você precisa estar logado para acessar esta área. Redirecionando...');</script>";
    sleep(3);
    wp_redirect(home_url('/restrito'));
    exit;
}

$current_user = wp_get_current_user();
$user_roles = $current_user->roles;

if (!in_array('area-associado', $user_roles)) {
    echo "Usuário sem permissão! Redirecionando para home...<br>";
    echo "<script>window.alert('Você não tem permissão para acessar esta área. Redirecionando...');</script>";
    sleep(3);
    wp_redirect(home_url());
    exit;
}

get_header();
?>

<style>
    .afiliados-container {
        position: relative;
        z-index: 1;
        padding: 50px 20px;
        color: #fff;
        text-align: center; /* Centraliza o conteúdo */
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

    h1, h2, h3 {
        color: #fff; /* Define a cor branca */
        text-align: center; /* Centraliza os títulos */
    }

    .logout-button {
        background-color: #f44336;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        display: inline-block;
        margin-top: 20px;
    }

    .logout-button:hover {
        background-color: #d32f2f;
    }
</style>

<div class="background-overlay"></div>

<div class="afiliados-container">
    <h2>Bem-vindo, <?php echo esc_html($current_user->display_name); ?></h2>
    <p>Acesse a área exclusiva de associados.</p>
    <a href="<?php echo home_url('/associados-sala'); ?>">Ir para Área de Associados</a>

    <a href="<?php echo wp_logout_url(home_url()); ?>" class="logout-button">Sair</a>
</div>

<?php get_footer(); ?>
