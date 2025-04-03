<?php
/**
 * Template Name: Conteúdo Exclusivo para Associados
 */

get_header();

// Verifica se o usuário está logado
if (!is_user_logged_in()) {
    wp_safe_redirect(home_url('/restrito'));
    exit;
}

// Obtém o termo de busca, se existir
$search_query = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';

// Função para exibir os posts de cada CPT em grid
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
            if (has_post_thumbnail()) {
                echo "<div class='conteudo-item-imagem'>";
                the_post_thumbnail('medium'); 
                echo "</div>";
            }

            echo "<div class='conteudo-item-info'>";
            echo "<h3><a href='" . get_permalink() . "'>" . get_the_title() . "</a></h3>";
            echo "<p><strong>Data:</strong> " . esc_html($data_formatada) . "</p>";
            echo "</div></div>";
        endwhile;
        echo "</div>";
    }
    wp_reset_postdata();
}
?>

<style>
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
    
    /* Estilo para o container principal */
    .conteudo-exclusivo {
        padding: 50px 20px;
        color: white; /* Texto em branco */
        font-family: 'Arial', sans-serif;
        text-align: center;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Títulos principais */
    .conteudo-exclusivo h1,
    .conteudo-exclusivo h2 {
        color: white; /* Títulos em branco */
        font-size: 28px;
        margin-bottom: 20px;
    }

    /* Estilização dos inputs e botões */
    .conteudo-exclusivo input {
        padding: 10px;
        width: 80%;
        max-width: 400px;
        margin: 10px auto;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        color: white; /* Texto dos inputs em branco */
        background-color: #333; /* Fundo escuro para os inputs */
    }

    .conteudo-exclusivo button {
        background-color: #f44336;
        color: white;
        padding: 12px 20px;
        border: none;
        cursor: pointer;
        font-size: 16px;
        border-radius: 4px;
        transition: background-color 0.3s ease;
        margin-top: 10px;
    }

    .conteudo-exclusivo button:hover {
        background-color: #d32f2f;
    }

    /* Lista de conteúdos em grid */
    .conteudos-lista {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    /* Estilo dos itens de conteúdo */
    .conteudo-item {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 6px;
        text-align: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .conteudo-item:hover {
        transform: scale(1.05);
    }

    .conteudo-item h3 a {
        color: #000; /* Links em branco */
        text-decoration: none;
        font-size: 18px;
    }

    .conteudo-item h3 a:hover {
        text-decoration: underline;
    }

    .conteudo-item p {
        color: #000; /* Texto das descrições em branco */
        font-size: 14px;
        margin-top: 10px;
    }

    /* Estilo para as imagens dentro dos itens */
    .conteudo-item-imagem img {
        width: 100%;
        max-width: 220px;
        height: auto;
        border-radius: 6px;
        margin-bottom: 15px;
        object-fit: cover;
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .conteudo-exclusivo input {
            width: 90%;
        }

        .conteudo-item-imagem img {
            max-width: 180px;
        }
    }
</style>

<div class="background-overlay"></div>
<div class="conteudo-exclusivo">
    <h1>Conteúdo Exclusivo para Associados</h1>

    <form method="get" action="">
        <input type="text" name="search" placeholder="Buscar por conteúdo..." value="<?php echo esc_attr($search_query); ?>">
        <button type="submit">Buscar</button>
    </form>

    <?php 
        exibir_cpt('apresentacao', 'Apresentações', $search_query);
        exibir_cpt('estudo_analise', 'Estudos e Análises', $search_query);
        exibir_cpt('contribuicao', 'Contribuições', $search_query);
    ?>
</div>

<?php get_footer(); ?>
