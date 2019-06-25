<?php
/**
 * The template used for messaging the user
 * that no content was found for their query.
 *
 * @since      1.0.0
 * @package    dfm-wp-public
 * @subpackage dfm-wp-public/pub/views/template-parts
 * @author     Ian Kaplan <ian.c.kaplan@protonmail.com>
 */

?>

<li class="list-group-item">
	<p class="lead">There are no <?php echo apply_filters( 'dfm-wp-public_capitalize_words', $category_slug ); ?> posts. Check back later.</p>
</li>
