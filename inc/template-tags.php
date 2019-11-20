<?php
/**
 * Get retailer company
 *
 * @param int $postId Post ID
 * @return string Company
 **/
function get_retailer_company(int $postId = null): string
{
    $postId = (null != $postId) ? $postId : get_the_ID();
    return get_post_meta($postId, 'company', true);
}



/**
 * Get retailer role
 *
 * @param int $postId Post ID
 * @return string Role
 **/
function get_retailer_role(int $postId = null): string
{
    $postId = (null != $postId) ? $postId : get_the_ID();
    return get_post_meta($postId, 'role', true);
}


/**
 * Get retailer meta
 *
 * @param string $before Before output
 * @param string $after After output
 * @param int $postId Post ID
 * @return void
 **/
function the_retailer_company(string $before = '', string $after = '', int $postId = null): void
{
    $postId = $postId ?? get_the_ID();
    $company = get_retailer_company($postId);
    if (!$company) {
        return;
    }
    
    echo $before . $company . $after;
}


/**
 * Get retailer meta
 *
 * @param string $before Before output
 * @param string $after After output
 * @param int $postId Post ID
 * @return void
 **/
function the_retailer_role(string $before = '', string $after = '', int $postId = null): void
{
    $postId = $postId ?? get_the_ID();
    $role = get_retailer_role($postId);
    if (!$role) {
        return;
    }
    
    echo $before . $role . $after;
}
