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

function sh_cd_get_slug($text)
{
    if(!empty($text))
    {
        $text = sanitize_title($text);

        $original_slug = $text;

        $try = 1;

        // If slug exists, then fetch a unique one!
        //  v1.1: and ensure slug isn't a preset
        while (!sh_cd_is_slug_unique($text))
        {
            $text = $original_slug . '_' . $try;

            $try++;
        }
    }

    return $text;
}

function sh_cd_is_slug_unique($slug)
{
    if (!is_admin() || empty($slug))
        return false;

    // 1.1 Ensure slug is not a prefix
    //if (sh_cd_is_shortcode_preset($slug))
      //  return false;

    global $wpdb;

    $sql = $wpdb->prepare('SELECT count(slug) FROM ' . $wpdb->prefix . SH_CD_TABLE . ' where slug = %s', $slug);

    $row = $wpdb->get_var( $sql );

    if(0 == $row)
    {
        return true;
    }
    else
    {
        return false;
    }


}



function sh_cd_display_message($text, $error = false)
{
    if (!empty($text))
    {
        $class = (($error) ? 'error' : 'updated');

        echo '<div class="' . $class . '">
                <p>' . $text . '</p>
            </div>';
    }
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

function sh_cd_get_cache($key)
{
    $key = sh_cd_generate_cache_key($key);

    return get_transient($key);
}
function sh_cd_set_cache($key, $data)
{
    $key = sh_cd_generate_cache_key($key);

    set_transient($key, $data, 1 * HOUR_IN_SECONDS );
}

/**
 * Delete cache for given shortcode slug / ID
 *
 * @param $slug_or_key
 */
function sh_cd_cache_delete_by_slug_or_key( $slug_or_key ) {

    if ( true === is_numeric( $slug_or_key ) ) {

        sh_cd_delete_cache( sh_cd_db_shortcodes_get_slug_by_id( $slug_or_key ) );

    } else {
	    sh_cd_delete_cache( $slug_or_key );
    }
}

function sh_cd_delete_cache($key)
{
    $key = sh_cd_generate_cache_key($key);

    return delete_transient($key);
}
function sh_cd_generate_cache_key($key)
{
    return SH_CD_SHORTCODE . $key;
}
