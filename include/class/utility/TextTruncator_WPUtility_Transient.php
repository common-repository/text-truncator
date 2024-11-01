<?php
/**
 * Text Truncator
 * 
 * http://en.michaeluno.jp/text-truncator/
 * Copyright (c) 2015 Michael Uno
 * 
 */

 /**
  * Deals with WordPress transients.
  * @since      2
  * @since      3       Changed the name from `TextTruncator_WPUtility_Transient`.
  */
class TextTruncator_WPUtility_Transient extends TextTruncator_Utility {

    /**
     * Deletes transient items by prefix of a transient key.
     * 
     * @since   1
     * @remark  for the deactivation hook. Also used by the Clear Caches submit button.
     */
    public static function cleanTransients( $asPrefixes=array( 'CSB' ) ) {    

        // This method also serves for the deactivation callback and in that case, an empty value is passed to the first parameter.
        $_aPrefixes = is_array( $asPrefixes )
            ? $asPrefixes
            : ( array ) $asPrefixes;
        
        foreach( $_aPrefixes as $_sPrefix ) {
            $GLOBALS['wpdb']->query( "DELETE FROM `" . $GLOBALS['table_prefix'] . "options` WHERE `option_name` LIKE ( '_transient_%{$_sPrefix}%' )" );
            $GLOBALS['wpdb']->query( "DELETE FROM `" . $GLOBALS['table_prefix'] . "options` WHERE `option_name` LIKE ( '_transient_timeout_%{$_sPrefix}%' )" );
        }
    
    }

}