<?php
namespace RalfHortt\CustomPostTypeRetailers;

use Horttcore\CustomPostType\PostType;

/**
 * Service example
 */
class Retailer extends PostType
{
    protected $slug = 'retailer';

    public function getConfig(): array
    {
        return [
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => [
                'slug'       => _x('retailers', 'Post Type Slug', 'custom-post-type-retailers'),
                'with_front' => false,
            ],
            'capability_type' => 'post',
            'has_archive'     => true,
            'hierarchical'    => false,
            'menu_position'   => null,
            'menu_icon'       => 'dashicons-cart',
            'supports'        => [
                'title',
                'editor',
                'thumbnail',
                'page-attributes',
            ],
            'show_in_rest' => true,
        ];
    }

    public function getLabels(): array
    {
        return [
            'name'                  => _x('Retailers', 'post type general name', 'custom-post-type-retailers'),
            'singular_name'         => _x('Retailer', 'post type singular name', 'custom-post-type-retailers'),
            'add_new'               => _x('Add New', 'Retailer', 'custom-post-type-retailers'),
            'add_new_item'          => __('Add New Retailer', 'custom-post-type-retailers'),
            'edit_item'             => __('Edit Retailer', 'custom-post-type-retailers'),
            'new_item'              => __('New Retailer', 'custom-post-type-retailers'),
            'view_item'             => __('View Retailer', 'custom-post-type-retailers'),
            'view_items'            => __('View Retailers', 'custom-post-type-retailers'),
            'search_items'          => __('Search Retailers', 'custom-post-type-retailers'),
            'not_found'             => __('No Retailers found', 'custom-post-type-retailers'),
            'not_found_in_trash'    => __('No Retailers found in Trash', 'custom-post-type-retailers'),
            'parent_item_colon'     => __('Parent Retailer', 'custom-post-type-retailers'),
            'all_items'             => __('All Retailers', 'custom-post-type-retailers'),
            'archives'              => __('Retailer Archives', 'custom-post-type-retailers'),
            'attributes'            => __('Retailer Attributes', 'custom-post-type-retailers'),
            'insert_into_item'      => __('Insert into retailer', 'custom-post-type-retailers'),
            'uploaded_to_this_item' => __('Uploaded to this page', 'custom-post-type-retailers'),
            'featured_image'        => __('Logo', 'custom-post-type-retailers'),
            'set_featured_image'    => __('Set logo', 'custom-post-type-retailers'),
            'remove_featured_image' => __('Remove logo', 'custom-post-type-retailers'),
            'use_featured_image'    => __('Use as logo', 'custom-post-type-retailers'),
            'menu_name'             => _x('Retailers', 'post type general name', 'custom-post-type-retailers'),
            'filter_items_list'     => __('Retailers', 'custom-post-type-retailers'),
            'items_list_navigation' => __('Retailers', 'custom-post-type-retailers'),
            'items_list'            => __('Retailers', 'custom-post-type-retailers'),
        ];
    }

    public function getPostUpdateMessage(): array
    {
        return [
            'name'                  => _x('Retailers', 'post type general name', 'custom-post-type-retailers'),
            'singular_name'         => _x('Retailer', 'post type singular name', 'custom-post-type-retailers'),
            'add_new'               => _x('Add New', 'Retailer', 'custom-post-type-retailers'),
            'add_new_item'          => __('Add New Retailer', 'custom-post-type-retailers'),
            'edit_item'             => __('Edit Retailer', 'custom-post-type-retailers'),
            'new_item'              => __('New Retailer', 'custom-post-type-retailers'),
            'view_item'             => __('View Retailer', 'custom-post-type-retailers'),
            'view_items'            => __('View Retailers', 'custom-post-type-retailers'),
            'search_items'          => __('Search Retailers', 'custom-post-type-retailers'),
            'not_found'             => __('No Retailers found', 'custom-post-type-retailers'),
            'not_found_in_trash'    => __('No Retailers found in Trash', 'custom-post-type-retailers'),
            'parent_item_colon'     => __('Parent Retailer', 'custom-post-type-retailers'),
            'all_items'             => __('All Retailers', 'custom-post-type-retailers'),
            'archives'              => __('Retailer Archives', 'custom-post-type-retailers'),
            'attributes'            => __('Retailer Attributes', 'custom-post-type-retailers'),
            'insert_into_item'      => __('Insert into retailer', 'custom-post-type-retailers'),
            'uploaded_to_this_item' => __('Uploaded to this page', 'custom-post-type-retailers'),
            'featured_image'        => __('Logo', 'custom-post-type-retailers'),
            'set_featured_image'    => __('Set logo', 'custom-post-type-retailers'),
            'remove_featured_image' => __('Remove logo', 'custom-post-type-retailers'),
            'use_featured_image'    => __('Use as logo', 'custom-post-type-retailers'),
            'menu_name'             => _x('Retailers', 'post type general name', 'custom-post-type-retailers'),
            'filter_items_list'     => __('Retailers', 'custom-post-type-retailers'),
            'items_list_navigation' => __('Retailers', 'custom-post-type-retailers'),
            'items_list'            => __('Retailers', 'custom-post-type-retailers'),
        ];
    }

    /**
     * Update messages.
     *
     * @param WP_Post      $post     Post object
     * @param string       $postType Post type slug
     * @param WP_Post_Type $postType Post type slug
     *
     * @return array Update messages
     **/
    public function getPostUpdateMessages(\WP_Post $post, string $postType, \WP_Post_Type $postTypeObjects) : array
    {
        $messages = [
            0  => '', // Unused. Messages start at index 1.
            1  => __('Retailer updated.', 'custom-post-type-retailers'),
            2  => __('Custom field updated.'),
            3  => __('Custom field deleted.'),
            4  => __('Retailer updated.', 'custom-post-type-retailers'),
            5  => isset($_GET['revision']) ? sprintf(__('Retailer restored to revision from %s', 'custom-post-type-retailers'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
            6  => __('Retailer published.', 'custom-post-type-retailers'),
            7  => __('Retailer saved.', 'custom-post-type-retailers'),
            8  => __('Retailer submitted.', 'custom-post-type-retailers'),
            9  => sprintf(__('Retailer scheduled for: <strong>%1$s</strong>.', 'custom-post-type-retailers'), date_i18n(__('M j, Y @ G:i', 'custom-post-type-retailers'), strtotime($post->post_date))),
            10 => __('Retailer draft updated.', 'custom-post-type-retailers'),
        ];

        if (!$postTypeObjects->publicly_queryable) {
            return $messages;
        }

        $permalink = get_permalink($post->ID);
        $view_link = sprintf(' <a href="%s">%s</a>', esc_url($permalink), __('View retailer', 'custom-post-type-retailers'));
        $messages[1] .= $view_link;
        $messages[6] .= $view_link;
        $messages[9] .= $view_link;

        $preview_permalink = add_query_arg('preview', 'true', $permalink);
        $preview_link = sprintf(' <a target="_blank" href="%s">%s</a>', esc_url($preview_permalink), __('Preview retailer', 'custom-post-type-retailers'));
        $messages[8] .= $preview_link;
        $messages[10] .= $preview_link;

        return $messages;
    }
}
