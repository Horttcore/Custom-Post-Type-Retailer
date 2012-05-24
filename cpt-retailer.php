<?php
/*
Plugin Name: Custom Post Type Retailer
Plugin URL: http://horttcore.de
Description: 
Version: 0.1
Author: Ralf Hortt
Author URL: http://horttcore.de/
*/



/**
 * Security, checks if WordPress is running
 **/
if ( !function_exists( 'add_action' ) ) :
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
endif;



/**
 *
 * Plugin Definitions
 *
 */
define( 'HC_CPT_RETAILER_BASENAME', plugin_basename(__FILE__) );
define( 'HC_CPT_RETAILER_BASEDIR', dirname( plugin_basename(__FILE__) ) );



/**
*  Plugin
*/
class Custom_Post_Type_Retailer
{
	/**
	 * Constructor
	 *
	 **/
	function __construct()
	{
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'admin_print_scripts-post.php', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_print_scripts-post-new.php', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_print_styles-post.php', array( $this, 'enqueue_styles' ) );
		add_action( 'admin_print_styles-post-new.php', array( $this, 'enqueue_styles' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );

		add_filter( 'post_updated_messages', array( $this, 'post_updated_messages' ) );
	}



	/**
	 * Add meta boxes
	 *
	 * @return void
	 * @author 
	 **/
	public function add_meta_boxes()
	{
		add_meta_box( 'retailer-address', __( 'Adress', 'HC_CPT_RETAILER' ), array( $this, 'retailer_address' ), 'retailer' );
    	add_meta_box( 'retailer-contact', __( 'Contact', 'HC_CPT_RETAILER' ), array( $this, 'retailer_contact' ), 'retailer' );
	}



	/**
	 * Enqueue javascript
	 *
	 * @access public
	 * @return void
	 * @author Ralf Hortt
	 **/
	public function enqueue_scripts()
	{
		wp_enqueue_script( 'cpt-retailer-js', WP_PLUGIN_URL . '/' . HC_CPT_RETAILER_BASEDIR . '/javascript/cpt-retailer.js', array('jquery') );
	}



	/**
	 * Enqueue css
	 *
	 * @access public
	 * @return void
	 * @author Ralf Hortt
	 **/
	public function enqueue_styles()
	{
		wp_enqueue_style( 'cpt-retailer-css', WP_PLUGIN_URL . '/' . HC_CPT_RETAILER_BASEDIR . '/css/cpt-retailer.css' );
	}



