<?php
/**
 * Text Truncator
 * 
 * http://en.michaeluno.jp/text-truncator/
 * Copyright (c) 2015 Michael Uno
 * 
 */

/**
 * Inserts custom CSS rules.
 * 
 * @since       1
 */
class TextTruncator_ScriptLoader extends TextTruncator_PluginUtility {
    
    /**
     * 
     */
    public $aTruncate = array();
    public $oOption;
    
    /**
     * Sets up properties and hooks
     */
    public function __construct() {
        
        if ( defined( 'DOING_CRON' ) && DOING_CRON ) {
            return;
        }
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            return;
        }
        
        $this->oOption     = TextTruncator_Option::getInstance();
        $this->aTruncate   = $this->getAsArray( $this->oOption->get( 'truncates' ) );
        $this->aTruncate   = $this->_getFormattedTruncateOptions(
            $this->aTruncate
        );

        if ( count( $this->aTruncate ) <= 0 ) {
            return;
        }        
        add_action( 'wp_enqueue_scripts', array( $this, 'replyToEnqueueScripts' ) );
        
    } 
        /**
         * @remark      Drops items with the Off status.
         * @return      array
         */
        private function _getFormattedTruncateOptions( array $aTruncate ) {
            foreach( $aTruncate as $_iIndex => &$_aTruncate ) {
                $_aTruncate = $_aTruncate + $this->oOption->aDefault[ 'truncates' ][ 0 ];
                if ( ! $_aTruncate[ 'status' ] ) {
                    unset( $aTruncate[ $_iIndex ] );
                    continue;
                }
                
                // Format options
                $_aTruncate[ 'width' ] = $_aTruncate[ 'width' ]
                    ? $_aTruncate[ 'width' ]
                    : 'auto';
            }
            return $aTruncate;
        }
    /**
     * @callback        action      wp_enqueue_scripts
     */
    public function replyToEnqueueScripts() {

        wp_enqueue_script( 
            'trunk8',     // handle id
            TextTruncator_Registry::getPluginURL( 
                '/asset/js/trunk8.js' 
            ), // file url            
            array( 'jquery' ),   // dependencies
            '',     // version
            true    // in footer? yes
        );
        wp_enqueue_script( 
            'trunk8_enabler',     // handle id
            TextTruncator_Registry::getPluginURL( 
                '/asset/js/trunk8-enabler.js'
            ), // script url
            array( 'trunk8' ),   // dependencies
            '',     // version
            true    // in footer? yes
        );
        wp_localize_script( 
            'trunk8_enabler',  // handle id - the above used enqueue handl id
            'trunk8_enabler',  // name of the data loaded in the script
            $this->aTruncate // translation array
        );         
        
    }
 
    
}