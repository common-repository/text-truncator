<?php
/**
 * Text Truncator
 * 
 * http://en.michaeluno.jp/text-truncator/
 * Copyright (c) 2015 Michael Uno; Licensed GPLv2
 * 
 */

/**
 * Adds the `Settings` page.
 * 
 * @since        1
 */
class TextTruncator_AdminPage_Setting extends TextTruncator_AdminPage_Page_Base {


    /**
     * A user constructor.
     * 
     * @since        1
     * @return      void
     */
    public function construct( $oFactory ) {
        
        // Tabs
        new TextTruncator_AdminPage_Setting_Truncator( 
            $this->oFactory,
            $this->sPageSlug,
            array( 
                'tab_slug'  => 'truncator',
                'title'     => __( 'Truncator', 'text-truncator' ),
            )
        );        
        
        new TextTruncator_AdminPage_Setting_General( 
            $this->oFactory,
            $this->sPageSlug,
            array( 
                'tab_slug'  => 'general',
                'title'     => __( 'General', 'text-truncator' ),
            )
        );

    }   
    
    /**
     * Prints debug information at the bottom of the page.
     */
    public function replyToDoAfterPage( $oFactory ) {
            
        $_oOption = TextTruncator_Option::getInstance();
        if ( ! $_oOption->isDebug() ) {
            return;
        }
        echo "<h3 style='display:block; clear:both;'>" 
                . __( 'Debug Info', 'text-truncator' ) 
            .  "</h3>";
        $oFactory->oDebug->dump( $oFactory->getValue() );
        
    }
        
}
