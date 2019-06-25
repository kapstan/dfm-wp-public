<?php
/**
 * The template used for rendering looped posts.
 *
 * @since      1.0.0
 * @package    dfm-wp-public
 * @subpackage dfm-wp-public/pub/views/template-parts
 * @author     Ian Kaplan <ian.c.kaplan@protonmail.com>
 */

?>

<li class="list-group-item">
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		<small><?php the_title(); ?></small>
	</a>
</li>
