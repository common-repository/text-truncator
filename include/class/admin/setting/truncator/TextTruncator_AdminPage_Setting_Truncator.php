<?php
/**
 * Text Truncator
 * 
 * 
 * http://en.michaeluno.jp/text-truncator/
 * Copyright (c) 2015 Michael Uno; Licensed GPLv2
 * 
 */

/**
 * Adds the 'Scrollbars' tab to the 'Settings' page of the loader plugin.
 * 
 * @since        1
 * @extends     TextTruncator_AdminPage_Tab_Base
 */
class TextTruncator_AdminPage_Setting_Truncator extends TextTruncator_AdminPage_Tab_Base {
    
    /**
     * Triggered when the tab is loaded.
     */
    public function replyToLoadTab( $oAdminPage ) {
        
        // Form sections
        new TextTruncator_AdminPage_Setting_Truncator_Definition( 
            $oAdminPage,
            $this->sPageSlug, 
            array(
                'section_id'    => 'truncates',
                'tab_slug'      => $this->sTabSlug,
                'title'         => __( 'Truncate Definitions', 'text-truncator' ),
                'description'   => array(
                    __( 'Define truncates.', 'text-truncator' ),
                ),
                'collapsible'       => array(
                    'toggle_all_button' => array( 'top-left', 'bottom-left' ),
                    'container'         => 'section',
                    'is_collapsed'      => false,
                ),
                'repeatable'        => true, // this makes the section repeatable
            )
        );
      
    }
    
    public function replyToDoTab( $oFactory ) {
        echo "<div class='right-submit-button'>"
                . get_submit_button()  
            . "</div>";
    }
            
}
