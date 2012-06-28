<?php
/**
 * Extension functions for the theme
 *
 * Available theme extensions
 *
 * @package tiga
 * @since tiga 0.0.1
 */
 
/**
 * Adding the Open Graph in the Language Attributes
 *
 * @since tiga 0.0.3
 */
add_filter('language_attributes', 'tiga_add_opengraph_doctype');
function tiga_add_opengraph_doctype( $output ) {
		return $output . ' xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml"';
	}

/**
 * Prints the Facebook open-graph meta
 *
 * @since tiga 0.0.3
 */
add_action('wp_head', 'tiga_open_graph', 1);
function tiga_open_graph() {
	global $post;
	$thumbsfb = of_get_option('tiga_og_thumb');
	
	$excerpt = ""; 
		if (has_excerpt($post->ID)) {
			$excerpt = esc_attr(strip_tags(get_the_excerpt($post->ID)));
		} else {
			$excerpt = esc_attr(str_replace("\r\n",' ',substr(strip_tags(strip_shortcodes($post->post_content)), 0, 160)));
		}
?>
	<!-- Open Graph Tags -->
	<meta property="og:type" content="<?php if ( is_singular() ) { echo "article"; } else { echo "website";} ?>">
	<meta property="og:title" content="<?php if ( is_singular() ) { echo esc_attr( get_the_title() ); } else { echo get_bloginfo('name'); } ?>">
	<meta property="og:url" content="<?php if ( is_singular() ) { echo esc_url( get_permalink() ); } else { echo esc_url( home_url( '/' ) ); } ?>">
	<meta property="og:description" content="<?php
		if ( is_singular() ) {
			if ( function_exists('wpseo_get_value') ) {
				echo wpseo_get_value('metadesc'); // get meta descriptions from WordPress SEO plugin
			} else {
				echo $excerpt;
			}
		} else {
			echo get_bloginfo('description');
		}
	?>">
	<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>">
	<meta property="og:image" content="<?php if ( is_singular() ) { echo tiga_fb_image(); } else { echo esc_url( $thumbsfb ); } ?>">
	<!-- End Open Graph Tags -->
<?php
	
} //end tiga_open_graph()

/**
 * Get image for facebook open-graph
 *
 * @since tiga 0.0.3
 */
function tiga_fb_image() {
	global $post;
	$thumbsfb = of_get_option('tiga_og_thumb');
	$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', '' );
	
	if ( has_post_thumbnail($post->ID) ) {
		$fbimage = $src[0];
	} else {
		global $post, $posts;
		$fbimage = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if (array_key_exists(1, $matches)) {
			if (array_key_exists(0, $matches[1])) {
				$fbimage  = $matches [1] [0];
			}
		}
	}
	if(empty($fbimage)) {
		$fbimage = esc_url( $thumbsfb );
	}
	
	return $fbimage;
	
} // end tiga_fb_image()
 
/**
 * Custom twitter widget function
 *
 * Credit:
 * Jeffrey Way - https://github.com/JeffreyWay/WordPress-Twitter-Widget
 *
 * @package tiga
 * @since tiga 0.0.1
 */
 
class tiga_Twitter_Widget extends WP_Widget {
    function __construct() {
        $params = array(
	    'description' => __('Display your recent tweets to your readers.', 'tiga'),
	    'name' => __('&raquo; tiga Twitter Widget', 'tiga')
		);
        
        // id, name, params
        parent::__construct('tiga_Twitter_Widget', '', $params);
    }
    
    public function form($instance) {
        extract($instance);
        ?>
        
        <p>
			<label for="<?php echo $this->get_field_id('title');?>"><?php _e('Title:', 'tiga'); ?> </label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if ( isset($title) ) echo esc_attr($title); ?>">
        </p>
        
        <p>
			<label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Twitter Username:', 'tiga'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" value="<?php if ( isset($username) ) echo esc_attr($username); ?>">
        </p>
        
        <p>
			<label for="<?php echo $this->get_field_id('tweet_count'); ?>">
				<?php _e('Number of Tweets to Retrieve:', 'tiga'); ?>
			</label>
			<input type="number" class="widefat" style="width: 40px;" id="<?php echo $this->get_field_id('tweet_count');?>" name="<?php echo $this->get_field_name('tweet_count');?>" min="1" max="10" value="<?php echo !empty($tweet_count) ? $tweet_count : 5; ?>" />
        </p>
        <?php
    }
    
    // What the visitor sees...
    public function widget($args, $instance) {
	extract($instance);
        extract( $args );
        
        if ( empty($title) ) $title = 'Recent Tweets';
        
        $data = $this->twitter($tweet_count, $username);
        if ( false !== $data && isset($data->tweets) ) {
            echo $before_widget;
		echo $before_title;
		    echo $title;
		echo $after_title;
		
		echo '<ul><li>' . implode('</li><li>', $data->tweets) . '</li></ul>'; ?>
		<span class="follow-me">
			<a href="https://twitter.com/<?php echo $username; ?>" class="twitter-follow-button" data-show-count="false">Follow @<?php echo $username; ?></a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</span>
        <?php   echo $after_widget;
        }
    }
    
