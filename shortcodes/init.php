<?php

add_action('init', function () {

    add_shortcode('block_views_data', function ($args) {
        global $post;

        extract(wp_parse_args($args, [
            'postmeta' => '',
            'usermeta' => '',
        ]));

        if (!$postmeta) {
            return;
        }

        switch ($postmeta) {
            case 'post_content':
                return apply_filters('the_content', $post->post_content);
            case 'post_excerpt':
                return ($post->post_excerpt) ?: wp_trim_excerpt($post->post_content);
            case 'post_author':
                $usermeta = ($usermeta) ?: 'user_login';
                $author = get_user_by('id', $post->post_author);
                return $author->$usermeta;
            default:
                return $post->{$postmeta};
        }
    });
});
