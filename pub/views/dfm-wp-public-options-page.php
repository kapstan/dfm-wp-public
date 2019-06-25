<?php
/**
 * Plugin admin menu page template.
 *
 * @since      1.0.0
 * @package    dfm-wp-public
 * @subpackage dfm-wp-public/pub/views/template-parts
 * @author     Ian Kaplan <ian.c.kaplan@protonmail.com>
 */

?>

<article class="container" id="plugin-settings">
	<header id="plugin-settings-header">
		<h1><?php echo esc_html( PLUGIN_FRIENDLY_NAME ); ?></h1>
	</header>
	<section id="plugin-settings-main">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="sports-tab" data-toggle="tab" href="#sports-content" role="tab" aria-controls="sports-content" aria-selected="true">Sports Content</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="animals-tab" data-toggle="tab" href="#animals-content" role="tab" aria-controls="animals-content" aria-selected="false">Animals Content</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="business-tab" data-toggle="tab" href="#business-content" role="tab" aria-controls="business-content" aria-selected="false">Business Content</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="entertainment-tab" data-toggle="tab" href="#entertainment-content" role="tab" aria-controls="entertainment-content" aria-selected="false">Entertainment Content</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="world-and-news-tab" data-toggle="tab" href="#world-and-news-content" role="tab" aria-controls="world-and-news-content" aria-selected="false">World and News Content</a>
			</li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content">
			<ul class="list-group tab-pane active" id="sports-content" role="tabpanel" aria-labelledby="sports-tab">
				<?php do_action( 'dfm-wp-public_render_content', 'sports', array( 'posts_per_page' => 25 ) ); ?>
			</ul>
			<ul class="list-group tab-pane" id="animals-content" role="tabpanel" aria-labelledby="animals-tab">
				<?php do_action( 'dfm-wp-public_render_content', 'animals', array( 'posts_per_page' => 10 ) ); ?>
			</ul>
			<ul class="list-group tab-pane" id="business-content" role="tabpanel" aria-labelledby="business-tab">
				<?php do_action( 'dfm-wp-public_render_content', 'business', array( 'posts_per_page' => 12 ) ); ?>
			</ul>
			<ul class="list-group tab-pane" id="entertainment-content" role="tabpanel" aria-labelledby="entertainment-tab">
				<?php do_action( 'dfm-wp-public_render_content', 'entertainment', array( 'posts_per_page' => 50 ) ); ?>
			</ul>
			<ul class="list-group tab-pane" id="world-and-news-content" role="tabpanel" aria-labelledby="world-and-news-tab">
				<?php do_action( 'dfm-wp-public_render_content', 'world-and-news', array( 'posts_per_page' => 100 ) ); ?>
			</ul>
		</div>
	</section>
</section>
