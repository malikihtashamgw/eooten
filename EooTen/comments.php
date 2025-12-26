<?php

/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @package eooten
 * @since 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

/**
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}

?>
<div id="comments" class="bdt-container bdt-container-small">

    <?php if (have_comments()) : // Check if there are any comments.
    ?>

        <h3 class="bdt-heading-bullet bdt-margin-bottom">
            <?php
            $eooten_comments_title = apply_filters('eooten_comment_form_title', sprintf(esc_html(_nx('%1$s thought on ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'eooten')), number_format_i18n(get_comments_number()), get_the_title()));
            echo esc_html($eooten_comments_title);
            ?>
        </h3>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through?
        ?>
            <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
                <h4 class="screen-reader-text"><?php esc_html_e('Comment navigation', 'eooten') ?></h4>
                <ul class="bdt-pagination bdt-flex-between">
                    <li class="nav-previous"><span data-bdt-pagination-previous></span><?php previous_comments_link(esc_html__('Older Comments', 'eooten')) ?></li>
                    <li class="nav-next"><?php next_comments_link(esc_html__('Newer Comments', 'eooten')) ?> <span data-bdt-pagination-next></span></li>
                </ul>
            </nav>
        <?php endif; // Check for comment navigation.
        ?>

        <ul class="bdt-comment-list">
            <?php wp_list_comments('type=comment&callback=eooten_comment') ?>
        </ul>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through?
        ?>
            <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
                <h4 class="screen-reader-text"><?php esc_html_e('Comment navigation', 'eooten') ?></h4>
                <ul class="bdt-pagination bdt-flex-between">
                    <li class="nav-previous"><span data-bdt-pagination-previous></span> <?php previous_comments_link(esc_html__('Older Comments', 'eooten')) ?></li>
                    <li class="nav-next"><?php next_comments_link(esc_html__('Newer Comments', 'eooten')) ?> <span data-bdt-pagination-next></span></li>
                </ul>
            </nav>
        <?php endif; // Check for comment navigation.
        ?>

        <hr class="bdt-margin-large-top bdt-margin-large-bottom">
    <?php endif; // Check for have_comments().
    ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : // If comments are closed and there are comments, let's leave a little note, shall we?
    ?>
        <p class="bdt-margin-medium bdt-text-danger"><?php esc_html_e('Comments are closed.', 'eooten') ?></p>
    <?php endif ?>

    <?php

    $eooten_commenter     = wp_get_current_commenter();
    $eooten_req           = get_option('require_name_email');
    $eooten_aria_req      = ($eooten_req ? " aria-required='true'" : '');
    $eooten_required_text = '';

    $eooten_fields = array(

        'author' =>
        '<p class="comment-form-author"><label class="bdt-form-label" for="author">' . esc_html__('Name', 'eooten') . '</label> ' .
            ($eooten_req ? '<span class="required">*</span>' : '') .
            '<input class="bdt-input" id="author" name="author" type="text" value="' . esc_attr($eooten_commenter['comment_author']) .
            '" size="30"' . $eooten_aria_req . ' /></p>',

        'email' =>
        '<p class="comment-form-email"><label class="bdt-form-label" for="email">' . esc_html__('Email', 'eooten') . '</label> ' .
            ($eooten_req ? '<span class="required">*</span>' : '') .
            '<input class="bdt-input" id="email" name="email" type="text" value="' . esc_attr($eooten_commenter['comment_author_email']) .
            '" size="30"' . $eooten_aria_req . ' /></p>',

        'url' =>
        '<p class="comment-form-url"><label class="bdt-form-label" for="url">' . esc_html__('Website', 'eooten') . '</label>' .
            '<input class="bdt-input" id="url" name="url" type="text" value="' . esc_attr($eooten_commenter['comment_author_url']) .
            '" size="30" /></p>',
    );

    $eooten_args = array(
        'id_form'           => 'commentform',
        'class_form'        => 'comment-form',
        'id_submit'         => 'submit',
        'class_submit'      => 'bdt-button bdt-button-primary bdt-margin-top submit bdt-border-rounded',
        'name_submit'       => 'submit',
        'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title bdt-heading-bullet bdt-margin-bottom">',
        'title_reply'       => esc_html__('Leave a Reply', 'eooten'),
        'title_reply_to'    => esc_html__('Leave a Reply to %s', 'eooten'),
        'cancel_reply_link' => esc_html__('Cancel Reply', 'eooten'),
        'label_submit'      => esc_html__('Post Comment', 'eooten'),
        'format'            => 'xhtml',

        'comment_field' =>  '<p class="comment-form-comment"><label class="bdt-form-label" for="comment">' . _x('Comment', 'noun', 'eooten') .
            '</label><textarea class="bdt-textarea" id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
            '</textarea></p>',

        'must_log_in' => '<p class="must-log-in">' .
            sprintf(
                __('You must be <a href="%s">logged in</a> to post a comment.', 'eooten'),
                wp_login_url(apply_filters('eooten_the_permalink', get_permalink()))
            ) . '</p>',

        'logged_in_as' => '<p class="logged-in-as">' .
            sprintf(
                __('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'eooten'),
                admin_url('profile.php'),
                $user_identity,
                wp_logout_url(apply_filters('eooten_the_permalink', get_permalink()))
            ) . '</p>',

        'comment_notes_before' => '<p class="comment-notes">' .
            esc_html__('Your email address will not be published.', 'eooten') . ($eooten_req ? $eooten_required_text : '') .
            '</p>',

        'fields' => apply_filters('eooten_comment_form_default_fields', $eooten_fields),
    );

    comment_form($eooten_args); ?>
</div>