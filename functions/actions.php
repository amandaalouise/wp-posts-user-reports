<?php

add_action('wp_ajax_nopriv_reportpost', 'reportPost');
add_action('wp_ajax_reportpost', 'reportPost');
function reportPost()
{
    global $wpdb;
    $post_type = $_POST['post_type'];

    $val = $wpdb->get_results("
		SELECT *
		FROM $wpdb->posts
		WHERE $wpdb->posts.post_type = '" . $post_type . "'
		AND $wpdb->posts.post_status = 'publish'
		", ARRAY_A);

    echo json_encode($val);

    die();
}

add_action('wp_ajax_nopriv_reportuser', 'reportUser');
add_action('wp_ajax_reportuser', 'reportUser');
function reportUser()
{

    global $wpdb;
    $tipo_user = $_POST['tipo_user'];

    $val = $wpdb->get_results("
		SELECT *
		FROM wp_users INNER JOIN wp_usermeta
		ON wp_users.ID = wp_usermeta.user_id
		WHERE wp_usermeta.meta_key = 'wp_capabilities'
		AND wp_usermeta.meta_value LIKE '%" . $tipo_user . "%'
		", ARRAY_A);

    echo json_encode($val);

    die();
}

add_action('wp_ajax_nopriv_loadfields', 'loadFields');
add_action('wp_ajax_loadfields', 'loadFields');
function loadFields()
{

    $post_id = $_POST['post_id'];

    $custommeta = array_keys(get_post_meta($post_id));
    $metadata = get_post($post_id);
    $keys = array_keys(get_object_vars($metadata));
    $meta = array_merge($keys, $custommeta);

    if (class_exists('acf')) {

        $acf = get_field_objects($post_id);

        if ($acf) {
            $acf_fields = array_keys($acf);

            array_merge($meta, $acf_fields);
        }

    }
    echo json_encode($meta);

    die();

}

add_action('wp_ajax_nopriv_getFieldsData', 'getFieldsData');
add_action('wp_ajax_getFieldsData', 'getFieldsData');
function getFieldsData()
{

    $post_type = $_POST['post_type'];

    $posts = getPosts($post_type);

    $post_fields = $_POST['post_fields'];

    $returnedData = [];

    global $post;

    foreach ($posts as $post) {

        $genericArray;

        $post_id = (int) $post->ID;

        foreach ($post_fields as $field) {
            if (metadata_exists($post_type, $post_id, $field)) {
                $genericArray[$field] = get_post_meta($post_id, $field);
            } else {
                if ($field == 'post_author') {
                    $author_id = get_post_field($field, $post_id);
                    $user = get_userdata($author_id);
                    $genericArray[$field] = $user->display_name;
                } else {
                    $genericArray[$field] = get_post_field($field, $post_id);
                }
            }

        }

        array_push($returnedData, $genericArray);

    }

    echo json_encode($returnedData);

    die();
}

function getPosts($post_type)
{
    global $wpdb;

    $val = $wpdb->get_results("
	SELECT *
	FROM $wpdb->posts
	WHERE $wpdb->posts.post_type = '" . $post_type . "'
	AND $wpdb->posts.post_status = 'publish'
	", OBJECT);

    return $val;
}

function getUsers($user_role)
{
    global $wpdb;

    $val = $wpdb->get_results("
		SELECT *
		FROM wp_users INNER JOIN wp_usermeta
		ON wp_users.ID = wp_usermeta.user_id
		WHERE wp_usermeta.meta_key = 'wp_capabilities'
		AND wp_usermeta.meta_value LIKE '%" . $tipo_user . "%'
		", ARRAY_A);

    return $val;

}

add_action('wp_ajax_nopriv_getUserFields', 'getUserFields');
add_action('wp_ajax_getUserFields', 'getUserFields');
function getUserFields()
{

    $user_role = $_POST['user_role'];
    $users = getUsers($user_role);

    $user_id = $users[0]['ID'];

    $usermeta = array_keys(get_user_meta($user_id));

    $user_fields = get_userdata($user_id);
    $obj_vars = [];

    $obj_vars = array_keys(get_object_vars($user_fields->data));

    $mergedArray = array_merge($obj_vars, $usermeta);

    echo json_encode($mergedArray);

    die();
}

add_action('wp_ajax_nopriv_getUserFieldsData', 'getUserFieldsData');
add_action('wp_ajax_getUserFieldsData', 'getUserFieldsData');
function getUserFieldsData()
{

    $user_role = $_POST['user_role'];

    $users = getUsers($user_role);

    $user_fields = $_POST['user_fields'];

    $returnedData = [];

    foreach ($users as $user) {

        $genericArray;

        $user_id = (int) $user['ID'];
        $user_obj = get_userdata($user_id);

        foreach ($user_fields as $field) {
            if (metadata_exists('user', $user_id, $field)) {
                $genericArray[$field] = get_user_meta($user_id, $field);
            } else {
                $genericArray[$field] = $user_obj->{$field};
            }

        }

        array_push($returnedData, $genericArray);

    }

    echo json_encode($returnedData);

    die();
}