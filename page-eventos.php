<?php
/**
 * Template Name: Página de Eventos
 */

get_header(); ?>

<div class="container">
    <h1>Eventos</h1>
    <form method="get" action="">
        <input type="text" name="search" placeholder="Buscar eventos..." value="<?php echo esc_attr(get_query_var('search')); ?>">
        <button type="submit">Buscar</button>
        <h1>PAGE PERSONALIZADA</h1>
    </form>

    <?php
    $args = [
        'post_type' => 'eventos',
        'posts_per_page' => 10,
        's' => get_query_var('search') ?? ''
    ];
    $query = new WP_Query($args);

    if ($query->have_posts()) : 
        while ($query->have_posts()) : $query->the_post(); ?>
            <div class="evento">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <p><?php echo get_post_meta(get_the_ID(), 'event_start_date', true); ?></p>
                <p><?php the_excerpt(); ?></p>
                <a href="<?php the_permalink(); ?>">Ver detalhes</a>
            </div>
        <?php endwhile;
        wp_reset_postdata();
    else :
        echo '<p>Nenhum evento encontrado.</p>';
    endif;
    ?>
</div>

<?php get_footer(); ?>
