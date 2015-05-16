<?php global $post; ?>
<form action="<?php echo home_url( '/' ); ?>" method="get" class="searchform form-inline">
	<fieldset class="row">
		<?php
		// get search type
		$search_type = sp_get_option( 'search_type' );
		$type = '';
		$text = '';

		switch( $search_type ) {
			case 'all' :
				$type = '';
				$text = __( 'Search All', 'sp-theme' );

				break;

			case 'blog-only' :
				$type = 'post';
				$text = __( 'Search Blog Posts', 'sp-theme' );

				break;

			case 'products-only' :
				if ( sp_woo_exists() )
					$type = 'product';

				$text = __( 'Search Products', 'sp-theme' );

				break;
			case 'smart-search' :
				if ( sp_woo_exists() ) { 
					if ( get_post_type( $post ) == 'post' ) {
						$type = 'post';
						$text = __( 'Search Posts', 'sp-theme' );
					} else {
						$type = 'product';
						$text = __( 'Search Products', 'sp-theme' );
					}
				} else {
					$type = 'post';
					$text = __( 'Search Posts', 'sp-theme' );
				}

				break;      	
		}
		?>

		<div class="form-group">
			<input type="text" name="s" class="search search-query form-control" value="" placeholder="<?php echo esc_attr( $text ); ?>" />
			<button type="submit" class="search-button icon-search" title="<?php esc_attr_e( 'Search', 'sp-theme' ); ?>"></button>
		</div><!--close .form-group-->
		<input type="hidden" value="<?php echo esc_attr( $type ); ?>" name="post_type" />
	</fieldset>
</form>
