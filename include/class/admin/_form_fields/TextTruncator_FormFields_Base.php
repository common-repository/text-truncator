<?php
/**
 * Text Truncator
 * 
 * http://en.michaeluno.jp/text-truncator/
 * Copyright (c) 2015 Michael Uno
 * 
 */

/**
 * Provides abstract methods for form fields.
 * 
 * @since       1
 */
abstract class TextTruncator_FormFields_Base extends TextTruncator_WPUtility {

    /**
     * Stores the option object.
     */
    public $oOption;
    

    public function __construct() {
        
        $this->oOption         = TextTruncator_Option::getInstance();
        
    }
    
    /**
     * Should be overridden in an extended class.
     * 
     * @remark      Do not even declare this method as parameters will be vary 
     * and if they are different PHP will throw errors.
     */
    // public function get() {}
  
}