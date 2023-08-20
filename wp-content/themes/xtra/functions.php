<?php
add_action('after_setup_theme',function(){
    // Supported
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
});


// Post Type
function custom_post_type(){
    // Team Member Area
    register_post_type('tasks',array(
            'labels' => array(
                'name' => 'Task Post',
                'add_new' => 'Add New Post',
                'add_new_item' => 'Add Post Item',
                'edit_item' => 'Edit Post Item',
                'featured_image' => 'Task Post Image',
                'set_featured_image' => 'Set Task Post Image',
                'remove_featured_image' => 'Remove Task Post Image',
                'use_featured_image' => 'Use Task Post Image',
            ),
            'public' => true,
            'supports' => array('title','editor','thumbnail'),
            'menu_icon'   => 'dashicons-groups',
    ));
   }
add_action('init','custom_post_type');

// the ajax function
add_action('wp_ajax_data_fetch', 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch', 'data_fetch');

function data_fetch(){



    $search_term = esc_attr($_POST['keyword']);
    
    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'tasks',
        's' => $search_term,
        'orderby' => 'title',
        'order' => 'ASC',
        'fields' => 'ids'
    );
    $query = new WP_Query($args);
    
    if ($query->have_posts()) :
        echo '<ul>';
        while ($query->have_posts()) : $query->the_post(); ?>
            <li><?php the_title(); ?></li>
        <?php endwhile;
        echo '</ul>';
        wp_reset_postdata();

    endif;

    die();
}
?>
