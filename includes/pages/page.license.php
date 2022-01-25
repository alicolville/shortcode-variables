<?php

    defined('ABSPATH') or die('Jog on!');

    function sh_cd_advertise_pro() {

        $site_hash = sh_cd_generate_site_hash();

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'You do not have sufficient permissions to access this page.', SH_CD_SLUG ) );
        }

		// Remove existing license?
        if ( false === empty( $_GET['remove-license'] ) ) {
            sh_cd_license_remove();
        }

        ?>

        <div class="wrap ws-ls-admin-page">
            <?php
                if ( false === empty( $_POST['license-key'] ) ){

                    // First try validating and applying a new subscription license
                    $valid_license = sh_cd_license_apply( $_POST['license-key'] );

                    if ( $valid_license ) {
                        sh_cd_message_display( __('Your license has been applied!', SH_CD_SLUG ) );
                    } else {
                        sh_cd_message_display(__('There was an error applying your license. ', SH_CD_SLUG ), true);
                    }
                }

                $existing_license = ( true === SH_CD_IS_PREMIUM ) ? sh_cd_license() : NULL;

                if ( false === empty( $existing_license ) ) {
                    $license_decoded = sh_cd_license_decode( $existing_license );
                }

            ?>
            <div id="icon-options-general" class="icon32"></div>
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="post-body-content">

                        <div class="meta-box-sortables ui-sortable">
                            <div class="postbox">
								<div class="postbox-header">
									<h2 class="hndle"><span><?php echo __( 'Upgrade your license', SH_CD_SLUG ); ?> </span></h2>
								</div>
                                <div class="inside">
                                    <center>
                                        <h3><?php echo __( 'In case you need, your <strong>Site Hash</strong> is', SH_CD_SLUG ); ?>: <?php echo esc_html( $site_hash ) ; ?></h3>

                                        <?php

                                            if ( true === empty( $existing_license ) ) :

                                                sh_cd_upgrade_button();
                                        ?>
                                                <br />  <br />
                                                <hr />
                                                <h3><?php echo __( 'Premium Shortcodes', SH_CD_SLUG ); ?></h3>
                                                <p><?php echo __( 'Upgrade to the Premium version of Snippet Shortcodes and receive the following shortcodes', SH_CD_SLUG ); ?>:</p>

                                                <br />
                                        <?php
	                                            echo sh_cd_display_premade_shortcodes( 'premium' );

                                            endif;
                                        ?>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="postbox-container-1" class="postbox-container">

                        <div class="meta-box-sortables">

                            <div class="postbox">
								<div class="postbox-header">
									<h2 class="hndle"><span><?php echo __( 'Add or Update License', SH_CD_SLUG ); ?> </span></h2>
								</div>
                                <div class="inside">

                                    <form action="<?php echo admin_url( 'admin.php?page=sh-cd-shortcode-variables-license&add-license=true' ); ?>"
                                          method="post">
                                        <p><?php echo __( 'Copy and paste the license given to you by YeKen into this box and click "Apply License".', SH_CD_SLUG ); ?></p>
                                        <textarea rows="5" style="width:100%" name="license-key"></textarea>
                                        <br/><br/>
                                        <input type="submit" class="button-secondary large-text" value="<?php echo __( 'Apply License', SH_CD_SLUG ); ?>"/>
                                    </form>
                                </div>
                            </div>
                            <div class="postbox">
								<div class="postbox-header">
									<h2 class="hndle"><span><?php echo __( 'Your license information', SH_CD_SLUG ); ?> </span></h2>
								</div>
                                <div class="inside">
                                    <table class="ws-ls-sidebar-stats">
                                        <tr>
                                            <th><?php echo __( 'Site Hash', SH_CD_SLUG ); ?></th>
                                            <td><?php echo esc_html( sh_cd_generate_site_hash() ); ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo __( 'Expires', SH_CD_SLUG ); ?></th>
                                            <td>
                                                <?php

                                                    if( false === empty( $license_decoded['type'] ) &&
															'sv-premium' === $license_decoded['type'] ) {

                                                        $time = strtotime( $license_decoded['expiry-date'] );
                                                        $formatted = date( 'd/m/Y', $time );

                                                        echo esc_html( $formatted );
                                                    } else {
                                                        echo __('No active license', SH_CD_SLUG);
                                                    }

                                                ?>
                                            </td>
                                        </tr>

                                        <?php if ( false === empty( $existing_license ) ): ?>
                                            <tr class="last">
                                                <th colspan="2"><?php echo __( 'Your Existing License', SH_CD_SLUG ); ?></th>
                                            </tr>
                                            <tr class="last">
                                                <td colspan="2"><textarea rows="5" style="width:100%"><?php echo esc_textarea( $existing_license ); ?></textarea></td>
                                            </tr>
                                            <tr class="last">
                                                <td colspan="2"><a href="<?php echo admin_url('admin.php?page=sh-cd-shortcode-variables-license&remove-license=true'); ?>" class="button-secondary delete-license"><?php echo __( 'Remove License', SH_CD_SLUG ); ?></a></td>
                                            </tr>

                                        <?php endif; ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="post-body" class="metabox-holder columns-3">
                        <div id="post-body-content">
                            <div class="meta-box-sortables ui-sortable">

                            </div>
                        </div>
                        <br class="clear">
                    </div>
                </div>

            <?php
        }
?>