    private function twitter($tweet_count, $username)
    {
        if ( empty($username) ) return;
        
        $tweets = get_transient('recent_tweets_widget');
        if ( !$tweets ||
	    $tweets->username !== $username ||
	    $tweets->tweet_count !== $tweet_count )
	{
	    return $this->fetch_tweets($tweet_count, $username);
	}
        return $tweets;
    }
    
    private function fetch_tweets($tweet_count, $username)
    {
	$tweets = wp_remote_get("http://twitter.com/statuses/user_timeline/$username.json");
	$tweets = json_decode($tweets['body']);
	
	// An error retrieving from the Twitter API?
	if ( isset($tweets->error) ) return false;
	
	$data = new StdClass();
	$data->username = $username;
	$data->tweet_count = $tweet_count;
	
	foreach($tweets as $tweet) {
	    if ( $tweet_count-- === 0 ) break;
	    $data->tweets[] = $this->filter_tweet( $tweet->text );
	}
	
	set_transient('recent_tweets_widget', $data, 60 * 5); // five minutes
	return $data;
    }

    private function filter_tweet($tweet)
    {
        // Username links
        $tweet = preg_replace('/(http[^\s]+)/im', '<a href="$1">$1</a>', $tweet);
        $tweet = preg_replace('/@([^\s]+)/i', '<a href="http://twitter.com/$1">@$1</a>', $tweet);
        // URL links
        return $tweet;
    }
    
}


/**
 * Makes a custom Widget for displaying Aside, Link, Status, and Quote Posts
 *
 * Learn more: http://codex.wordpress.org/Widgets_API#Developing_Widgets
 * Ephemera widget from twentyeleven theme
 *
 * @package tiga
 * @since tiga 0.0.1
 */
class tiga_Ephemera_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function tiga_Ephemera_Widget() {
		$widget_ops = array( 'classname' => 'widget_tiga_ephemera', 'description' => __( 'Use this widget to list your recent Aside, Status, Quote, and Link posts', 'tiga' ) );
		$this->WP_Widget( 'widget_tiga_ephemera', __( '&raquo; tiga Ephemera', 'tiga' ), $widget_ops );
		$this->alt_option_name = 'widget_tiga_ephemera';

		add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache' ) );
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes it's output
	 **/
	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_tiga_ephemera', 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = null;

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract( $args, EXTR_SKIP );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Ephemera', 'tiga' ) : $instance['title'], $instance, $this->id_base);

		if ( ! isset( $instance['number'] ) )
			$instance['number'] = '10';

		if ( ! $number = absint( $instance['number'] ) )
 			$number = 10;

		$ephemera_args = array(
			'order' => 'DESC',
			'posts_per_page' => $number,
			'no_found_rows' => true,
			'post_status' => 'publish',
			'post__not_in' => get_option( 'sticky_posts' ),
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'terms' => array( 'post-format-aside', 'post-format-link', 'post-format-status', 'post-format-quote' ),
					'field' => 'slug',
					'operator' => 'IN',
				),
			),
		);
		$ephemera = new WP_Query( $ephemera_args );

		if ( $ephemera->have_posts() ) :
			echo $before_widget;
			echo $before_title;
			echo $title; // Can set this with a widget option, or omit altogether
			echo $after_title;
			?>
			<ol>
			<?php while ( $ephemera->have_posts() ) : $ephemera->the_post(); ?>

				<?php if ( 'link' != get_post_format() ) : ?>

				<li class="widget-entry-title">
					<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tiga' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					<span class="comments-link">
						<?php comments_popup_link( __( '0 <span class="reply">comments &rarr;</span>', 'tiga' ), __( '1 <span class="reply">comment &rarr;</span>', 'tiga' ), __( '% <span class="reply">comments &rarr;</span>', 'tiga' ) ); ?>
					</span>
				</li>

				<?php else : ?>

				<li class="widget-entry-title">
					<?php
						// Grab first link from the post content. If none found, use the post permalink as fallback.
						$link_url = tiga_url_grabber();

						if ( empty( $link_url ) )
							$link_url = get_permalink();
					?>
					<a href="<?php echo esc_url( $link_url ); ?>" title="<?php printf( esc_attr__( 'Link to %s', 'tiga' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?>&nbsp;<span>&rarr;</span></a>
					<span class="comments-link">
						<?php comments_popup_link( __( '0 <span class="reply">comments &rarr;</span>', 'tiga' ), __( '1 <span class="reply">comment &rarr;</span>', 'tiga' ), __( '% <span class="reply">comments &rarr;</span>', 'tiga' ) ); ?>
					</span>
				</li>

				<?php endif; ?>

			<?php endwhile; ?>
			</ol>
			<?php

			echo $after_widget;

			// Reset the post globals as this query will have stomped on it
			wp_reset_postdata();

		// end check for ephemeral posts
		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_tiga_ephemera', $cache, 'widget' );
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_tiga_ephemera'] ) )
			delete_option( 'widget_tiga_ephemera' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_tiga_ephemera', 'widget' );
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 10;
?>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'tiga' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of posts to show:', 'tiga' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
		<?php
	}
}

