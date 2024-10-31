<?php
/**
 * Widget API: Recent Post Slider With Widget
 *
 * @package recent-post-slider-with-widget
 * @since 1.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
function rpsw_recent_posts_widget() {
    register_widget( 'Rpsw_Recent_Posts_Widget' );
}

//  Action For register Post widget
add_action( 'widgets_init', 'rpsw_recent_posts_widget' );

/**
 * Recent posts widget class.
 */
class Rpsw_Recent_Posts_Widget extends WP_Widget {
	
	/**
	 * Default post widget options.
	 *
	 * @var Post array
	 */
	protected $default_value;

	/**
	 * Widget setup.
	 */
	public function __construct() {

		$widget_rpsw = array('classname' => 'rpsw-recent-post-widget', 'description' => __('Displayed recent Post items with multiple layouts and templates.', 'recent-post-slider-widget') );
        parent::__construct( 'rpsw_rpsw', __('Recent Post Slider and Widget', 'recent-post-slider-widget'), $widget_rpsw );

		$this->default_value = array(
			'title'    				 => __( 'Recent Posts', 'recent-post-slider-widget' ),
			'category'  			 => 0,
			'number'    			 => 5,
			'show_date' 			 => true,
			'show_cate' 			 => false,
			'show_excerpt' 			 => false,
			'show_author' 			 => false,
			"content_words_limit" 	=> '50',
			'order'       			 => 'DESC',
			'order_by'    			 => 'date',
			'template'      		 => 'template-1', 			
		);
	}

	/**
	 * Update the widget settings.
	 *
	 * @param array $new_value New widget value.
	 * @param array $old_value Old widget value.
	 *
	 * @return array
	 */
	public function update( $new_value, $old_value ) {
		$value = $old_value;

		$value['title']  			= sanitize_text_field( $new_value['title'] );
		$value['category']   		= $new_value['category'];		
		$value['number'] 			= absint( $new_value['number'] );
		$value['show_date']			= !empty($new_value['show_date']) ? 1 : 0;
        $value['show_cate']			= !empty($new_value['show_cate']) ? 1 : 0;
		$value['show_author']		= !empty($new_value['show_author']) ? 1 : 10;
		$value['content_words_limit']		= !empty($new_value['content_words_limit']) ? $new_value['content_words_limit'] : 10;
        $value['show_excerpt']		= !empty($new_value['show_excerpt']) ? 1 : 0;
		$value['order']  			= sanitize_text_field( $new_value['order'] );
		$value['order_by']  			= sanitize_text_field( $new_value['order_by'] );
		$value['template']   		= $new_value['template'];		

		return $value;
	}

