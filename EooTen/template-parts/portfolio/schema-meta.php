<?php

/**
 * Template part for displaying posts
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/

 */
$eooten_categories = get_the_category();
$eooten_category   = '';

if (!empty($eooten_categories)) {
    $eooten_category = $eooten_categories[0]->name;
} ?>

<meta property="name" content="<?php echo esc_html(get_the_title()) ?>">
<meta property="author" typeof="Person" content="<?php echo esc_html(get_the_author()) ?>">
<meta property="dateModified" content="<?php echo get_the_modified_date('c') ?>">
<meta property="datePublished" content="<?php echo get_the_date('c') ?>">
<meta property="articleSection" content="<?php echo esc_html($eooten_category) ?>">