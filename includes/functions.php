<?php

defined('ABSPATH') or die('Jog on!');

/**
 * Replace user parameters within a shortcode e.g. look for %%parameter%% and replace
 *
 * @param $shortcode
 * @param $user_defined_parameters
 *
 * @return mixed
 */
function sh_cd_apply_user_defined_parameters( $shortcode, $user_defined_parameters ){

    // Ensure we have something to do!
    if ( true === empty( $user_defined_parameters ) || false === is_array( $user_defined_parameters ) ) {
        return $shortcode;
    }

    foreach ( $user_defined_parameters as $key => $value ) {
        $shortcode = str_replace( '%%' . $key . '%%', $value, $shortcode );
    }

	return $shortcode;
}

/**
 * Generate a unique slug
 *
 * @param $slug
 *
 * @return string
 */
function sh_cd_slug_generate( $slug ) {

    if ( true === empty( $slug ) ) {
        return NULL;
    }

	$slug = sanitize_title( $slug );

    $original_slug = $slug;

    $try = 1;

    // Ensure the slug is unique
    while ( false === sh_cd_slug_is_unique( $slug ) ) {

	    $slug = sprintf( '%s_%d', $original_slug, $try );

        $try++;
    }

    return $slug;
}

/**
 * Display message in admin UI
 *
 * @param $text
 * @param bool $error
 */
function sh_cd_message_display( $text, $error = false ) {

    if ( true === empty( $text ) ) {
        return;
    }

    printf( '<div class="%s"><p>%s</p></div>',
            true === $error ? 'error' : 'updated',
            esc_html( $text )
    );
}

function sh_cd_create_dialog_jquery_code($title, $message, $class_used_to_prompt_confirmation, $js_call = false)
{
	global $wp_scripts;
	$queryui = $wp_scripts->query('jquery-ui-core');
	$url = "//ajax.googleapis.com/ajax/libs/jqueryui/".$queryui->ver."/themes/smoothness/jquery-ui.css";
	wp_enqueue_script( 'jquery-ui-dialog' );
	wp_enqueue_style('jquery-ui-smoothness', $url, false, null);

    $id_hash = md5($title . $message . $class_used_to_prompt_confirmation);

    ?>
    <div id='<?php echo $id_hash; ?>' title='<?php echo $title; ?>'>
      <p><?php echo $message; ?></p>
    </div>
     <script>
          jQuery(function($) {

            var $info = $('#<?php echo $id_hash; ?>');

            $info.dialog({
                'dialogClass'   : 'wp-dialog',
                'modal'         : true,
                'autoOpen'      : false
            });

            $('.<?php echo $class_used_to_prompt_confirmation; ?>').click(function(event) {

                event.preventDefault();

                target_url = $(this).attr('href');

                var $info = $('#<?php echo $id_hash; ?>');

                $info.dialog({
                    'dialogClass'   : 'wp-dialog',
                    'modal'         : true,
                    'autoOpen'      : false,
                    'closeOnEscape' : true,
                    'buttons'       : {
                        'Yes': function() {

                            <?php if ($js_call != false): ?>
                                <?php echo $js_call; ?>

                                $(this).dialog('close');
                            <?php else: ?>
                                window.location.href = target_url;
                            <?php endif; ?>
                        },
                         'No': function() {
                            $(this).dialog('close');
                        }
                    }
                });

                 $info.dialog('open');
            });

        });




      </script>

  <?php
}

/**
 * Fetch cache item
 *
 * @param $key
 *
 * @return mixed
 */
function sh_cd_cache_get( $key ) {

    $key = sh_cd_cache_generate_key( $key );

    return get_transient( $key );
}

/**
 * Set cache item
 *
 * @param $key
 * @param $data
 */
function sh_cd_cache_set( $key, $data ) {

    $key = sh_cd_cache_generate_key( $key );

    set_transient( $key, $data, 1 * HOUR_IN_SECONDS );
}

/**
 * Delete cache for given shortcode slug / ID
 *
 * @param $slug_or_key
 */
function sh_cd_cache_delete_by_slug_or_key( $slug_or_key ) {

    if ( true === is_numeric( $slug_or_key ) ) {

        sh_cd_cache_delete( sh_cd_db_shortcodes_get_slug_by_id( $slug_or_key ) );

    } else {
	    sh_cd_cache_delete( $slug_or_key );
    }
}

/**
 * Delete cache item
 *
 * @param $key
 *
 * @return mixed
 */
function sh_cd_cache_delete( $key ) {

    $key = sh_cd_cache_generate_key( $key );

    return delete_transient( $key );
}

/**
 * Generate cache key
 *
 * @param $key
 *
 * @return string
 */
function sh_cd_cache_generate_key( $key ) {
    return SH_CD_SHORTCODE . $key;
}
