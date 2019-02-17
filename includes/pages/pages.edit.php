<?php

defined('ABSPATH') or die('Jog on!');

function sh_cd_pages_your_shortcodes_edit() {

	if ( false === current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	$action = (isset($_GET['action']) ? $_GET['action'] : 'view-all');


	if ($action == 'save')
	{
		$slug = (isset($_POST['slug']) ? $_POST['slug'] : '');
		$value = (isset($_POST['value']) ? $_POST['value'] : '');
		$id = ((isset($_POST['existing-id']) && is_numeric($_POST['existing-id'])) ? $_POST['existing-id'] : false);
		$disabled = (isset($_POST['is-disabled']) && '1' == $_POST['is-disabled']) ? true : false;

		// refactor
		$shortcode = [
			'id' => ( false === empty( $_POST['existing-id'] ) ) ? (int) $_POST['existing-id'] : NULL,
			'slug' => ( false === empty( $_POST['slug'] ) ) ? $_POST['slug'] : NULL,
			'data' => ( false === empty( $_POST['value'] ) ) ? $_POST['value'] : NULL,
			'disabled' => ( false === empty( $_POST['is-disabled'] ) ) ? (int) $_POST['is-disabled'] : 0
		];


		if( sh_cd_db_shortcodes_save( $shortcode ) )
		{
			sh_cd_message_display('Shortcode has been saved');
		}
		else
		{
			sh_cd_message_display('There was an error saving your shortcode', true);
		}
	}

	?>

	<div class="wrap">

		<div id="icon-options-general" class="icon32"></div>

		<div id="poststuff">

			<div id="post-body" class="metabox-holder columns-3">
				<div id="post-body-content">
					<div class="meta-box-sortables ui-sortable">
                        <a class="button-secondary" href="<?php echo sh_cd_link_your_shortcodes(); ?>">Cancel</a>
						<?php

						if ( true === in_array( $action, [ 'add', 'edit'] ) ) {

							$title = 'Add Shortcode';
							$slug = '';
							$value = '';
							$button_text = 'Add';
							$existing_id = false;

							if ($action == 'edit')
							{
								$title = 'Edit Shortcode';
								$button_text = 'Save';
								$existing_id = $_GET['id'];

								// Get Shortcode from DB
								$shortcode = sh_cd_db_shortcodes_by_id($existing_id);
								$slug = $shortcode['slug'];
								$value = stripslashes($shortcode['data']);
							}

							$settings = array( 'textarea_name' => 'value' );


							?>
							<br /><br />
							<div class="postbox">
								<h3 class="hndle"><span><?php echo _e($title); ?> </span></h3>
								<div style="padding: 0px 15px 0px 15px">

									<form method="post" action="<?php echo sh_cd_link_your_shortcodes() . '&action=save'; ?>">
										<input type="hidden" id="existing-id" name="existing-id" value="<?php echo ((!empty($existing_id)) ? $existing_id : ''); ?>" />
										<p><?php echo __('Slug'); ?>:</p>
										<input type="text" class="regular-text" size="100" id="slug" name="slug" <?php echo (('edit' == $action) ? ' disabled' : ''); ?> placeholder="<?php echo __('Slug'); ?>" <?php echo ((!empty($slug)) ? "value=\"$slug\"" : ""); ?>/>
										<?php if ('edit' == $action): ?>
											<p><small><?php echo __('Note: You can not edit a slug name. Editing a slug name may cause issues throughout your site. Please delete this shortcode and create another.'); ?></small></p>
										<?php endif; ?>
										<p>Shortcode data / Value:</p>
                                        <?php wp_editor( $value, 'value', $settings ); ?>
										<p>Disable variable? If disabled, nothing will be rendered where the shortcode has been placed:</p>

										<select id="is-disabled" name="is-disabled">
											<option value="0" <?php selected( $shortcode['disabled'], 0 ); ?>>No</option>
											<option value="1" <?php selected( $shortcode['disabled'], 1 ); ?>>Yes</option>

										</select>



                                        <?php echo submit_button( $button_text . __(' Shortcode') ); ?>

									</form>
								</div>
							</div>

							<?php
						}

						?>
					</div>
				</div>
			</div>
			<br class="clear">
		</div>
	</div>
	<?php
}

