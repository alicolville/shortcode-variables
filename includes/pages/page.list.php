<?php

defined('ABSPATH') or die('Jog on!');

/**
 * Determine which page to show
 */
function sh_cd_pages_your_shortcodes() {

    $action = ( false === empty( $_GET['action'] ) ) ? $_GET['action'] : NULL;

	$save_result = NULL;

	// Do we have a save event?
	if ( 'save' === $action ) {

		check_admin_referer( 'save-shortcode' );

		$save_result = false;

		if ( false === empty( $_POST[ 'id'] ) ||
			  	false === sh_cd_reached_free_limit() ) {
			$save_result = sh_cd_shortcodes_save_post();

			// Success?
			if ( true === $save_result ) {
				$action = 'list';
			}
		}
	}

    switch ( $action ) {

        case 'add':
        case 'edit':
		case 'save':
	        sh_cd_pages_your_shortcodes_edit( $action, $save_result );
            break;
        default:
	        sh_cd_pages_your_shortcodes_list( $action, $save_result );
    }

}

/**
 * Display all shortcodes
 * @param null $action
 * @param null $save_result
 */
function sh_cd_pages_your_shortcodes_list($action = NULL, $save_result = NULL) {

	sh_cd_permission_check();

	// Cloning a shortcode?
    if ( 'clone' === $action && false === empty( $_GET['id'] ) ) {
	    sh_cd_clone( (int) $_GET['id'] );
    }

	if ( true == $save_result ) {
		sh_cd_message_display( __( 'Your shortcode has been saved!', SH_CD_SLUG ) );
	}

	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div>
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-3">
				<div id="post-body-content">
                    <div class="meta-box-sortables ui-sortable">
                        <div class="postbox">
							<h3 class="postbox-header">
								<span>
									<?php echo __( 'Your existing Snippet Shortcodes', SH_CD_SLUG ); ?>
								</span>
                        	</h3>
                            <div style="padding: 0px 15px 0px 15px">
								<table width="100%" style="margin-top: 10px">
									<tr>
										<td>
											<?php

												if ( false === SH_CD_IS_PREMIUM ) {
													printf( '%s %d %s %d %s. <a href="%s">%s</a>',
														__( 'Used', SH_CD_SLUG ),
														sh_cd_db_shortcodes_count(),
														__( 'of', SH_CD_SLUG ),
														SH_CD_FREE_SHORTCODE_LIMIT,
														__( 'shortcodes', SH_CD_SLUG ),
														sh_cd_license_upgrade_link(),
														__( 'Go unlimited!', SH_CD_SLUG )
													);
												}

											?>
										</td>
										<td align="right">
											<?php
												if ( false === SH_CD_IS_PREMIUM ) {
													sh_cd_upgrade_button( 'sh-cd-hide', sh_cd_license_upgrade_link() );
												}

												sc_cd_display_add_button();
											?>
										</td>
									</tr>
								</table>
                                <p style="text-align: right">

                                </p>
                                <table class="widefat sh-cd-table" width="100%">
                                    <tr class="row-title">
                                        <th class="row-title" width="20%"><?php echo __( 'Shortcode', SH_CD_SLUG ); ?></th>
                                        <th width="*"><?php echo __( 'Shortcode content', SH_CD_SLUG ); ?></th>
                                        <th width="60px" align="middle"><?php echo __( 'Global', SH_CD_SLUG ); ?></th>
                                        <th width="60px" align="middle"><?php echo __( 'Enabled', SH_CD_SLUG ); ?></th>
                                        <th width="70px" align="middle"><?php echo __( 'Options', SH_CD_SLUG ); ?></th>
                                    </tr>
                                    <?php

									printf(	'<tr class="sh-cd-hide" id="sh-cd-add-inline">
												<td><input type="text" maxlength="100" placeholder="%1$s" id="sh-cd-add-inline-slug" /></td>
												<td align="right">
													<textarea class="large-text inline-text-shortcode" id="sh-cd-add-inline-text"></textarea>
													<label for="sh-cd-add-inline-clear" >%3$s </label><input type="checkbox" id="sh-cd-add-inline-clear" value="true" checked="checked" />
												</td>
												<td align="middle"><input type="checkbox" id="sh-cd-add-inline-global" value="true" /></td>
												<td align="middle"><input type="checkbox" id="sh-cd-add-inline-enabled" value="true" checked="checked" /></td>
												<td width="100">
													<a class="button button-small sh-cd-inline-add-button" id="sh-cd-add-button" %5$s><i class="fas fa-save"></i> %2$s</a>
												</td>
											</tr>
											<tr class="sh-cd-hide" id="sh-cd-add-inline-results">
												<td></td>
												<td cospan="4" id="sh-cd-add-inline-results-text">
													<p><strong>%4$s:</strong></p>
													<span></span>
												</td>
											</tr>

											',
											__( 'Slug', SH_CD_SLUG ),
											__( 'Add', SH_CD_SLUG ),
											__( 'Clear form after save', SH_CD_SLUG ),
											__( 'Shortcode(s) added (refresh page to edit)', SH_CD_SLUG ),
											( false === SH_CD_IS_PREMIUM ) ? ' disabled="disabled"' : ''
									);

                                    $current_shortcodes = sh_cd_db_shortcodes_all();

                                    if ( false === empty( $current_shortcodes ) ) {

                                        $class 			= '';
                                        $link 			= sh_cd_link_your_shortcodes();
                                        $i 				= 0;
                                        $limit_reached 	= sh_cd_reached_free_limit();

                                        foreach ( $current_shortcodes as $shortcode ) {

                                            $class = ($class == 'alternate') ? '' : 'alternate';

                                            $id = (int) $shortcode['id'];

                                            printf(	'<tr class="%1$s" id="sh-cd-row-%8$s">
														<td><a href="%2$s">[%4$s slug="%3$s"]</a></td>
														<td align="right">
															<textarea class="large-text inline-text-shortcode sh-cd-toggle-%13$s" id="sh-cd-text-area-%8$d" data-id="%8$d" %13$s>%5$s</textarea>
															<a class="button button-small sh-cd-inline-save-button sh-cd-toggle-%13$s" id="sh-cd-save-button-%8$d" data-id="%8$d" %13$s><i class="fas fa-save"></i> %11$s</a>
														</td>
														<td align="middle"><a class="button button-small toggle-multisite sh-cd-toggle-%13$s" id="sc-cd-multisite-%8$s" data-id="%8$s" %13$s ><i class="fas %10$s"></i></a></td>
														<td align="middle"><a class="button button-small toggle-disable sh-cd-toggle-%13$s" id="sc-cd-toggle-%8$s" data-id="%8$s" %13$s ><i class="fas %6$s"></i></a></td>
														<td width="100">
															<a class="button button-small sh-cd-toggle-%13$s" %13$s href="%9$s"><i class="far fa-clone"></i></a>
															<a class="button button-small" href="%2$s"><i class="far fa-edit"></i></a>
															<a class="button button-small delete-shortcode" data-id="%8$s"><i class="fas fa-trash-alt"></i></a>
														</td>
													</tr>',
													$class,
													$link . '&action=edit&id=' . $id,
													esc_html( $shortcode['slug'] ),
													SH_CD_SHORTCODE,
													( true === SH_CD_IS_PREMIUM ) ? esc_html( stripslashes( $shortcode['data'] ) ) : __( 'Upgrade for inline editing and toggles.', SH_CD_SLUG ),
													( 1 === (int) $shortcode['disabled'] ) ? 'fa-times' : 'fa-check',
													$link . '&action=delete&id=' . $id,
													$id,
													( true === SH_CD_IS_PREMIUM ) ? $link . '&action=clone&id=' . $id : sh_cd_license_upgrade_link(),
													( 1 === (int) $shortcode['multisite'] ) ? 'fa-check' : 'fa-times',
													__( 'Save', SH_CD_SLUG ),
													__( 'Are you sure you want to delete this shortcode?', SH_CD_SLUG ),
													( false === SH_CD_IS_PREMIUM ) ? 'disabled' : '',
													( true === $limit_reached && $i > SH_CD_FREE_SHORTCODE_LIMIT ) ? 'disabled' : ''
                                            );

                                            $i++;
                                        }
                                    }
                                    else {
                                        printf( '<tr><td colspan="5" align="center">%1$s. <a href="%2$s">%3$s</a></td></tr>',
												__( 'You haven\'t created any shortcodes yet', SH_CD_SLUG ),
												sh_cd_link_your_shortcodes_add(),
												__( 'Add one now!', SH_CD_SLUG )
										);
                                    }
                                    ?>
                                </table>
								<p style="text-align: right">
									<?php sc_cd_display_add_button( false ); ?>
								</p>
                                <br clear="all" />
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Render button for adding a shortcode
 *
 * @param bool $show_quick_add
 */
function sc_cd_display_add_button( $show_quick_add = true ) {

	$limit_reached = sh_cd_reached_free_limit();

	if ( true === $show_quick_add ) {
		printf( '&nbsp;<a class="button-primary button-add-inline">%1$s</a>', __( 'Quick Add', SH_CD_SLUG ) );
	}

	printf( '&nbsp;<a class="button-primary" href="%1$s">%2$s</a>',
		( false === $limit_reached ) ? sh_cd_link_your_shortcodes_add() : sh_cd_license_upgrade_link(),
		( false === $limit_reached ) ? __( 'Add via Editor', SH_CD_SLUG ) : __( 'You must upgrade to add more shortcodes', SH_CD_SLUG )
	);
}
