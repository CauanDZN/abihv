<?php get_header(); ?>

<div class="container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>

        <p><strong>Data:</strong> <?php echo get_post_meta(get_the_ID(), 'event_start_date', true); ?></p>
        <p><strong>Hora:</strong> <?php echo get_post_meta(get_the_ID(), 'event_start_time', true); ?></p>
        <p><strong>Local:</strong> <?php echo get_post_meta(get_the_ID(), 'event_city', true); ?> - <?php echo get_post_meta(get_the_ID(), 'event_state', true); ?></p>
        <p><?php the_content(); ?></p>

        <a href="<?php echo get_post_meta(get_the_ID(), 'event_link', true); ?>" target="_blank">Saiba mais</a>

    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
