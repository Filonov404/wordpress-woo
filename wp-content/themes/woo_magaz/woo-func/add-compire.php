<?php
//compire posts array
function compire_id_array()
{
    if (!empty($_COOKIE['compire_post_ids'])) {
        return explode(',', $_COOKIE['compire_post_ids']);
    } else {
        return array();
    }
}


//add to favorite function
function add_compire()
{
    $post_id = (int)$_POST['post_id'];
    if (!empty($post_id)) {
        $new_post_id = array(
            $post_id
        );
        $post_ids = array_merge($new_post_id, compire_id_array());
        $post_ids = array_diff($post_ids, array(
            ''
        ));
        $post_ids = array_unique($post_ids);
        setcookie('compire_post_ids', implode(',', $post_ids), time() + 3600 * 24 * 365, '/');
        echo count($post_ids);
    }
    die();
}

add_action('wp_ajax_compire', 'add_compire');
add_action('wp_ajax_nopriv_compire', 'add_compire');


//delete from favorite function
function delete_compire()
{
    $post_id = (int)$_POST['post_id'];
    if (!empty($post_id)) {
        $favorite_id_array = compire_id_array();
        if (($delete_post_id = array_search($post_id, $favorite_id_array)) !== false) {
            unset($favorite_id_array[$delete_post_id]);
        }
        setcookie('compire_post_ids', implode(',', $favorite_id_array), time() + 3600 * 24 * 30, '/');
        echo count($favorite_id_array);
    }
    die();
}

add_action('wp_ajax_delcompire', 'delete_compire');
add_action('wp_ajax_nopriv_delcompire', 'delete_compire');