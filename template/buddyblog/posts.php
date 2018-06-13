<?php
/**
 * This file is used for listing the posts on profile
 */
?>

<?php if ( buddyblogmusic_user_has_posted() ): ?>
<?php
    //let us build the post query
    if ( bp_is_my_profile() || is_super_admin() ) {
 		$status = 'any';
	} else {
		$status = 'publish';
	}
	
    $paged = bp_action_variable( 1 );
    $paged = $paged ? $paged : 1;
    
	$query_args = array(
		'author'        => bp_displayed_user_id(),
		'post_type'     => buddyblogmusic_get_posttype(),
		'post_status'   => $status,
		'paged'         => intval( $paged )
    );
	//do the query
    query_posts( $query_args );
	?>
    
	<?php if ( have_posts() ): ?>
		
		<?php while ( have_posts() ): the_post();
			global $post;
		?>

            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <div class="buddyblog-music-author-box">
                    <?php echo get_avatar( get_the_author_meta( 'user_email' ), '50' ); ?>
                    <p><?php printf( _x( 'by %s', 'Post written by...', 'buddyblogmusic' ), bp_core_get_userlink( $post->post_author ) ); ?></p>

                    <?php if ( is_sticky() ) : ?>
                        <span class="activity sticky-post"><?php _ex( 'Featured', 'Sticky post', 'buddyblogmusic' ); ?></span>
                    <?php endif; ?>
                </div>

                <div class="buddyblog-music-content">
                    
                    <?php if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail( get_the_ID() ) ):?>
                        
                        <div class="buddyblog-music-featured-image">
                            <?php  the_post_thumbnail();?>
                        </div>

                    <?php endif;?>

                    <h2 class="buddyblog-music-title"> <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddyblogmusic' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a> </h2>

                    <p class="buddyblog-music-date"><?php printf( __( '%1$s <span>in %2$s</span>', 'buddyblogmusic' ), get_the_date(), get_the_category_list( ', ' ) ); ?></p>

                    <div class="buddyblog-music-entry">

                        <?php the_content( __( 'Read the rest of this entry &rarr;', 'buddyblogmusic' ) ); ?>
                        <?php wp_link_pages( array( 'before' => '<div class="buddyblog-music-page-link"><p>' . __( 'Pages: ', 'buddyblogmusic' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
                    </div>

                    <p class="buddyblog-music-meta-data"><?php the_tags( '<span class="buddyblog-music-tags">' . __( 'Tags: ', 'buddyblogmusic' ), ', ', '</span>' ); ?> <span class="buddyblog-music-comments"><?php comments_popup_link( __( 'No Comments &#187;', 'buddyblogmusic' ), __( '1 Comment &#187;', 'buddyblogmusic' ), __( '% Comments &#187;', 'buddyblogmusic' ) ); ?></span></p>

                    <div class="buddyblog-music-actions">
                        <?php echo buddyblogmusic_get_post_publish_unpublish_link( get_the_ID() );?>
                        <?php echo buddyblogmusic_get_edit_link();?>
                        <?php echo buddyblogmusic_get_delete_link();?>
                    </div>     
                </div>

			</div>
                   
        <?php endwhile;?>
            <div class="buddyblog-music-pagination">
                <?php buddyblogmusic_paginate(); ?>
            </div>
    <?php else: ?>
            <p><?php _e( 'There are no posts by this user at the moment. Please check back later!', 'buddyblogmusic' );?></p>
    <?php endif; ?>

    <?php 
       wp_reset_postdata();
       wp_reset_query();
    ?>

<?php elseif ( bp_is_my_profile() && buddyblogmusic_user_can_post( get_current_user_id() ) ): ?>
    <p> <?php _e( "You haven't posted anything yet.", 'buddyblogmusic' );?> <a href="<?php echo buddyblogmusic_get_new_url();?>"> <?php _e( 'New Post', 'buddyblogmusic' );?></a></p>

<?php endif; ?>
