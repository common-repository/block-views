<?php

function block_views_below_php_version_notice() {
    if (current_user_can('activate_plugins')) {
        ?>
        <div class="notice notice-error">
            <p>
                <span class="dashicons dashicons-warning" style="color:#dc3232;"></span>
                <?php echo __('Your version of PHP is below the minimum version of PHP required by Block Views.', 'block-views'); ?>
                <?php echo __('Please contact your host and request that your version be upgraded to 5.6 or later.', 'block-views'); ?>
            </p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'block_views_below_php_version_notice');
