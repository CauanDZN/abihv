<?php
/**
 * Template Name: Associados
 */

// Verifica se o usuário está logado
if (!is_user_logged_in()) {
    wp_redirect(home_url('/restrito'));
    exit;
}

// Obtém as informações do usuário logado
$current_user = wp_get_current_user();
$user_roles = $current_user->roles;

// Verifica se o usuário tem permissão para acessar a área
if (!in_array('area-associado', $user_roles)) {
    wp_redirect(home_url());
    exit;
}

get_header();
?>

<style>
    /* Estilo para o container principal */
    .afiliados-container {
        position: relative;
        z-index: 1;
        padding: 50px 20px;
        color: #fff;
        font-family: 'Arial', sans-serif;
        text-align: center;
    }

    /* Estilo para o fundo absoluto */
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

    /* Estilo para o título principal */
    .afiliados-container h2 {
        font-size: 36px;
        margin-bottom: 20px;
        color: #fff;
    }
    
    .afiliados-container h3 {
        font-size: 36px;
        margin-bottom: 20px;
        color: #fff;
    }

    /* Estilo para as abas de navegação */
    .nav-tabs {
        list-style: none;
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
        padding: 0;
    }

    .nav-tabs li {
        margin: 0 15px;
    }

    .nav-tabs a {
        text-decoration: none;
        color: #fff;
        font-size: 18px;
        font-weight: bold;
        transition: color 0.3s ease;
    }

    .nav-tabs a:hover {
        color: #f44336;
    }

    /* Estilo para as seções */
    .associados-container div {
        margin-bottom: 50px;
        color: #dcdcdc; /* Texto cinza claro */
    }

    .associados-container h3 {
        font-size: 28px;
        color: #fff; /* Título em branco */
        margin-bottom: 15px;
    }

    .associados-container p {
        font-size: 18px;
        line-height: 1.6;
        max-width: 800px;
        margin: 0 auto;
    }

    /* Estilo para o botão de logout */
    .logout-button {
        background-color: #f44336;
        color: white;
        padding: 12px 24px;
        text-decoration: none;
        border-radius: 5px;
        display: inline-block;
        margin-top: 20px;
        font-size: 18px;
    }

    .logout-button:hover {
        background-color: #d32f2f;
    }
</style>

<!-- Background absoluto -->
<div class="background-overlay"></div>

<div class="afiliados-container">
    <h2>Bem-vindo, <?php echo esc_html($current_user->display_name); ?>!</h2>
    <p>Acesse as áreas exclusivas para associados e aproveite os benefícios.</p>

    <!-- Navegação por abas -->
    <ul class="nav-tabs">
        <li><a href="/eventos-sala">Próximos Eventos ABIHV</a></li>
        <li><a href="/conteudo-exclusivo-para-associados">Conteúdo Exclusivo</a></li>
        <li><a href="/grupos-de-trabalho-sala">Grupos de Trabalho</a></li>
        <li><a href="/diretoria-sala">Diretoria e Assembleia</a></li>
        <li><a href="/estatuto-normas-e-codigo-de-etica">Estatuto, Normas e Código de Ética</a></li>
    </ul>

    <!-- Seções do conteúdo -->
    <div id="eventos">
        <h3>Próximos Eventos ABIHV</h3>
        <p>Fique por dentro dos próximos eventos exclusivos para associados da ABIHV.</p>
        <!-- Aqui você pode adicionar um sistema dinâmico para mostrar eventos futuros -->
    </div>

    <div id="conteudo">
        <h3>Conteúdo Exclusivo</h3>
        <p>Acesse materiais, artigos e outros conteúdos exclusivos para membros.</p>
        <!-- Adicione links para downloads ou recursos exclusivos aqui -->
    </div>

    <div id="grupos">
        <h3>Grupos de Trabalho</h3>
        <p>Participe de grupos de trabalho especializados e ajude a impulsionar nossa comunidade.</p>
        <!-- Aqui pode-se incluir uma lista ou links para os grupos de trabalho -->
    </div>

    <div id="diretoria">
        <h3>Diretoria e Assembleia</h3>
        <p>Saiba mais sobre a nossa diretoria e a assembleia da associação.</p>
        <!-- Pode-se incluir informações sobre membros da diretoria ou atas de assembleias anteriores -->
    </div>

    <div id="normas">
        <h3>Estatuto, Normas e Código de Ética</h3>
        <p>Conheça as diretrizes da nossa associação e o código de ética que nos orienta.</p>
        <!-- Links para download do estatuto ou outras normas podem ser incluídos aqui -->
    </div>

    <!-- Botão de logout -->
    <a href="<?php echo wp_logout_url(home_url()); ?>" class="logout-button">Sair</a>
</div>

<?php get_footer(); ?>
