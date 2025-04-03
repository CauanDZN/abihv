<?php
/**
 * Template Name: Grupos de Trabalho
 */

get_header();

// Verifica se o usuário está logado
if (!is_user_logged_in()) {
    wp_safe_redirect(home_url('/restrito'));
    exit;
}

// Query para buscar os grupos de trabalho
$args = array(
    'post_type'      => 'grupos_trabalho',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC'
);
$query = new WP_Query($args);
?>

<style>
    /* Configuração geral de fontes e cores */
    body, p, h1, h2, h3, h4, h5, h6 {
        color: #fff !important;
        font-family: 'Arial', sans-serif;
    }

    /* Estilo do container principal */
    .conteudo-exclusivo {
        position: relative;
        z-index: 1;
        padding: 50px 20px;
        text-align: center;
    }

    /* Fundo absoluto */
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

    /* Títulos principais */
    .conteudo-exclusivo h2 {
        font-size: 42px;
        font-weight: bold;
        margin-bottom: 30px;
        text-transform: uppercase;
        color: #fff;
    }

    .conteudo-item h3 {
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #fff;
    }

    .conteudo-item p {
        font-size: 18px;
        line-height: 1.8;
        max-width: 800px;
        margin: 10px auto;
        color: #dcdcdc;
    }

    /* Estilo para os links */
    a {
        text-decoration: none;
        color: #fff;
        font-weight: bold;
    }

    a:hover {
        color: #f44336;
    }

    /* Estilo para os conteúdos relacionados */
    .conteudos-relacionados {
        list-style: none;
        padding: 0;
        margin-top: 20px;
    }

    .conteudos-relacionados li {
        margin-bottom: 10px;
    }

    .conteudos-relacionados a {
        color: #f44336;
        font-size: 18px;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .conteudos-relacionados a:hover {
        color: #fff;
    }

    /* Estilo para a lista de grupos */
    .conteudos-lista {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
    }

    .conteudo-item {
        width: 300px;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.7);
        transition: transform 0.3s ease;
    }

    .conteudo-item:hover {
        transform: scale(1.05);
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

<!-- Conteúdo principal -->
<div class="conteudo-exclusivo">
    <h2>Grupos de Trabalho</h2>

    <?php if ($query->have_posts()) : ?>
        <div class="conteudos-lista">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="conteudo-item">
                    <?php
                        $permalink = get_the_permalink();
                        $url_parts = explode('/', rtrim($permalink, '/'));
                        $grupo_slug = end($url_parts);
                        $grupo_link = home_url("/grupo-de-trabalho/{$grupo_slug}");
                        echo '<h3><a href="' . $grupo_link . '">' . get_the_title() . '</a></h3>';
                    ?>

                    <p><?php the_excerpt(); ?></p>
            
                    <?php
                    $grupos = get_the_terms(get_the_ID(), 'grupo_de_trabalho');
                    
                    if ($grupos && !is_wp_error($grupos)) :
                        $grupo_ids = wp_list_pluck($grupos, 'term_id');
            
                        $conteudos_args = array(
                            'post_type'      => array('atas_reuniao', 'documentos', 'calendario_reunioes', 'emendas_aprovadas'),
                            'posts_per_page' => -1,
                            'tax_query'      => array(
                                array(
                                    'taxonomy' => 'grupo_de_trabalho',
                                    'field'    => 'term_id',
                                    'terms'    => $grupo_ids,
                                ),
                            ),
                        );
            
                        $conteudos_query = new WP_Query($conteudos_args);
                        if ($conteudos_query->have_posts()) :
                    ?>
                            <ul class="conteudos-relacionados">
                                <?php while ($conteudos_query->have_posts()) : $conteudos_query->the_post(); ?>
                                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                <?php endwhile; ?>
                            </ul>
                        <?php endif;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <p>Nenhum grupo de trabalho encontrado.</p>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>
</div>

<?php get_footer(); ?>
