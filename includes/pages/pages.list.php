<?php

defined('ABSPATH') or die('Jog on!');

function sh_cd_user_defined_page() {

	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<h1>' . SH_CD_PLUGIN_NAME . '</h1>';


	$this_page = get_permalink();

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
	elseif($action == 'delete')
	{
		if(sh_cd_db_shortcodes_delete($_GET['id']))
		{
			sh_cd_message_display('Shortcode has been deleted!');
		}
		else
		{
			sh_cd_message_display('There was an error deleting your shortcode', true);
		}
	}

	?>

	<div class="wrap">

		<div id="icon-options-general" class="icon32"></div>

		<div id="poststuff">

			<div id="post-body" class="metabox-holder columns-3">
				<!-- main content -->
				<div id="post-body-content">

					<div class="meta-box-sortables ui-sortable">

						<?php

						if ($action == 'add' || $action == 'edit')
						{


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
							<a class="button-secondary" href="<?php echo admin_url('admin.php?page=sh-cd-shortcode-variables-user-defined'); ?>"><?php esc_attr_e( 'Cancel' ); ?></a>
							<br /><br />
							<div class="postbox">
								<h3 class="hndle"><span><?php echo _e($title); ?> </span></h3>
								<div style="padding: 0px 15px 0px 15px">

									<form method="post" action="<?php echo admin_url('admin.php?page=sh-cd-shortcode-variables-user-defined&action=save'); ?>">
										<input type="hidden" id="existing-id" name="existing-id" value="<?php echo ((!empty($existing_id)) ? $existing_id : ''); ?>" />
										<p><?php echo __('Slug'); ?>:</p>
										<input type="text" class="regular-text" size="100" id="slug" name="slug" <?php echo (('edit' == $action) ? ' disabled' : ''); ?> placeholder="<?php echo __('Slug'); ?>" <?php echo ((!empty($slug)) ? "value=\"$slug\"" : ""); ?>/>
										<?php if ('edit' == $action): ?>
											<p><small><?php echo __('Note: You can not edit a slug name. Editing a slug name may cause issues throughout your site. Please delete this shortcode and create another.'); ?></small></p>
										<?php endif; ?>
										<p><?php echo __('Shortcode data / Value:'); ?></p>
										<!--<textarea id="value" name="value" cols="80" rows="10" class="large-text"><?php echo $value; ?></textarea><br>-->
										<?php wp_editor( $value, 'value', $settings ); ?>
										<p><?php echo __('Disable variable? If disabled, nothing will be rendered where the shortcode has been placed.'); ?>:</p>

										<select id="is-disabled" name="is-disabled">
											<option value="0" <?php selected( $shortcode['disabled'], 0 ); ?>><?php echo __('No'); ?></option>
											<option value="1" <?php selected( $shortcode['disabled'], 1 ); ?>><?php echo __('Yes'); ?></option>

										</select>

										<?php echo submit_button( $button_text . __(' Shortcode') ); ?>

									</form>
								</div>
							</div>

							<?php
						}
						else
						{?>
							<a class="button-primary" href="<?php echo admin_url('admin.php?page=sh-cd-shortcode-variables-user-defined&action=add'); ?>"><?php esc_attr_e( 'Add a new Shortcode' ); ?></a>
							<br /><br />


							<div class="postbox">
								<h3 class="hndle"><span><?php _e( 'Existing Shortcodes' ); ?> </span></h3>
								<div style="padding: 0px 15px 0px 15px">
									<br />
									<table class="widefat sh-cd-table" width="100%">
										<tr class="row-title">
											<th class="row-title" width="15%"><?php echo __('Slug'); ?></th>
											<th width="20%"><?php echo __('Shortcode to embed'); ?></th>
											<th width="*"><?php echo __('Shortcode Value'); ?></th>
											<th width="5%"><?php echo __('Disabled'); ?></th>
											<th width="15%"><?php echo __('Options'); ?></th>
										</tr>
										<?php

										$current_shortcodes = sh_cd_db_shortcodes_all();

										if ( false === empty( $current_shortcodes ) )
										{

											$class = '';

											foreach ($current_shortcodes as $shortcode):

												$class = ($class == 'alternate') ? '' : 'alternate';

												$edit_link = admin_url('admin.php?page=sh-cd-shortcode-variables-user-defined&action=edit&id=' . $shortcode['id'] );
												$delete_link = admin_url('admin.php?page=sh-cd-shortcode-variables-user-defined&action=delete&id=' . $shortcode['id'] );
												?>
												<tr class="<?php echo $class; ?>">
													<td><a href="<?php echo $edit_link; ?>"><?php echo $shortcode['slug']; ?></a></td>
													<td>[<?php echo SH_CD_SHORTCODE; ?> slug="<?php echo $shortcode['slug']; ?>"]</td>
													<td><textarea class="large-text"><?php echo esc_html(stripslashes($shortcode['data'])); ?></textarea></td>
													<td><?php echo (0 == $shortcode['disabled']) ? __('No') : __('Yes'); ?></td>
													<td>
														<a class="button button-small" href="<?php echo $edit_link; ?>"><?php echo __('Edit'); ?></a>
														<a class="button button-small" href="<?php echo $delete_link; ?>" class="remove-confirmz" onclick="return confirm('Want to delete?');" ><?php echo __('Delete'); ?></a>
													</td>
												</tr>
											<?php endforeach;

										}
										else
										{?>
											<tr>
												<td colspan="4" align="center"><?php echo __('You haven\'t created any shortcodes yet. <a href="' . admin_url('admin.php?page=sh-cd-shortcode-variables-user-defined&action=add') . '">Add one now!</a>'); ?></td>
											</tr>
											<?php
										}
										?>
									</table>
									<br />
								</div>
							</div>
							<?php



						}
						?>


					</div>
					<!-- .meta-box-sortables .ui-sortable -->

				</div>
				<!-- post-body-content -->

			</div>
			<!-- #post-body .metabox-holder .columns-2 -->

			<br class="clear">
		</div>
		<!-- #poststuff -->

	</div> <?php
}

