get_header();
?>
<main class="live-event-archive">
    <h1><?php post_type_archive_title(); ?></h1>
    <?php if (have_posts()): ?>
        <ul class="live-events">
            <?php while (have_posts()): the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <span class="date"><?php echo esc_html(get_post_meta(get_the_ID(), 'event_date', true)); ?></span>
                </li>
            <?php endwhile; ?>
        </ul>
        <?php the_posts_pagination(); ?>
    <?php else: ?>
        <p><?php esc_html_e('イベントはまだありません。', 'wp-livehouse-event-manager'); ?></p>
    <?php endif; ?>
</main>
<?php
get_footer();
