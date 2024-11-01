<?php
/**
 * Text Truncator
 * 
 * http://en.michaeluno.jp/text-truncator/
 * Copyright (c) 2015 Michael Uno; Licensed GPLv2
 */

/**
 * Adds the 'Truncator' form section to the 'Truncator' tab.
 * 
 * @since        1
 */
class TextTruncator_AdminPage_Setting_Truncator_Definition extends TextTruncator_AdminPage_Section_Base {
    
    /**
     * A user constructor.
     * 
     * @since        1
     * @return      void
     */
    protected function construct( $oFactory ) {}
    
    /**
     * Adds form fields.
     * @since       1
     * @return      void
     */
    public function addFields( $oFactory, $sSectionID ) {
    
        $oFactory->addSettingFields(
            $sSectionID, // the target section id
            array(
                'field_id'         => 'name',
                'type'             => 'section_title',
                'before_input'     => "<strong>"
                    . __( 'Name', 'text-truncator' ) 
                    . "</strong>:&nbsp; ",
                'attributes'       => array(
                    'size'  => 30,
                ),
            ),            
            array(
                'field_id'         => 'status',
                'type'             => 'radio',
                'title'            => __( 'Status', 'text-truncator' ),
                'label'            => array(
                    1    => __( 'On', 'text-truncator' ),
                    0    => __( 'Off', 'text-truncator' ),
                ),
                'default'          => 1,
            ),                        
            array(
                'field_id'         => 'selector',
                'type'             => 'text',
                'title'            => __( 'Target Element Selector', 'text-truncator' ),
                'description'      => array(
                    __( 'Define the CSS (jQuery) target selector of the element.', 'text-truncator' ),
                    ' e.g. <code>aside.widget</code>',
                    __( 'For multiple selectors, delimit them by commas.', 'text-truncator' ),
                    ' e.g. <code>div.widget > ul, div.widget > div</code>',
                ),
                'attributes'       => array(
                    'size'  => 52,
                ),
            ),
            array(
                'field_id'          => 'lines',
                'type'              => 'number',
                'title'             => __( 'Number of Lines', 'text-truncator' ),
            ),   
            array(
                'field_id'          => 'fill',
                'type'              => 'text',
                'title'             => __( 'Fill', 'text-truncator' ),
                'description'       => __( 'The suffix appended to the truncated text.', 'text-truncator' ),
                'default'           => '...',
            ),  
            array(
                'field_id'          => 'side',
                'type'              => 'radio',
                'title'             => __( 'Side', 'text-truncator' ),
                'description'       => __( 'The side of the text from which to truncate.', 'text-truncator' ),
                'label'             => array(
                    'left'      => __( 'Left', 'text-truncator' ),
                    'center'    => __( 'Center', 'text-truncator' ),
                    'right'     => __( 'Right', 'text-truncator' ),
                ),
                'default'           => 'right',
            ),
            array(
                'field_id'          => 'tooltip',
                'type'              => 'checkbox',
                'title'             => __( 'Tooltip', 'text-truncator' ),
                'label'             => __( 'Set the <code>title</code> attribute of the targeted HTML element with the original untruncated string.', 'text-truncator' ),
                'default'           => true,
            ),            
            array(
                'field_id'          => 'width',
                'type'              => 'number',
                'title'             => __( 'Max Characters per Line', 'text-truncator' ),
                'description'       => array(
                    __( 'Force truncating text with the number set here.', 'text-truncator' ),
                    __( 'Set 0 to use the number of lines.', 'text-truncator' ),
                ),
                'default'           => 0,
            ),
            array(
                'field_id'          => 'parseHTML',
                'type'              => 'checkbox',
                'title'             => __( 'Preserve HTML Structure', 'text-truncator' ),
                'label'             => __( 'Parse and save html structure of the target elements and restore the structure in the truncated text.', 'text-truncator' ),
                'default'           => false,
            ),       

            array(
                'field_id'          => 'inline_css',
                'type'              => 'text',
                'title'             => __( 'Inline CSS Property Values', 'text-truncator' ),
                'label'             => array(
                    'property' => __( 'Property', 'text-truncator' ),
                    'value'    => __( 'Value', 'text-truncator' ),
                ),
                'attributes'        => array(
                    'field' => array(
                        'style' => 'width: 100%;'
                    ),
                ),
                'descriptions'      => array(
                    __( 'Apply these inline CSS rules to the target elements.', 'text-truncator' ),
                ),
                'repeatable'        => true,
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