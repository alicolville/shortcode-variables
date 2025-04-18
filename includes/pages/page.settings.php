<?php

defined('ABSPATH') or die('Jog on!');

function sh_cd_settings_page_generic() {

    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' , SH_CD_SLUG ) );
    }

	$disable_if_not_premium_class = ( SH_CD_IS_PREMIUM ) ? '' : 'sh-cd-disabled';

    ?>

    <div id="icon-options-general" class="icon32"></div>

    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-3 yk-mt-settings">

            <!-- main content -->
            <div id="post-body-content">

                <div class="meta-box-sortables ui-sortable">

                    <div class="postbox">
                        <h3 class="postbox-header">
							<span>
								<?php echo __( 'Settings', SH_CD_SLUG ); ?>
							</span>
                        </h3>
                        <div class="inside">
                            <form method="post" action="options.php">
                                <?php

                                settings_fields( 'sh-cd-options-group' );
                                do_settings_sections( 'sh-cd-options-group' );

                                ?>

								<?php
									if ( false === SH_CD_IS_PREMIUM ) {
										sh_cd_display_pro_upgrade_notice();
									}
								?>
								<h3><?php echo __( 'Permissions' , SH_CD_SLUG); ?></h3>
								<table class="form-table">
									<tr class="<?php echo $disable_if_not_premium_class; ?>">
										<th scope="row"><?php echo __( 'Who can view and modify snippet shortcodes?' , SH_CD_SLUG); ?></th>
										<?php $edit_permissions = sh_cd_permission_role(); ?>
										<td>
											<select id="sh-cd-edit-permissions" name="sh-cd-edit-permissions">
												<option value="manage_options" <?php selected( $edit_permissions, 'manage_options' ); ?>><?php echo __( 'Administrators Only', SH_CD_SLUG ); ?></option>
												<option value="read_private_posts" <?php selected( $edit_permissions, 'read_private_posts' ); ?>><?php echo __( 'Editors and above', SH_CD_SLUG ); ?></option>
												<option value="publish_posts" <?php selected( $edit_permissions, 'publish_posts' ); ?>><?php echo __( 'Authors and above', SH_CD_SLUG ); ?></option>
											</select>
											<p><?php echo __('Specify the minimum level of user role that can edit and view shortcodes.', SH_CD_SLUG)?></p>
										</td>
									</tr>
                                    <tr class="<?php echo $disable_if_not_premium_class; ?>">
                                        <th scope="row"><a href="https://snippet-shortcodes.yeken.uk/shortcodes/sc-db-value-by-id.html" target="_blank" rel="noopener">"sc-db-value-by-id"</a> <?php echo __( 'shortcode enabled', SH_CD_SLUG ); ?>?</th>
                                        <?php $is_enabled = sh_cd_is_shortcode_db_value_by_id_enabled();  ?>
                                        <td>
                                            <select id="sh-cd-shortcode-db-value-by-id-enabled" name="sh-cd-shortcode-db-value-by-id-enabled">
                                                <option value="No" <?php selected( $is_enabled, false ); ?>><?php echo __( 'No', SH_CD_SLUG ); ?></option>
                                                <option value="Yes" <?php selected( $is_enabled, true ); ?>><?php echo __( 'Yes', SH_CD_SLUG ); ?></option>
                                            </select>
                                            <p><?php echo __('Should the premium shortcode, [sv slug="sc-db-value-by-id"] be enabled?', SH_CD_SLUG)?></p>
                                        </td>
                                    </tr>
								</table>
                                <?php submit_button(); ?>
                            </form>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
        <!-- #poststuff -->

    </div> <!-- .wrap -->

    <?php

}

/**
 * Register fields to save
 */
function sh_cd_register_settings(){

	register_setting( 'sh-cd-options-group', 'sh-cd-edit-permissions' );
	register_setting( 'sh-cd-options-group', 'sh-cd-shortcode-db-value-by-id-enabled' );
}
add_action( 'admin_init', 'sh_cd_register_settings' );
