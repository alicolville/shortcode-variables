<?php

defined('ABSPATH') or die('Jog on!');

/**
 * Determine which page to show
 */
function sh_cd_pages_your_shortcodes() {

    echo '<h1>Your existing Shortcode Variables</h1>';

    switch ( $_GET['action'] ) {

        case 'add':
        case 'edit':
	        sh_cd_pages_your_shortcodes_edit();
            break;
        case 'delete':
            sh_cd_pages_your_shortcodes_list( 'delete');
            break;
        default:
	        sh_cd_pages_your_shortcodes_list();
    }

}

/**
 * Display all shortcodes
 */
function sh_cd_pages_your_shortcodes_list( $action = NULL ) {

	if ( false === current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	// Deleting a shortcode?
    if( 'delete' === $action && false === empty( $_GET['id'] ) ) {

	    $result = sh_cd_db_shortcodes_delete( (int) $_GET['id'] );

	    $message = ( true === $result ) ? 'Your shortcode has been deleted!' : 'There was an error deleting your shortcode!';

	    sh_cd_message_display( $message, ! $result );
	}

	?>

	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div>
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-3">
				<div id="post-body-content">
                    <div class="meta-box-sortables ui-sortable">
                        <div class="postbox">
                            <h3 class="hndle"><span>Your existing Shortcode Variables</span></h3>
                            <div style="padding: 0px 15px 0px 15px">
                                <p style="text-align: right">
                                    <a class="button-primary" href="<?php echo sh_cd_link_your_shortcodes_add() ?>">Add a new Shortcode Variable</a>
                                </p>
                                <table class="widefat sh-cd-table" width="100%">
                                    <tr class="row-title">
                                        <th class="row-title" width="15%">Slug</th>
                                        <th width="20%">Shortcode</th>
                                        <th width="*">Shortcode content</th>
                                        <th width="60px" align="middle">Enabled</th>
                                        <th width="70px" align="middle">Options</th>
                                    </tr>
                                    <?php

                                    $current_shortcodes = sh_cd_db_shortcodes_all();

                                    if ( false === empty( $current_shortcodes ) ) {

                                        $class = '';

                                        $link = sh_cd_link_your_shortcodes();

                                        foreach ( $current_shortcodes as $shortcode ) {

                                            $class = ($class == 'alternate') ? '' : 'alternate';

                                            printf(
                                                '<tr class="%1$s">
                                                    <td><a href="%2$s">%3$s</a></td>
                                                    <td>[%4$s slug="%3$s"]</td>
                                                    <td><textarea class="large-text">%5$s</textarea></td>
                                                    <td align="middle"><i class="fas %6$s"></i></td>
                                                    <td>
                                                        <a class="button button-small" href="%2$s"><i class="far fa-edit"></i></a>
                                                        <a class="button button-small" href="%7$s" onclick="return confirm(\'Are you sure you want to delete this shortcode?\');"><i class="fas fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>',
                                                $class,
                                                $link . '&action=edit&id=' . (int) $shortcode['id'],
                                                esc_html( $shortcode['slug'] ),
                                                SH_CD_SHORTCODE,
                                                esc_html( stripslashes( $shortcode['data'] ) ),
                                                ( 0 === (int) $shortcode['disabled'] ) ? 'fa-times' : 'fa-check',
                                                $link . '&action=delete&id=' . (int) $shortcode['id']
                                            );
                                        }
                                    }
                                    else {
                                        printf( '<tr><td colspan="4" align="center">You haven\'t created any shortcodes yet. <a href="%s">Add one now!</a></td></tr>', sh_cd_link_your_shortcodes_add() );
                                    }
                                    ?>
                                </table>
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

