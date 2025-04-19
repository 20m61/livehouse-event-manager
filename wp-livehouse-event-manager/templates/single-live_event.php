get_header();
if ( have_posts() ): the_post(); ?>
  <article class="live-event-detail">
    <h1><?php the_title(); ?></h1>
    <?php if ( has_post_thumbnail() ): ?>
      <div class="event-thumbnail"><?php the_post_thumbnail('large'); ?></div>
    <?php endif; ?>
    <div class="event-meta">
      <p><strong><?php esc_html_e('開催日','wp-livehouse-event-manager'); ?>:</strong>
        <?php echo esc_html( get_post_meta(get_the_ID(),'event_date',true) ); ?></p>
      <p><strong><?php esc_html_e('開演時間','wp-livehouse-event-manager'); ?>:</strong>
        <?php echo esc_html( get_post_meta(get_the_ID(),'start_time',true) ); ?></p>
      <p><strong><?php esc_html_e('出演者','wp-livehouse-event-manager'); ?>:</strong>
        <?php echo esc_html( get_post_meta(get_the_ID(),'performer',true) ); ?></p>
      <p><strong><?php esc_html_e('ジャンル','wp-livehouse-event-manager'); ?>:</strong>
        <?php echo esc_html( wp_get_post_terms(get_the_ID(),'event_genre', ['fields'=>'names'])[0] ?? '' ); ?></p>
    </div>
    <div class="event-content"><?php the_content(); ?></div>
  </article>
<?php endif;
get_footer();
