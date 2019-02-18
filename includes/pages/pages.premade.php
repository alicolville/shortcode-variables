<?php

defined('ABSPATH') or die('Jog on!');

function sh_cd_premade_shortcodes_page() {

    $premium_user = sh_cd_license_is_premium();
	$upgrade_link = sprintf( '<a class="button" href="%s"><i class="fas fa-check"></i> Upgrade now</a>', sh_cd_license_upgrade_link() );

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
                                <h3>Free Shortcodes</h3>
								<table class="widefat sh-cd-table" width="100%">
									<tr class="row-title">
										<th class="row-title" width="30%">Shortcode to embed</th>
                                        <th class="row-title">Premium</th>
                                        <th width="*">Description</th>
									</tr>
									<?php

									$class = '';

									foreach ( sh_cd_presets_both_lists() as $key => $data ):

										$class = ($class == 'alternate') ? '' : 'alternate';

										$shortcode = '[' . SH_CD_SHORTCODE. ' slug="' . $key . '"]';

										$premium_shortcode = ( true === $data['premium'] );


										?>
										<tr class="<?php echo $class; ?>">
											<td><?php echo $shortcode; ?></td>
                                            <?php
	                                            printf( '<td align="middle">%s%s</td>',
                                                    ( true === $premium_shortcode && true === $premium_user ) ? '<i class="fas fa-check"></i>' : '',
                                                    ( true == $premium_shortcode && false === $premium_user ) ? $upgrade_link : ''
                                                );
	                                        ?>
											<td><?php echo $data['description']; ?></td>
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
