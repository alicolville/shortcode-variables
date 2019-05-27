<?php

defined('ABSPATH') or die('Jog on!');

function sh_cd_pages_your_shortcodes_edit( $action = 'add' ) {

    if ( false === in_array( $action, [ 'add', 'edit', 'save' ] ) ) {
	    return;
	}

	if ( false === current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	$save_result = false;

	// Saving / Inserting a shortcode?
	if ( $action == 'save' ) {

		$save_result = sh_cd_shortcodes_save_post();

		$message = ( true === $save_result ) ? 'Your shortcode has been saved!' : 'There was an error saving your shortcode!';

		sh_cd_message_display( $message, ! $save_result );
	}

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
                            <h3 class="hndle"><span>Add / Edit a shortcode</span></h3>
                            <div style="padding: 0px 15px 0px 15px">
                            <?php

                                if ( true === $save_result ) :

                                    printf('<p>Your shortcode has been saved successfully. <a href="%s">Return to all shortcodes</a>.',
                                        sh_cd_link_your_shortcodes() );

                                else:
                                ?>
                                    <form method="post" action="<?php echo sh_cd_link_your_shortcodes() . '&action=save'; ?>">
                                        <input type="hidden" id="id" name="id" value="<?php echo esc_attr( $shortcode['id'] ); ?>" />
                                        <h4>Slug</h4>
                                        <p><small>Specify the unique identifier for this shortcode.</small></p>
                                        <input type="text" required class="regular-text" size="100" id="slug" name="slug"
                                                placeholder="Slug"
                                                    value="<?php echo esc_attr( $shortcode['slug'] )?>" />
                                        <?php

                                            $previous_slug = ( false === empty( $shortcode['previous_slug'] ) ) ? $shortcode['previous_slug'] : $shortcode['slug'];

                                        ?>
                                        <input type="hidden" id="previous_slug" name="previous_slug" value="<?php echo esc_attr( $previous_slug )?>" />

                                        <h4>Shortcode content</h4>
                                        <p><small>Specify the text, HTML, media, data, etc that should be rendered wherever the shortcode is placed.</small></p>
                                        <?php wp_editor( $shortcode['data'], 'data', [ 'textarea_name' => 'data' ] ); ?>

                                        <h4>Disable?</h4>
                                        <p>If disabled, nothing will be rendered where the shortcode has been placed.</p>
                                        <select id="disabled" name="disabled">
                                            <option value="0" <?php selected( $shortcode['disabled'], 0 ); ?>>No</option>
                                            <option value="1" <?php selected( $shortcode['disabled'], 1 ); ?>>Yes</option>
                                        </select>
<!-- TODO: This is a PRO feature! -->


                                        <h4>Global?</h4>
                                        <p>Can this be used by all sites within your multi-site? If Yes, your shortcode will be promoted so it can be used across your entire multi site.</p>
                                        <select id="multisite" name="multisite">
                                            <option value="0" <?php selected( $shortcode['multisite'], 0 ); ?>>No</option>
                                            <option value="1" <?php selected( $shortcode['multisite'], 1 ); ?>>Yes</option>
                                        </select>

                                        <p><small>Please note, shortcode slugs are not unique across a multi site. Therefore, if you have two shortcodes with the same slug, the shortcode created or updated most recently will replace a multi site shortcode with the same slug.</small></p>


                                        <div class="sh-cd-button-row">
                                            <a class="comment-submit button" href="<?php echo sh_cd_link_your_shortcodes(); ?>">Cancel</a>
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

