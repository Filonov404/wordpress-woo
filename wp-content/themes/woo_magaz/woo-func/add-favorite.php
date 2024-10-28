<?php
//favorite posts array
function favorite_id_array()
{
    if (!empty($_COOKIE['favorite_post_ids'])) {
        return explode(',', $_COOKIE['favorite_post_ids']);
    } else {
        return array();
    }
}


//add to favorite function
function add_favorite()
{
    $post_id = (int)$_POST['post_id'];
    if (!empty($post_id)) {
        $new_post_id = array(
            $post_id
        );
        $post_ids = array_merge($new_post_id, favorite_id_array());
        $post_ids = array_diff($post_ids, array(
            ''
        ));
        $post_ids = array_unique($post_ids);
        setcookie('favorite_post_ids', implode(',', $post_ids), time() + 3600 * 24 * 365, '/');
        echo count($post_ids);
    }
    die();
}

add_action('wp_ajax_favorite', 'add_favorite');
add_action('wp_ajax_nopriv_favorite', 'add_favorite');


//delete from favorite function
function delete_favorite()
{
    $post_id = (int)$_POST['post_id'];
    if (!empty($post_id)) {
        $favorite_id_array = favorite_id_array();
        if (($delete_post_id = array_search($post_id, $favorite_id_array)) !== false) {
            unset($favorite_id_array[$delete_post_id]);
        }
        setcookie('favorite_post_ids', implode(',', $favorite_id_array), time() + 3600 * 24 * 30, '/');
        echo count($favorite_id_array);
    }
    die();
}

add_action('wp_ajax_delfavorite', 'delete_favorite');
add_action('wp_ajax_nopriv_delfavorite', 'delete_favorite');