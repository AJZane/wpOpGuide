<?php get_header(); 
	if ( is_user_logged_in() ){
		echo "<div class=\"row\">";
			include('flesh/paginate.php');
			$loop = new WP_Query( array( 
				'post_type' => 'opGuide'
				)
			);
			while ( $loop->have_posts() ) {
				$loop->the_post();
				echo '<a href="'.get_permalink().'">'.get_the_title().'</a><br/>';
				echo the_excerpt();								
			}//while
			wp_reset_query();	
			include('flesh/paginate.php');
		echo "</div>";
	}
	else{
		echo "<div class=\"hero-unit\">";
		echo apply_filters('the_content', get_page_by_path('about')->post_content);
		echo "</div>";
		echo "<div class=\"row\">";
		include('flesh/thumbnail-gallery.php');
		include('flesh/paginate.php');
		echo "</div><!--row-->";
	}
get_footer(); ?>