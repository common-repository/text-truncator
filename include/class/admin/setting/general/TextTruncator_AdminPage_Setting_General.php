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
 * Adds the 'General' tab to the 'Settings' page of the loader plugin.
 * 
 * @since        1
 * @extends     TextTruncator_AdminPage_Tab_Base
 */
class TextTruncator_AdminPage_Setting_General extends TextTruncator_AdminPage_Tab_Base {
    
    /**
     * Triggered when the tab is loaded.
     */
    public function replyToLoadTab( $oAdminPage ) {
        
        // Form sections
        new TextTruncator_AdminPage_Setting_General_Reset( 
            $oAdminPage,
            $this->sPageSlug, 
            array(
                'section_id'    => 'reset',
                'tab_slug'      => $this->sTabSlug,
                'title'         => __( 'Reset', 'text-truncator' ),
            )
        );
      
    }
    
    public function replyToDoTab( $oFactory ) {
        echo "<div class='right-submit-button'>"
                . get_submit_button()  
            . "</div>";
    }
            
}
