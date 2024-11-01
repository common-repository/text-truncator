<?php
/**
 * Text Truncator
 * 
 * http://en.michaeluno.jp/text-truncator/
 * Copyright (c) 2015 Michael Uno; Licensed GPLv2
 */

/**
 * Adds the 'Reet' form section to the 'General' tab.
 * 
 * @since        1
 */
class TextTruncator_AdminPage_Setting_General_Reset extends TextTruncator_AdminPage_Section_Base {
    
    /**
     * A user constructor.
     * 
     * @since        1
     * @return      void
     */
    protected function construct( $oFactory ) {}
    
    /**
     * Adds form fields.
     * @since        1
     * @return      void
     */
    public function addFields( $oFactory, $sSectionID ) {
    
        $_oOption = TextTruncator_Option::getInstance();    
        $oFactory->addSettingFields(
            $sSectionID, // the target section id
            array(
                'field_id'          => 'reset',
                'type'              => 'submit',
                'reset'             => true,
                'show_title_column' => false,
                'value'             => __( 'Reset', 'text-truncator' ),
            ),            
            array(
                'field_id'          => 'reset_on_uninstall',
                'type'              => 'checkbox',
                'show_title_column' => false,
                'label'             => __( 'Delete options on uninstall.', 'text-truncator' ),
            ),
            array()            
        );
    
    }
        
    
    /**
     * Validates the submitted form data.
     * 
     * @since        1
     */
    public function validate( $aInput, $aOldInput, $oAdminPage, $aSubmitInfo ) {
    
        $_bVerified = true;
        $_aErrors   = array();
        
        // An invalid value is found. Set a field error array and an admin notice and return the old values.
        if ( ! $_bVerified ) {
            $oAdminPage->setFieldErrors( $_aErrors );     
            $oAdminPage->setSettingNotice( __( 'There was something wrong with your input.', 'text-truncator' ) );
            return $aOldInput;
        }
                
        return $aInput;     
        
    }
   
}