(function() {

    tinymce.PluginManager.add( 'sh_cd_tinymce_button', function( editor, url ) {

            editor.addButton( 'sh_cd_tinymce_button', {
            text: sh_cd_tinymce[ 'button-text' ],
            type: 'menubutton',
            icon: false,
                menu: [
                        {
                            text: 'Your shortcodes',
                            onclick: function() {

                                if ( true !== sh_cd_tinymce[ 'premium' ] ) {

                                    if( true === confirm( sh_cd_tinymce[ 'upgrade-text' ] ) ) {
                                        window.location.href = sh_cd_tinymce[ 'upgrade-url' ];
                                    }

                                } else {
                                    sh_cd_tinymce_popup( editor, sh_cd_tinymce[ 'values-your' ] );
                                }
                            }
                        },
                        {
                            text: 'Premade shortcodes',
                            onclick: function() {

                                if ( true !== sh_cd_tinymce[ 'premium' ] ) {

                                    if( true === confirm( sh_cd_tinymce[ 'upgrade-text' ] ) ) {
                                        window.location.href = sh_cd_tinymce[ 'upgrade-url' ];
                                    }

                                } else {
                                    sh_cd_tinymce_popup( editor, sh_cd_tinymce[ 'values-premade' ] );
                                }
                            }
                        }
                    ]
            });
    });

    /**
     * Render pop up
     * @param editor
     * @param values
     */
    function sh_cd_tinymce_popup( editor, values ) {

        editor.windowManager.open( {
            title:  sh_cd_tinymce[ 'dialog-title' ],
            width: 400,
            height:80,
            body: [
                {
                    type: 'listbox',
                    width: 400,
                    name: 'shortcode',
                    label: sh_cd_tinymce[ 'dialog-label' ],
                    'values': values
                }
                ],
            onsubmit: function( e ) {
                editor.insertContent( e.data.shortcode );
            }
        });
    }

})();