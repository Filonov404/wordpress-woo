<?php
/*
Template Name: favorite
*/

get_header();
?>



<?php
$favorite_id_array = favorite_id_array();
global $wp_query;
$save_wpq = $wp_query;
$args = array(
   'paged' => get_query_var('paged') ? absint(get_query_var('paged')) : 1,
   'post_type'   => 'post',
   'post__in'   => !empty($favorite_id_array) ? $favorite_id_array : array(0),
);
$wp_query = new WP_Query($args);
?>
<?php if ($wp_query->have_posts()) : ?>
   <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
      <div class="fv_<?php echo $post->ID; ?>">
         <div class="delete-favorite" data-post_id="<?php echo $post->ID; ?>" title="Delete from favorite">
            <img src="http://yoursite.com/link-to-your-icon.svg">Delete
         </div>
      </div>
      <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
   <?php endwhile; ?>
<?php else : ?>
1
    <div class="container">
        <h2 class="compire-title">В избранном пока ни чего нет</h2>
        <div class="compire-link-item">
            <a class="compire-link" href="/shop">Перейти</a> в магазин
        </div>
    </div>
    <style>
        .compire-title {
            padding-top: 20px;
            padding-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }
        .compire-link-item {
            text-align: center;
        }
        .compire-link {
            color: #08f600;
            transition: all .3s ease;
        }
        .compire-link:hover {
            color: #000;
            text-decoration: underline;
        }
    </style>
<?php endif; ?>
<?php wp_reset_postdata();  ?>
<?php
get_footer();
