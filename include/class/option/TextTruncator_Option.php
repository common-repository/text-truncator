<?php
/**
 * Text Truncator
 * 
 * http://en.michaeluno.jp/text-truncator/
 * Copyright (c) 2015 Michael Uno
 * 
 */

/**
 * Handles plugin options.
 * 
 * @since       1
 */
class TextTruncator_Option extends TextTruncator_Option_Base {

    /**
     * Stores instances by option key.
     * 
     * @since        1
     */
    static public $aInstances = array(
        // key => object
    );
        
    /**
     * Stores the default values.
     */
    public $aDefault = array(
    
        'reset'     => array(
            'reset_on_uninstall'    => false,
        ),
        
        'truncates' => array(
            0   => array(
                'status'    => true,    // or false
                'name'      => '', // just a label for the user to remember
                
                // trunk8 options
                'selector'  => '',
                'lines'     => null,
                'fill'      => '...', // the suffix after the truncated text
                'parseHTML' => false,
                'width'     => 0, // 0 will be converted to 'auto'
                'tooltip'   => true,
                'side'      => 'right', // e.g. 'center', 'left'
                
                'inline_css'    => array(),
            ),
        ),
    );
         
    /**
     * Returns the instance of the class.
     * 
     * This is to ensure only one instance exists.
     * 
     * @since      3
     */
    static public function getInstance( $sOptionKey='' ) {
        
        $sOptionKey = $sOptionKey 
            ? $sOptionKey
            : TextTruncator_Registry::$aOptionKeys[ 'setting' ];
        
        if ( isset( self::$aInstances[ $sOptionKey ] ) ) {
            return self::$aInstances[ $sOptionKey ];
        }
        $_sClassName = apply_filters( 
            TextTruncator_Registry::HOOK_SLUG . '_filter_option_class_name',
            __CLASS__ 
        );
        self::$aInstances[ $sOptionKey ] = new $_sClassName( $sOptionKey );
        return self::$aInstances[ $sOptionKey ];
        
    }         
        
    /**
     * Checks whether the plugin debug mode is on or not.
     * @return      boolean
     */ 
    public function isDebug() {
        return defined( 'WP_DEBUG' ) && WP_DEBUG;
    }
    
}