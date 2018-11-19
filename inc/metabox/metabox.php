<?php
/**
 * The template for displaying meta box in page/post
 *
 * This adds Select Sidebar, Header Featured Image Options, Single Page/Post Image Layout
 * This is only for the design purpose and not used to save any content
 *
 * @package Catch_Fullscreen
 */



/**
 * Class to Renders and save metabox options
 *
 * @since Catch Fullscreen 1.0
 */
class Catch_Fullscreen_Metabox {
	private $meta_box;

	private $fields;

	/**
	* Constructor
	*
	* @since Catch Fullscreen 1.0
	*
	* @access public
	*
	*/
	public function __construct( $meta_box_id, $meta_box_title, $post_type ) {

		$this->meta_box = array (
							'id' 		=> $meta_box_id,
							'title' 	=> $meta_box_title,
							'post_type' => $post_type,
							);

		$this->fields = array(
			'catch-fullscreen-header-image',
		);


		// Add metaboxes
		add_action( 'add_meta_boxes', array( $this, 'add' ) );

		add_action( 'save_post', array( $this, 'save' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_metabox_scripts' ) );
	}

	/**
	* Add Meta Box for multiple post types.
	*
	* @since Catch Fullscreen 1.0
	*
	* @access public
	*/
	public function add($postType) {
		if( in_array( $postType, $this->meta_box['post_type'] ) ) {
			add_meta_box( $this->meta_box['id'], $this->meta_box['title'], array( $this, 'show' ), $postType );
		}
	}

	/**
	* Renders metabox
	*
	* @since Catch Fullscreen 1.0
	*
	* @access public
	*/
	public function show() {
		global $post;

		$header_image_options 	= array(
			'default' => esc_html__( 'Default', 'catch-fullscreen' ),
			'enable'  => esc_html__( 'Enable', 'catch-fullscreen' ),
			'disable' => esc_html__( 'Disable', 'catch-fullscreen' ),
		);

		$content_bg_options = array(
			'default' => esc_html__( 'Default', 'catch-fullscreen' ),
			'disable' => esc_html__( 'Disable', 'catch-fullscreen' ),
			'enable'  => esc_html__( 'Enable', 'catch-fullscreen' ),
		);


		// Use nonce for verification
		wp_nonce_field( basename( __FILE__ ), 'catch_fullscreen_custom_meta_box_nonce' );

		// Begin the field table and loop  ?>
		<div id="catch-fullscreen-ui-tabs" class="ui-tabs">
			<ul class="catch-fullscreen-ui-tabs-nav" id="catch-fullscreen-ui-tabs-nav">
				<li><a href="#frag3"><?php esc_html_e( 'Header Featured Image Options', 'catch-fullscreen' ); ?></a></li>
			</ul>

			<div id="frag3" class="catch_ad_tabhead">
				<table id="header-image-metabox" class="form-table" width="100%">
					<tbody>
						<tr>
							<?php
							$metaheader = get_post_meta( $post->ID, 'catch-fullscreen-header-image', true );

							if ( empty( $metaheader ) ){
								$metaheader = 'default';
							}

							foreach ( $header_image_options as $field => $label ) {
							?>
								<td style="width: 100px;">
									<label class="description">
										<input type="radio" name="catch-fullscreen-header-image" value="<?php echo esc_attr( $field ); ?>" <?php checked( $field, $metaheader ); ?>/>&nbsp;&nbsp;<?php echo esc_html( $label ); ?>
									</label>
								</td>

							<?php
							} // end foreach
							?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	<?php
	}

	/**
	 * Save custom metabox data
	 *
	 * @action save_post
	 *
	 * @since Catch Fullscreen 1.0
	 *
	 * @access public
	 */
	public function save( $post_id ) {
		global $post_type;

		$post_type_object = get_post_type_object( $post_type );

		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                      // Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )        // Check Revision
		|| ( ! in_array( $post_type, $this->meta_box['post_type'] ) )                  // Check if current post type is supported.
		|| ( ! check_admin_referer( basename( __FILE__ ), 'catch_fullscreen_custom_meta_box_nonce') )    // Check nonce - Security
		|| ( ! current_user_can( $post_type_object->cap->edit_post, $post_id ) ) )  // Check permission
		{
		  return $post_id;
		}

		foreach ( $this->fields as $field ) {
			$new = $_POST[ $field ];

			delete_post_meta( $post_id, $field );

			if ( '' == $new || array() == $new ) {
				return;
			} else {
				if ( ! update_post_meta ( $post_id, $field, sanitize_key( $new ) ) ) {
					add_post_meta( $post_id, $field, sanitize_key( $new ), true );
				}
			}
		} // end foreach
	}

	public function enqueue_metabox_scripts( $hook ) {
		$allowed_pages = array( 'post-new.php', 'post.php' );

		// Bail if not on required page
		if ( ! in_array( $hook, $allowed_pages ) ) {
			return;
		}

		//Scripts
		wp_enqueue_script( 'catch-fullscreen-metabox-script', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'inc/metabox/metabox.js', array( 'jquery', 'jquery-ui-tabs' ), '2017-08-15' );

		//CSS Styles
		wp_enqueue_style( 'catch-fullscreen-metabox-style', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'inc/metabox/metabox.css' );
	}
}

$Catch_Fullscreen_Metabox = new Catch_Fullscreen_Metabox(
	'catch-fullscreen-options', 					//metabox id
	esc_html__( 'Catch Fullscreen Options', 'catch-fullscreen' ), //metabox title
	array( 'page', 'post' )				//metabox post types
);