	/**
	 * Widget form.
	 *
	 * @param array $value Widget value.
	 *
	 * @return void
	 */
	public function form( $value ) {

		$value = wp_parse_args( $value, $this->default_value ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title', 'recent-post-slider-widget' ); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo rpsw_esc_attr( $value['title'] ); ?>" />
		</p>

		 <!-- Category -->
        <p>
            <label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Category', 'recent-post-slider-widget' ); ?>:</label>
            <?php
                $dropdown_args = array(
                                    'taxonomy'          => 'category',
                                    'class'             => 'widefat',
                                    'show_option_all'   => __( 'All', 'recent-post-slider-widget' ),
                                    'id'                => $this->get_field_id( 'category' ),
                                    'name'              => $this->get_field_name( 'category' ),
                                    'selected'          => $value['category']
                                );
                wp_dropdown_categories( $dropdown_args );
            ?>
        </p>        

        <p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of posts to show', 'recent-post-slider-widget' ); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo absint( $value['number'] ); ?>" size="3" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'content_words_limit' ); ?>"><?php esc_html_e( 'Content Words Limit', 'recent-post-slider-widget' ); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'content_words_limit' ); ?>" name="<?php echo $this->get_field_name('content_words_limit'); ?>" value="<?php  echo absint( $value['content_words_limit'] ); ?>" size="3" />
		</p>

        <p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php esc_html_e( 'Order', 'recent-post-slider-widget' ); ?></label>
			<select class="widefat"  id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
				<option value="DESC" <?php selected( $value['order'], 'DESC' ); ?> ><?php esc_html_e( 'Descending', 'recent-post-slider-widget' ); ?></option>
				<option value="ASC" <?php selected( $value['order'], 'ASC' ); ?> ><?php esc_html_e( 'Ascending', 'recent-post-slider-widget' ); ?></option>
			</select>	
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'order_by' ); ?>"><?php esc_html_e( 'Order By', 'recent-post-slider-widget' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'order_by' ); ?>" name="<?php echo $this->get_field_name( 'order_by' ); ?>">
				<option value="ID" <?php selected( $value['order_by'], 'ID' ); ?> ><?php esc_html_e( 'Post ID', 'recent-post-slider-widget' ); ?></option>
				<option value="author" <?php selected( $value['order_by'], 'author' ); ?> ><?php esc_html_e( 'Author', 'recent-post-slider-widget' ); ?></option>
				<option value="title" <?php selected( $value['order_by'], 'title' ); ?> ><?php esc_html_e( 'Title', 'recent-post-slider-widget' ); ?></option>
				<option value="date" <?php selected( $value['order_by'], 'date' ); ?> ><?php esc_html_e( 'Date', 'recent-post-slider-widget' ); ?></option>
				<option value="rand" <?php selected( $value['order_by'], 'rand' ); ?> ><?php esc_html_e( 'Rand', 'recent-post-slider-widget' ); ?></option>
			</select>
			
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'template' ); ?>"><?php esc_html_e( 'Select template', 'recent-post-slider-widget' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'template' ); ?>" name="<?php echo $this->get_field_name( 'template' ); ?>">
				<option value="template-1" <?php selected( $value['template'], 'template-1' ); ?> ><?php esc_html_e( 'template-1', 'recent-post-slider-widget' ); ?></option>
				<option value="template-2" <?php selected( $value['template'], 'template-2' ); ?> ><?php esc_html_e( 'template-2', 'recent-post-slider-widget' ); ?></option>
				<option value="template-3" <?php selected( $value['template'], 'template-3' ); ?> ><?php esc_html_e( 'template-3', 'recent-post-slider-widget' ); ?></option>
			</select>	
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $value['show_cate'] ); ?> id="<?php echo $this->get_field_id( 'show_cate' ); ?>" name="<?php echo $this->get_field_name( 'show_cate' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_cate' ); ?>"><?php esc_html_e( 'Show Post Category?', 'recent-post-slider-widget' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $value['show_date'] ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php esc_html_e( 'Show Post Date?', 'recent-post-slider-widget' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $value['show_author'] ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_author' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_author' ); ?>"><?php esc_html_e( 'show Post Author?', 'recent-post-slider-widget' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $value['show_excerpt'] ); ?> id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"><?php esc_html_e( 'Show Content?', 'recent-post-slider-widget' ); ?></label>
		</p>

<?php
	}

	/**
	 * How to display the widget on the screen.
	 *
	 * @param array $args     Widget parameters.
	 * @param array $value Widget value.
	 */
	public function widget( $args, $value ) {
		
		$value = wp_parse_args( (array) $value, $this->default_value );
		extract($args, EXTR_SKIP);

        $title = apply_filters( 'widget_title', isset( $value['title'] ) ? $value['title'] : __( 'Recent Posts', 'recent-post-slider-widget' ), $value, $this->id_base );
        $category           = $value['category'];
        $num_items          = $value['number'];
        $show_date          = $value['show_date'];
        $show_category      = $value['show_cate'];
		$order      		= $value['order'];
		$order_by      		= $value['order_by'];
		$template      		= $value['template'];
		$show_excerpt      	= $value['show_excerpt'];
		$show_author      	= $value['show_author'];
		$words_limit      	= $value['content_words_limit'];

		// Taking some globals
        global $post;


        $post_args = array(
			'posts_per_page'      	=> $num_items,
			'post_type'             => 'post',
			'post_status'           => array( 'publish' ),
			'orderby'				=> $order_by,
			'order'                 => $order,
			'ignore_sticky_posts' 	=> true,
		);

		// Category Parameter
        if( !empty($category) ) {
            $post_args['tax_query'] = array(
                                        array(
                                            'taxonomy'  => 'category',
                                            'field'     => 'term_id',
                                            'terms'     => $category
                                    ));
        }

		$query = new WP_Query($post_args);
		if ( ! $query->have_posts() ) {
			return;
		}
		// Start Widget Output
        echo $before_widget;

		if ( $title ) {
            echo $before_title . $title . $after_title;
        }
		$i = 1;
?>
		<div class="rpsw-post-widget rpsw-widget-<?php echo $template; ?>">
			<?php while ( $query->have_posts() ) : $query->the_post();
				 $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
				 $allterms = get_the_terms( $post->ID, 'category' );
				$cat_links = array();
                if($allterms) {
                    foreach ( $allterms as $term ) {
                        $term_link = get_term_link( $term );
                        $cat_links[] = '<a href="' . esc_url( $term_link ) . '">'.$term->name.'</a>';
                    }
                }
                $cate_name = join( "  ", $cat_links );
            ?>
				<div class="rpsw-recent-post rpsw-recent-post-<?php echo $i; ?>">
					<?php if( $template == 'template-1') { ?>
						
						<div class="rpsw-recent-post-image wp-cell-6 wpcell">               
                           <a href="<?php the_permalink(); ?>"><img src="<?php echo $feat_image ?>"></a>
                           
						</div>

							<div class="rpsw-post-content wp-cell-6 wpcell">
						
						<h4 class="rpsw-post-title">
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</h4>
						<?php if ( $show_category ) : ?>
							 <div class="rpsw-post-categories"> <?php echo $cate_name; ?></div>
						<?php endif; ?>
						<?php if ( $show_date ) : ?>
							<span class="rpsw-post-date"><i class="fa fa-calendar" aria-hidden="true"></i><?php echo get_the_date(); ?></span> 	<?php if ( $show_date && $show_author) { ?> <?php } ?>
						<?php endif; ?>
						<?php if ( $show_author ) : ?>
							<span class="rpsw-post-author"><i class="fa fa-user" aria-hidden="true"></i><?php echo get_the_author(); ?></span>
						<?php endif; ?>
						<?php if($show_excerpt) {  $excerpt = strip_shortcodes(strip_tags(get_the_content())); ?>
						<p class="rpsw-excerpt"><?php echo rpsw_limit_words($excerpt,$words_limit); ?></p>
						<?php } ?>
					</div>					
			

						<?php } else { ?>

							<div class="rpsw-recent-post-image">
							<a href="<?php the_permalink(); ?>"><img src="<?php echo $feat_image ?>"></a>					 
						

						<div class="rpsw-post-content">						
						<h4 class="rpsw-post-title">
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</h4>
						<?php if ( $show_category ) : ?>
							 <div class="rpsw-post-categories"> <?php echo $cate_name; ?></div>
						<?php endif; ?>
						<?php if ( $show_date ) : ?>
							<span class="rpsw-post-date"><i class="fa fa-calendar" aria-hidden="true"></i><?php echo get_the_date(); ?></span> 	<?php if ( $show_date && $show_author) { ?> <?php } ?>
						<?php endif; ?>
						<?php if ( $show_author ) : ?>
							<span class="rpsw-post-author"><i class="fa fa-user" aria-hidden="true"></i><?php echo get_the_author(); ?></span>
						<?php endif; ?>
						<?php if($show_excerpt) {  $excerpt = strip_shortcodes(strip_tags(get_the_content())); ?>
						<p class="rpsw-excerpt"><?php echo rpsw_limit_words($excerpt,$words_limit); ?></p>
						<?php } ?>
					
					</div>
					</div>
					
				<?php } ?>
				</div>
			<?php $i++;

			endwhile; ?>
		</div>

<?php
		wp_reset_postdata(); // Reset WP Query

        echo $after_widget;
	}
}