<?php

defined('ABSPATH') or die('Jog on!');

function sh_cd_premade_shortcodes_page() {

	?>

	<div class="wrap">

		<div id="icon-options-general" class="icon32"></div>

		<div id="poststuff">

			<div id="post-body" class="metabox-holder columns-3">

				<!-- main content -->
				<div id="post-body-content">

					<div class="meta-box-sortables ui-sortable">
						<div class="postbox">
							<h3 class="hndle"><span><?php _e( 'Pre-made Shortcode Variables' ); ?> </span></h3>
							<div style="padding: 0px 15px 0px 15px">
								<p><?php echo __('Below is a list of premade shortcode variables that you can use throughout your website.'); ?></p>
								<br />
								<table class="widefat sh-cd-table" width="100%">
									<tr class="row-title">
										<th class="row-title" width="30%"><?php echo __('Shortcode to embed'); ?></th>
										<th width="*"><?php echo __('Description'); ?></th>

									</tr>
									<?php

									$premade_shortcodes = sh_cd_shortcode_presets_free_list();

									$class = '';

									foreach ($premade_shortcodes as $key => $description):

										$class = ($class == 'alternate') ? '' : 'alternate';

										$shortcode = '[' . SH_CD_SHORTCODE. ' slug="' . $key . '"]';

										?>
										<tr class="<?php echo $class; ?>">
											<td><?php echo $shortcode; ?></td>
											<td><?php echo $description; ?></td>
										</tr>
									<?php endforeach; ?>
								</table>
								<br />
								<p><?php echo __('<strong> Suggestion?</strong> Got an idea for a premade tag? If so, email me at: ') . '<a href="mailto:email@yeken.uk">email@yeken.uk</a>'; ?> </p>
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