/**
 * Custom social buttons widget
 *
 * @package tiga
 * @since tiga 0.0.1
 */
class tiga_Social_Widget extends WP_Widget
{
	function tiga_Social_Widget()
	{
		$widget_ops = array('classname' => 'tiga_social_widget', 'description' => 'Display the social buttons' );
		$this->WP_Widget('tiga_Social_Widget', '&raquo; tiga Social Buttons Widget', $widget_ops);
	}
 
	function form($instance)
	{
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = $instance['title'];
	?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'tiga' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
	<?php
	}
 
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		return $instance;
	}
 
	function widget($args, $instance)
	{
		extract($args, EXTR_SKIP);
 
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Social', 'tiga') : $instance['title'], $instance, $this->id_base);
		
		echo $before_widget;
 
		if (!empty($title))
			echo $before_title . $title . $after_title;
		?>
		
		<ul class="social-buttons clearfix">
			<?php if(of_get_option('tiga_email')) { ?>
				<li><a href="mailto:<?php echo esc_attr( of_get_option('tiga_email') ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(). '/library/img/icons/mail.png'; ?>"></a></li>
			<?php } if(of_get_option('tiga_twitter_username')) { ?>
				<li><a href="http://twitter.com/<?php echo esc_attr( of_get_option('tiga_twitter_username') ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(). '/library/img/icons/twitter.png'; ?>"></a></li>
			<?php } if(of_get_option('tiga_fb_username')) { ?>
				<li><a href="http://www.facebook.com/<?php echo esc_attr( of_get_option('tiga_fb_username') ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(). '/library/img/icons/facebook.png'; ?>"></a></li>
			<?php } if(of_get_option('tiga_gplus_username')) { ?>
				<li><a href="https://plus.google.com/u/<?php echo esc_attr( of_get_option('tiga_gplus_username') ); ?>/" target="_blank"><img src="<?php echo get_template_directory_uri(). '/library/img/icons/google+.png'; ?>"></a></li>
			<?php } if(of_get_option('tiga_ytube_username')) { ?>
				<li><a href="http://www.youtube.com/user/<?php echo esc_attr( of_get_option('tiga_ytube_username') ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(). '/library/img/icons/youtube.png'; ?>"></a></li>
			<?php } if(of_get_option('tiga_flickr_username')) { ?>
				<li><a href="http://www.flickr.com/photos/<?php echo esc_attr( of_get_option('tiga_flickr_username') ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(). '/library/img/icons/flickr.png'; ?>"></a></li>
			<?php } if(of_get_option('tiga_linkedin_username')) { ?>
				<li><a href="http://id.linkedin.com/in/<?php echo esc_attr( of_get_option('tiga_linkedin_username') ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(). '/library/img/icons/linkedin.png'; ?>"></a></li>
			<?php } if(of_get_option('tiga_pinterest_username')) { ?>
				<li><a href="http://pinterest.com/<?php echo esc_attr( of_get_option('tiga_pinterest_username') ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(). '/library/img/icons/pinterest.png'; ?>"></a></li>
			<?php } if(of_get_option('tiga_dribbble_username')) { ?>
				<li><a href="http://dribbble.com/<?php echo esc_attr( of_get_option('tiga_dribbble_username') ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(). '/library/img/icons/dribbble.png'; ?>"></a></li>
			<?php } if(of_get_option('tiga_github_username')) { ?>
				<li><a href="https://github.com/<?php echo esc_attr( of_get_option('tiga_github_username') ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(). '/library/img/icons/github.png'; ?>"></a></li>
			<?php } if(of_get_option('tiga_lastfm_username')) { ?>
				<li><a href="http://www.last.fm/user/<?php echo esc_attr( of_get_option('tiga_lastfm_username') ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(). '/library/img/icons/last_fm.png'; ?>"></a></li>
			<?php } if(of_get_option('tiga_vimeo_username')) { ?>
				<li><a href="http://vimeo.com/<?php echo esc_attr( of_get_option('tiga_vimeo_username') ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(). '/library/img/icons/vimeo.png'; ?>"></a></li>
			<?php } ?>
		</ul>
		
		<?php
		echo $after_widget;
	}
 
}


?>