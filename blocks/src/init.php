<?php if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', function () { // phpcs:ignore

	// Register block styles for both frontend + backend.
	wp_register_style(
		'block-views-block-style-css', // Handle.
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
		array( 'wp-editor' ), // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
	);

	// Register block editor script for backend.
	wp_register_script(
		'block-views-block-js', // Handle.
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), // Dependencies, defined above.
		null, // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
		true // Enqueue the script in the footer.
	);

	// Register block editor styles for backend.
	wp_register_style(
		'block-views-editor-css', // Handle.
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
	);

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
	wp_localize_script(
		'block-views-block-js',
		'blockViews', // Array containing dynamic data for a JS Global.
		[
			'pluginDirPath' => plugin_dir_path( __DIR__ ),
			'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
			// Add more data here that you want to access from `cgbGlobal` object.
		]
	);

    register_block_type( 'block-views/post-view', array(
		'style' => 'block-views-block-style-css',
		'editor_script' => 'block-views-block-js',
		'editor_style' => 'block-views-editor-css',
        'render_callback' => function($attributes, $content) {
            global $post;

            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'post__not_in' => [$post->ID],
            );
            if((isset($attributes['postsPerPage']))) {
                $args['posts_per_page'] = $attributes['postsPerPage'];
            }
            $query = new WP_Query($args);
    
            ob_start();
            while ($query->have_posts()) {
                $query->the_post();
                echo do_shortcode($content);
            }
            wp_reset_query();

            echo '
                <div style="display:flex;justify-content:space-between;">
                    <div style="text-align:left;"><a href="#">Previous</a></div>
                    <div style="text-align:right;"><a href="#">Next</a></div>
                </div>
            ';

            return ob_get_clean();
        }
    ) );

    register_block_type( 'block-views/post-meta', array(
		'style' => 'block-views-block-style-css',
		'editor_script' => 'block-views-block-js',
		'editor_style' => 'block-views-editor-css',
        'render_callback' => function($attributes, $content) {
            if(!isset($attributes['postmeta'])) return;
            $alignment = (isset($attributes['alignment'])) ? $attributes['alignment'] : 'left';
            $post = get_post(1);
            $postmeta = $attributes['postmeta'];
            $usermeta = (isset($attributes['usermeta'])) ? $attributes['usermeta'] : '';

            return "<div style='text-align:$alignment;'>[block_views_data postmeta='$postmeta' usermeta='$usermeta']</div>";
        }
    ) );
} );
