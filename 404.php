<?php get_header(); ?>
	<header class="page-header">
		<div class="container">
			<h1 class="entry-title"><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'sp-theme' ); ?></h1>
		</div><!--close .container-->
	</header>

	<div class="container main-container">
		
		<?php do_action( 'sp_404_layout_before_content_row' ); ?>

		<div class="row">
			<div class="<?php echo sp_column_css( '', '', '', '5' ); ?>">
				<p class="fourofour">404</p>
			</div><!--close .column-->

			<div id="primary" class="site-content <?php echo sp_column_css( '', '', '', '6', '', '', '1' ); ?>">
				<div id="content" role="main">

					<article id="post-0" class="post error404 no-results not-found">

						<div class="entry-content">
							<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'sp-theme' ); ?></p>
							<?php get_search_form(); ?>
						</div><!-- .entry-content -->
					</article><!-- #post-0 -->

				</div><!-- #content -->
			</div><!-- #primary -->
		</div><!--close. row-->

		<?php do_action( 'sp_404_layout_after_content_row' ); ?>

	</div><!--close . container-->
<?php get_footer(); ?>