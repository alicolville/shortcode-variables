<?php

defined('ABSPATH') or die('Jog on!');

function sh_cd_pages_your_shortcodes_edit( $action = 'add' ) {

	if ( false === in_array( $action, [ 'add', 'edit', 'save' ] ) ) {
	    return;
	}

	if ( false === current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	// Saving / Inserting a shortcode?
	if ( $action == 'save' ) {

		$save_result = sh_cd_shortcodes_save_post();

		$message = ( true === $save_result ) ? 'Your shortcode has been saved!' : 'There was an error saving your shortcode!';

		sh_cd_message_display( $message, ! $save_result );
	}

	// Load
	$shortcode = ( false === empty( $_GET['id'] ) ) ?
		            sh_cd_db_shortcodes_by_id( (int) $_GET['id'] ) :
		                sh_cd_get_values_from_post( [ 'id', 'slug', 'data', 'disabled' ] );

	$shortcode['data']  = stripslashes( $shortcode['data'] );

	?>

	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div>
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-3">
				<div id="post-body-content">
					<div class="meta-box-sortables ui-sortable">
                        <a class="button-secondary" href="<?php echo sh_cd_link_your_shortcodes(); ?>">Cancel</a>
						    <br /><br />
							<div class="postbox">
								<h3 class="hndle"><span>Add / Edit a shortcode</span></h3>
								<div style="padding: 0px 15px 0px 15px">

									<form method="post" action="<?php echo sh_cd_link_your_shortcodes() . '&action=save'; ?>">
										<input type="hidden" id="id" name="id" value="<?php echo esc_attr( $shortcode['id'] ); ?>" />
										<h4>Slug</h4>
                                        <p><small>Specify the unique identifier for this shortcode.</small></p>
										<input type="text" required class="regular-text" size="100" id="slug" name="slug"
                                                <?php echo ( ('edit' === $action) ? ' disabled' : ''); ?> placeholder="Slug"
                                                    value="<?php echo esc_attr( $shortcode['data'] )?>" />
										<?php if ('edit' == $action): ?>
											<p><small>Note: You can not edit a slug name. Editing a slug name may cause issues throughout your site. Please delete this shortcode and create another.</small></p>
										<?php endif; ?>
										<h4>Shortcode content</h4>
                                        <p><small>Specify the text, HTML, media, data, etc that should be rendered wherever the shortcode is placed.</small></p>
                                        <?php wp_editor( $shortcode['data'], 'data', [ 'textarea_name' => 'data' ] ); ?>
                                        <h4>Disable?</h4>
                                        <p>If disabled, nothing will be rendered where the shortcode has been placed.</p>
										<select id="disabled" name="disabled">
											<option value="0" <?php selected( $shortcode['disabled'], 0 ); ?>>No</option>
											<option value="1" <?php selected( $shortcode['disabled'], 1 ); ?>>Yes</option>
                                        </select>

                                        <?php echo submit_button( 'Save Shortcode' ); ?>

									</form>
								</div>
							</div>
                        </div>
			    	</div>
			    </div>
			<br class="clear">
		</div>
	</div>
	<?php
}

