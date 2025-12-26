<?php

/**
 * Template for displaying search forms in eooten
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 */

$eooten_unique_id = esc_attr(uniqid('search-form-')); ?>

<form action="<?php echo esc_url(home_url('/')); ?>" method="get" role="search" class="bdt-search bdt-search-default bdt-width-1-1">
    <span data-bdt-search-icon></span>
    <input id="<?php echo esc_attr($eooten_unique_id); ?>" name="s" placeholder="<?php esc_attr_e('Search...', 'eooten'); ?>" type="search" class="bdt-search-input">
</form>