<?php
/**
 * Template Name: Diretoria
 */

get_header();

if (!is_user_logged_in()) {
    wp_safe_redirect(home_url('/restrito'));
    exit;
}

$search_query = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';

function exibir_cpt($post_type, $titulo, $search_query) {
    $args = array(
        'post_type'      => $post_type,
        'posts_per_page' => -1,
        's'              => $search_query,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo "<h2>{$titulo}</h2>";
        echo "<div class='conteudos-lista'>";
        while ($query->have_posts()) : $query->the_post();
            $data = get_post_meta(get_the_ID(), '_data_referencia', true);

            if ($data) {
                $date = DateTime::createFromFormat('Y-m-d', $data);
                $data_formatada = $date ? $date->format('d/m/Y') : '';
            }
            
            echo "<div class='conteudo-item'>";
            echo "<h3><a href='" . get_permalink() . "'>" . get_the_title() . "</a></h3>";
            echo "<p><strong>Data:</strong> " . esc_html($data_formatada) . "</p>";
            echo "</div>";
        endwhile;
        echo "</div>";
    }
    wp_reset_postdata();
}

?>

<style>
    /* Estilo para o container principal */
    .conteudo-exclusivo {
        position: relative;
        z-index: 1;
        padding: 50px 20px;
        color: #fff;
        font-family: 'Arial', sans-serif;
        text-align: center;
    }

    /* Estilo para o fundo absoluto */
    .background-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('https://abihv.org.br/wp-content/uploads/2023/09/bg-principal.png');
        background-size: cover;
        background-position: center;
        z-index: -1;
    }

    /* Garante que os textos dos títulos fiquem brancos */
    .conteudo-exclusivo h1,
    .conteudo-exclusivo h2,
    .conteudo-exclusivo h3 {
        color: #fff !important;
    }

    /* Estilização dos inputs e botões */
    .conteudo-exclusivo input {
        padding: 10px;
        width: 300px;
        margin: 10px;
        border: 1px solid #fff;
        background: transparent;
        color: #fff;
        text-align: center;
    }

    .conteudo-exclusivo button {
        background-color: #f44336;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        font-size: 16px;
    }

    .conteudo-exclusivo button:hover {
        background-color: #d32f2f;
    }

    /* Estiliza a lista de conteúdos para ser um grid flexível */
    .conteudos-lista {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin-top: 20px;
    }

    .conteudo-item {
        background: rgba(255, 255, 255, 0.1);
        padding: 15px;
        width: 250px;
        border-radius: 8px;
        text-align: center;
        transition: transform 0.3s ease, background 0.3s ease;
    }

    .conteudo-item:hover {
        transform: scale(1.05);
        background: rgba(255, 255, 255, 0.2);
    }

    .conteudo-item h3 a {
        color: #fff;
        text-decoration: none;
        font-size: 18px;
    }

    .conteudo-item h3 a:hover {
        text-decoration: underline;
    }

    .conteudo-item p {
        color: #ddd;
        font-size: 14px;
    }
</style>

<!-- Background absoluto -->
<div class="background-overlay"></div>

<div class="conteudo-exclusivo">
    <h1>Diretoria</h1>

    <form method="get" action="">
        <input type="text" name="search" placeholder="Buscar por conteúdo..." value="<?php echo esc_attr($search_query); ?>">
        <button type="submit">Buscar</button>
    </form>

    <?php 
        exibir_cpt('atas_diretoria', 'Atas de Reunião da Diretoria', $search_query);
        exibir_cpt('atas_assembleia', 'Atas da Assembleia', $search_query);
    ?>
</div>

<?php get_footer(); ?>
