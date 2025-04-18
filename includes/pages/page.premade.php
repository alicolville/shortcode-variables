<?php

defined('ABSPATH') or die('Jog on!');

function sh_cd_premade_shortcodes_page() {

	sh_cd_permission_check();

	?>

	<div class="wrap">

		<div id="icon-options-general" class="icon32"></div>

		<div id="poststuff">

			<div id="post-body" class="metabox-holder columns-3">

				<!-- main content -->
				<div id="post-body-content">

					<div class="meta-box-sortables ui-sortable">
						<div class="postbox">
							<h3 class="postbox-header">
								<span>
									<?php echo __( 'Pre-made Snippet Shortcodes', SH_CD_SLUG ); ?>
								</span>
                        	</h3>
							<div style="padding: 0px 15px 0px 15px">

								<p><?php echo __('Below is a list of premade Snippet Shortcodes that you can use throughout your website.', SH_CD_SLUG ); ?>
									<strong><?php echo __('Suggestions', SH_CD_SLUG ); ?>:</strong>
									<?php echo __('Please email shortcode suggestions to ', SH_CD_SLUG ); ?><a href="mailto:email@yeken.uk">email@yeken.uk</a></p>
                                <h3><?php echo __('Premade Shortcodes', SH_CD_SLUG ); ?></h3>
								<?php echo sh_cd_display_premade_shortcodes(); ?>
								<br />
								<p><?php echo __( '<strong> Suggestion?</strong> Got an idea for a premade tag? If so, email me at: ', SH_CD_SLUG ) . '<a href="mailto:email@yeken.uk">email@yeken.uk</a>'; ?> </p>
							</div>
						</div>


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
