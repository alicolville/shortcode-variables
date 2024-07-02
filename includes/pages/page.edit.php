<?php

defined('ABSPATH') or die('Jog on!');

function sh_cd_pages_your_shortcodes_edit( $action = 'add', $save_result = NULL ) {

    if ( false === in_array( $action, [ 'add', 'edit', 'save' ] ) ) {
	    return;
	}

	sh_cd_permission_check();

	// Saving / Inserting a shortcode?
	if ( false === $save_result ) {
		sh_cd_message_display(  __( 'There was an error saving your shortcode!' , SH_CD_SLUG ), ! $save_result );
	}
	global $wpdb;

	// Load
	$shortcode = ( false === empty( $_GET['id'] ) ) ?
		            sh_cd_db_shortcodes_by_id( (int) $_GET['id'] ) :
		                sh_cd_get_values_from_post( [ 'id', 'slug', 'previous_slug', 'data', 'disabled', 'multisite' ] );

	$shortcode['data']  = stripslashes( $shortcode['data'] );

	?>

	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div>
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-3">
				<div id="post-body-content">
					<div class="meta-box-sortables ui-sortable">
                        <div class="postbox">
							<div class="postbox-header">
                          	  <h2 class="hndle"><span><?php echo __( 'Add / Edit a shortcode', SH_CD_SLUG ); ?></span></h2>
							</div>
                            <div style="padding: 0px 15px 0px 15px">
                            <?php

                                if ( true === $save_result ) :

                                    printf('<p>%1$s.
														<a href="%2$s">%3$s</a>.
													</p>',
                                        			__( 'Your shortcode has been saved successfully', SH_CD_SLUG ),
                                        			sh_cd_link_your_shortcodes(),
													__( 'Return to all shortcodes', SH_CD_SLUG )
									);

                                else:
                                ?>
                                    <form method="post" action="<?php echo sh_cd_link_your_shortcodes() . '&action=save'; ?>">
										<input type="hidden" id="id" name="id" value="<?php echo esc_attr( $shortcode['id'] ); ?>" />
                                        <?php wp_nonce_field( 'save-shortcode' ); ?>
                                        
										<div class="sh-cd-button-row sh-cd-border-bottom">
											<a class="comment-submit button" href="<?php echo sh_cd_link_your_shortcodes(); ?>"><?php echo __( 'Cancel', SH_CD_SLUG ); ?></a>
											<input name="submit_button" type="submit" value="Save Shortcode" class="comment-submit button button-primary">
										</div>
                                        <h4><?php echo __( 'Slug', SH_CD_SLUG ); ?></h4>
                                        <p><small><?php echo __( 'Specify the unique identifier for this shortcode', SH_CD_SLUG ); ?>.</small></p>
                                        <input type="text" required class="regular-text" size="100" id="slug" name="slug"
                                                placeholder="Slug"
                                                    value="<?php echo esc_attr( $shortcode['slug'] )?>" />
                                        <?php

                                            $previous_slug = ( false === empty( $shortcode['previous_slug'] ) ) ? $shortcode['previous_slug'] : $shortcode['slug'];

                                        ?>
                                        <input type="hidden" id="previous_slug" name="previous_slug" value="<?php echo esc_attr( $previous_slug )?>" />

                                        <h4><?php echo __( 'Shortcode Content', SH_CD_SLUG ); ?></h4>
                                        <p><small><?php echo __( 'Specify the text, HTML, media, data, etc that should be rendered wherever the shortcode is placed.', SH_CD_SLUG ); ?></small></p>
                                        <?php wp_editor( $shortcode['data'], 'data', [ 'textarea_name' => 'data' ] ); ?>

                                        <h4><?php echo __( 'Disable?', SH_CD_SLUG ); ?></h4>
                                        <p><?php echo __( 'If disabled, nothing will be rendered where the shortcode has been placed.', SH_CD_SLUG ); ?></p>
                                        <select id="disabled" name="disabled">
                                            <option value="0" <?php selected( $shortcode['disabled'], 0 ); ?>><?php echo __( 'No', SH_CD_SLUG ); ?></option>
                                            <option value="1" <?php selected( $shortcode['disabled'], 1 ); ?>><?php echo __( 'Yes', SH_CD_SLUG ); ?></option>
                                        </select>

                                        <h4><?php echo __( 'Global?', SH_CD_SLUG ); ?></h4>

                                        <p><?php echo __( 'Can this be used by all sites within your multi-site? If Yes, your shortcode will be promoted so it can be used across your entire multi site. Please note, shortcode slugs are not unique across a multi site. Therefore, if you have two Global shortcodes with the same slug, the shortcode created or updated most recently shall be the one rendered. It is best practice to give all Global shortcodes a unique slug. A Global shortcode with always be displayed before a local shortcode with the same slug. Upon saving, it may take a Global shortcode upto 30 seconds to update across all your sites.', SH_CD_SLUG ); ?></p>
                                        <select id="multisite" name="multisite" <?php if ( false === SH_CD_IS_PREMIUM ) { echo 'disabled="disabled"'; } ?>>
                                            <option value="0" <?php selected( $shortcode['multisite'], 0 ); ?>><?php echo __( 'No', SH_CD_SLUG ); ?></option>
                                            <option value="1" <?php selected( $shortcode['multisite'], 1 ); ?>><?php echo __( 'Yes', SH_CD_SLUG ); ?></option>
                                        </select>
                                        <?php if ( false === SH_CD_IS_PREMIUM ) : ?>
                                            <p>
                                                <i class="far fa-credit-card"></i>
                                                <a href="<?php echo sh_cd_license_upgrade_link(); ?>">
													<?php echo __( 'Multi site support is for Premium users. Upgrade now.', SH_CD_SLUG ); ?>
                                                </a>
                                            </p>
                                        <?php endif; ?>

                                        <div class="sh-cd-button-row sh-cd-border-top">
                                            <a class="comment-submit button" href="<?php echo sh_cd_link_your_shortcodes(); ?>"><?php echo __( 'Cancel', SH_CD_SLUG ); ?></a>
                                            <input name="submit_button" type="submit" value="Save Shortcode" class="comment-submit button button-primary">
                                        </div>
                                    </form>
                                <?php endif; ?>
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

