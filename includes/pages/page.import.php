<?php

defined('ABSPATH') or die('Naw ya dinnie!');

function sh_cd_admin_page_import() {

	sh_cd_permission_check();

	wp_enqueue_media();

	$importing 	= false;
	$output		= '';

	if ( true === SH_CD_IS_PREMIUM &&
			false === empty( $_POST[ 'attachment-id' ] ) ){

		$importing 	= true;
		$dry_run	= ( false === empty( $_POST[ 'dry-run' ] ) );
		$output 	= sh_cd_import_csv( $_POST[ 'attachment-id' ], $dry_run );
	}

    ?>
    <div class="wrap sh-cd-csv-import ws-ls-admin-page">
    <div id="poststuff">
        <div id="post-body" class="metabox-holder">
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <?php
						if ( false === SH_CD_IS_PREMIUM ) {
							sh_cd_display_pro_upgrade_notice();
						}
                    ?>
                   <div class="postbox">
				  		<h3 class="postbox-header">
							<span>
								<?php echo __( 'Import CSV', SH_CD_SLUG ); ?>
							</span>
                        </h3>
					    <div class="inside">
                        	<?php if ( false === $importing ): ?>
								<div class="sh-cd-form-row">
									<p>
										<?php echo __( 'Please select a CSV file to import one or shortcodes into your collection.', SH_CD_SLUG ); ?>
										<a href="https://snippet-shortcodes.yeken.uk/csv-import.html" rel="noopener noreferrer" target="_blank"><?php echo __( 'Read more about CSV imports and the required format', SH_CD_SLUG ); ?>.</a>
									</p>
									<input id="select_csv" type="button" class="button" value="<?php echo __( 'Select CSV file', SH_CD_SLUG ); ?>" />
									<br />
								</div>
								<div class="sh-cd-hide sh-cd-import-selected" id="selected-form" >
									<form action="<?php echo admin_url( 'admin.php?page=sh-cd-import&mode=import'); ?>" method="post">
										<div class="sh-cd-form-row">
											<label for="attachment-path"><?php echo __( 'Selected file:', SH_CD_SLUG ); ?></label>
											<input type='text' name='attachment-path' id='attachment-path' value='' class="widefat" disabled="disabled" />
											<input type='hidden' name='attachment-id' id='attachment-id' value='' />
										</div>
										<div class="sh-cd-form-row">
											<input type='checkbox' name='dry-run' id='dry-run' value='yes' />
											<label for="dry-run"><?php echo __( 'Dry run mode. This will do basic tests on the file without performing an import.', SH_CD_SLUG ); ?></label>
										</div>
										<div class="sh-cd-form-row">
											<input type="submit" class="button button-primary" value="<?php echo __( 'Import CSV', SH_CD_SLUG ); ?>" <?php if ( false === SH_CD_IS_PREMIUM ) { echo 'disabled="disabled"'; } ?> />
										</div>
									</form>
								</div>
							<?php else: ?>
								<p><strong><?php echo __( 'Output:', SH_CD_SLUG ); ?></strong></p>
								<textarea class="widefat" rows="20" cols="100"><?php echo esc_html( $output ); ?></textarea>
							<?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>
	<script>
		jQuery( document ).ready(function ($) {

			// CSV import for
			let file_frame;

			$( '#select_csv').on('click', function( event ){

				event.preventDefault();

				<?php if ( false === SH_CD_IS_PREMIUM ) : ?>
					alert( '<?php echo __( "Please upgrade to bulk import shortcodes via CSV.", SH_CD_SLUG ); ?>' );
					return;
				<?php else: ?>

					// If the media frame already exists, reopen it.
					if ( file_frame ) {

						// Open frame
						file_frame.open();
						return;
					}

					// Create the media frame.
					file_frame = wp.media.frames.file_frame = wp.media({
						title: '<?php echo __( "Select a CSV", SH_CD_SLUG ); ?>',
						button: {
							text: '<?php echo __( "Use this file", SH_CD_SLUG ); ?>',
						},
						library : {
							type : ['application/csv', 'text/csv'],
						},
						multiple: false
					});

					// When an image is selected, run a callback.
					file_frame.on( 'select', function() {

						attachment = file_frame.state().get('selection').first().toJSON();

						$( '#attachment-id' ).val( attachment.id );
						$( '#attachment-path' ).val( attachment.url );
						$( '#selected-form' ).removeClass( 'sh-cd-hide' );

					});

					file_frame.open();

				<?php endif; ?>
			});
		});
	</script>
    <?php
}
