<?php
namespace RalfHortt\CustomPostTypeRetailers\MetaBoxes;

use Horttcore\MetaBoxes\MetaBox;

class Source extends MetaBox
{
    protected $identifier = 'source';
    protected $screen = ['retailer'];
    protected $priority = 'high';

    /**
     * Constructor
     **/
    public function __construct()
    {
        $this->name = __('Source', 'custom-post-type-retailers');
    }

    /**
     * Render meta box
     *
     * @param WP_Post $post Post object
     * @return void
     **/
    public function render(\WP_Post $post): void
    {
        ?>
		<table class="form-table">
            <tr>
                <th><label for="retailer-role"><?php _e('Role', 'custom-post-type-retailers'); ?></label></th>
                <td><input type="text" class="regular-text" name="retailer-role" id="retailer-role" value="<?= esc_attr(get_retailer_role($post->ID)) ?>"></td>
            </tr>
            <tr>
                <th><label for="retailer-company"><?php _e('Company', 'custom-post-type-retailers'); ?></label></th>
                <td><input type="text" class="regular-text" name="retailer-company" id="retailer-company" value="<?= esc_attr(get_retailer_role($post->ID)) ?>"></td>
            </tr>
        </table>
		<?php
    }

    /**
     * Save meta
     *
     * @param int $postId Post ID
     * @return void
     **/
    public function save(int $postId): void
    {
        update_post_meta($postId, 'role', sanitize_text_field($_POST['retailer-role']));
        update_post_meta($postId, 'company', sanitize_text_field($_POST['retailer-company']));
    }
}