	/**
	 * Load plugin textdomain
	 *
	 * @return void
	 * @author Ralf Hortt
	 **/
	public function load_plugin_textdomain()
	{
		load_plugin_textdomain( 'HC_CPT_RETAILER', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/'  );
	}



	/**
	 * Post updated messages
	 *
	 * @param array $messages Update Messages
	 * @return void
	 * @author Ralf Hortt
	 **/
	public function post_updated_messages( $messages )
	{
		global $post, $post_ID;

		$messages['retailer'] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => sprintf( __('Retailer updated. <a href="%s">View retailer</a>', 'HC_CPT_RETAILER'), esc_url( get_permalink($post_ID) ) ),
			2 => __('Custom field updated.', 'HC_CPT_RETAILER'),
			3 => __('Custom field deleted.', 'HC_CPT_RETAILER'),
			4 => __('Retailer updated.', 'HC_CPT_RETAILER'),
			/* translators: %s: date and time of the revision */
			5 => isset($_GET['revision']) ? sprintf( __('Retailer restored to revision from %s', 'HC_CPT_RETAILER'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __('Retailer published. <a href="%s">View retailer</a>', 'HC_CPT_RETAILER'), esc_url( get_permalink($post_ID) ) ),
			7 => __('Retailer saved.', 'HC_CPT_RETAILER'),
			8 => sprintf( __('Retailer submitted. <a target="_blank" href="%s">Preview retailer</a>', 'HC_CPT_RETAILER'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
			9 => sprintf( __('Retailer scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview retailer</a>', 'HC_CPT_RETAILER'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
			10 => sprintf( __('Retailer draft updated. <a target="_blank" href="%s">Preview retailer</a>', 'HC_CPT_RETAILER'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		);

		return $messages;
	}



	/**
	 * Register post type
	 *
	 * @return void
	 * @author Ralf Hortt
	 **/
	public function register_post_type()
	{
		$labels = array(
			'name' => _x( 'Retailers', 'post type general name', 'HC_CPT_RETAILER' ),
			'singular_name' => _x( 'Retailer', 'post type singular name', 'HC_CPT_RETAILER' ),
			'add_new' => _x( 'Add New', 'Retailer', 'HC_CPT_RETAILER' ),
			'add_new_item' => __( 'Add New Retailer', 'HC_CPT_RETAILER' ),
			'edit_item' => __( 'Edit Retailer', 'HC_CPT_RETAILER' ),
			'new_item' => __( 'New Retailer', 'HC_CPT_RETAILER' ),
			'all_items' => __( 'All Retailers', 'HC_CPT_RETAILER' ),
			'view_item' => __( 'View Retailer', 'HC_CPT_RETAILER' ),
			'search_items' => __( 'Search Retailers', 'HC_CPT_RETAILER' ),
			'not_found' =>  __( 'No Retailers found', 'HC_CPT_RETAILER' ),
			'not_found_in_trash' => __( 'No Retailers found in Trash', 'HC_CPT_RETAILER' ), 
			'parent_item_colon' => '',
			'menu_name' => __( 'Retailers', 'HC_CPT_RETAILER' )
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true, 
			'show_in_menu' => true, 
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'has_archive' => true, 
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array( 'title', 'editor', 'author', 'thumbnail' )
		);
		
		register_post_type( 'retailer', $args );
	}



	/**
	 * Metabox for retailer address
	 *
	 * @param obj $post Post object
	 * @return void
	 * @author Ralf Hortt
	 **/
	public function retailer_address( $post )
	{
		// Load data
		$retailer = get_post_meta( $post->ID, '_retailer', TRUE );
		$address = $retailer['retailer-street'] . '+' . $retailer['retailer-streetnumber'] . '+' . $retailer['retailer-zip'] . '+' . $retailer['retailer-city'] . '+' . $retailer['retailer-country'];

		// Easter egg!
		// Stadion of my favorite football club!
		if ( '++++'== $address )
			$address = 'Fritz-Walter-Straße+1+67663+Kaiserslautern+Fritz-Walter-Stadion';

		?>
		<p>
			<span class="retailer-street-number">
				<label for="retailer-street"><?php _e( 'Street', 'HC_CPT_RETAILER' ); ?></label> / <label for="retailer-streetnumber"><?php _e( 'Number', 'HC_CPT_RETAILER' ); ?></label>
			</span>
			<input type="text" name="retailer-street" id="retailer-street" value="<?php echo $retailer['retailer-street'] ?>"> / <input type="text" name="retailer-streetnumber" id="retailer-streetnumber" value="<?php echo $retailer['retailer-streetnumber'] ?>">
		</p>

		<p>
			<span class="retailer-zip-city">
				<label for="retailer-zip"><?php _e( 'Zip', 'HC_CPT_RETAILER' ); ?></label> / <label for="retailer-city"><?php _e( 'City', 'HC_CPT_RETAILER' ); ?></label>
			</span>
			<input type="text" name="retailer-zip" id="retailer-zip" value="<?php echo $retailer['retailer-zip'] ?>"> / <input type="text" name="retailer-city" id="retailer-city" value="<?php echo $retailer['retailer-city'] ?>">
		</p>

		<p>
			<label for="retailer-county"><?php _e( 'Country', 'HC_CPT_RETAILER' ); ?></label>
			<input type="text" name="retailer-country" id="retailer-country" value="<?php echo $retailer['retailer-country'] ?>" list="countries">
			<?php if ( $csp_l10n_sys_locales ) : ?>
				<datalist id="countries">
					<option><?php _e( 'Albania', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Algeria', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Argentina', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Australia', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Austria', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Azerbaijan', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Bahrain', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Basque', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Belarus', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Belgium', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Bolivia', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Bosnia and Herzegovina', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Brazil', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Bulgaria', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Canada', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Chile', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'China', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Colombia', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Costa Rica', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Croatia', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Czech Republic', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Denmark', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Dominican Republic', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Ecuador', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Egypt', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'El Salvador', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Espana', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Estonia', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Faroe Islands', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Finland', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Former Yugoslav Republic of Macedonia', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'France', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Germany', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Greece', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Guatemala', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Honduras', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Hong Kong S.A.R.', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Hungary', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Iceland', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'India', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Indonesia', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Iran', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Iraq', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Ireland', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Israel', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Italy', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Japan', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Jordan', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Kazakhstan', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Korea', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Kuwait', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Kyrgyzstan', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Latvia', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Lebanon', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Libya', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Lithuania', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Luxembourg', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Macau S.A.R.', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Mexico', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Mongolia', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Morocco', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Netherlands', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'New Zealand', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Nicaragua', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Norway', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Oman', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Panama', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Paraguay', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Peru', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Philippines', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Poland', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Portugal', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Puerto Rico', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Qatar', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Republic of the Philippines', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Romania', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Russia', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Saudi Arabia', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Serbia and Montenegro', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Serbia', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Singapore', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Slovakia', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Slovenia', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'South Africa', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Spain', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Spain', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Sweden', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Switzerland', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Syria', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Taiwan', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Thailand', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Tunisia', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Turkey', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'U.A.E.', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Ukraine', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'United Kingdom', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'United States', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Uruguay', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Venezuela', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Viet Nam', 'HC_CPT_RETAILER' ) ?></option>
					<option><?php _e( 'Yemen', 'HC_CPT_RETAILER' ) ?></option>
				</datalist>
			<?php endif; ?>
		</p>
		<p>
			<iframe class="retailer-map" src="http://maps.google.de/maps?q=<?php echo $address ?>&amp;output=embed"></iframe>
		</p>
		<?php
		// Use nonce for verification
 		wp_nonce_field( plugin_basename( __FILE__ ), 'hc-cpt-retailer' );
	}



	/**
	 * Metabox for retailer contact
	 *
	 * @param obj $post Post object
	 * @return void
	 * @author Ralf Hortt
	 **/
	public function retailer_contact( $post )
	{
		// Load data
		$retailer = get_post_meta( $post->ID, '_retailer', TRUE );
		?>
		<p>
			<label for="retailer-phone-area-code"><?php _e( 'Phone', 'HC_CPT_RETAILER' ); ?></label>
			<input type="number" name="retailer-phone-area-code" id="retailer-phone-area-code" value="<?php echo $retailer['retailer-phone-area-code'] ?>"> / <input type="number" name="retailer-phone" id="retailer-phone" value="<?php echo $retailer['retailer-phone'] ?>">
		</p>
		<p>
			<label for="retailer-fax-area-code"><?php _e( 'Fax', 'HC_CPT_RETAILER' ); ?></label>
			<input type="number" name="retailer-fax-area-code" id="retailer-fax-area-codex" value="<?php echo $retailer['retailer-fax-area-code'] ?>"> / <input type="number" name="retailer-fax" id="retailer-fax" value="<?php echo $retailer['retailer-fax'] ?>">
		</p>
		<p>
			<label for="retailer-mobile-area-code"><?php _e( 'Mobile', 'HC_CPT_RETAILER' ); ?></label>
			<input type="number" name="retailer-mobile-area-code" id="retailer-mobile-area-code" value="<?php echo $retailer['retailer-mobile-area-code'] ?>"> / <input type="number" name="retailer-mobile" id="retailer-mobile" value="<?php echo $retailer['retailer-mobile'] ?>">
		</p>
		<p>
			<label for="retailer-email"><?php _e( 'E-Mail', 'HC_CPT_RETAILER' ); ?></label>
			<input type="email" name="retailer-email" id="retailer-email" value="<?php echo $retailer['retailer-email'] ?>">
		</p>
		<p>
			<label for="retailer-url"><?php _e( 'URL', 'HC_CPT_RETAILER' ); ?></label>
			<input type="url" name="retailer-url" id="retailer-url" value="<?php echo $retailer['retailer-url'] ?>">
		</p>
		<?php
	}



	/**
	 * Save meta data
	 *
	 * @return void
	 * @author Ralf Hortt
	 **/
	public function save_post( $post_id )
	{
		// verify if this is an auto save routine. 
		// If it is our form has not been submitted, so we dont want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return;

		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if ( !wp_verify_nonce( $_POST['hc-cpt-retailer'], plugin_basename( __FILE__ ) ) )
			return;

		// save meta data
		$retailer = array(
			// Address
			'retailer-street' => esc_attr( $_POST['retailer-street']),
			'retailer-streetnumber' => esc_attr( $_POST['retailer-streetnumber']),
			'retailer-zip' => esc_attr( $_POST['retailer-zip']),
			'retailer-city' => esc_attr( $_POST['retailer-city']),
			'retailer-country' => esc_attr( $_POST['retailer-country']),
			// Contact
			'retailer-phone-area-code' => esc_attr( $_POST['retailer-phone-area-code']),
			'retailer-phone' => esc_attr( $_POST['retailer-phone']),
			'retailer-fax-area-code' => esc_attr( $_POST['retailer-fax-area-code']),
			'retailer-fax' => esc_attr( $_POST['retailer-fax']),
			'retailer-mobile-area-code' => esc_attr( $_POST['retailer-mobile-area-code']),
			'retailer-mobile' => esc_attr( $_POST['retailer-mobile']),
			'retailer-url' => esc_url( $_POST['retailer-url'] ),
			'retailer-email' => sanitize_email( $_POST['retailer-email'] )
		);

		update_post_meta( $post_id, '_retailer', $retailer );
	}



}
$CPT_Retailer = new Custom_Post_Type_Retailer;