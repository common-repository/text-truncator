<?php
/**
 * Text Truncator
 * 
 * Demonstrates the usage of Admin Page Framework.
 * 
 * http://en.michaeluno.jp/amazon-auto-inks/
 * Copyright (c) 2015 Michael Uno; Licensed GPLv2
 * 
 */

/**
 * A base class that provides methods to display readme file contents.
 * 
 * @sicne       3       Extends `TextTruncator_AdminPage_Tab_Base`.
 * @extends     TextTruncator_AdminPage_Tab_Base
 */
abstract class TextTruncator_AdminPage_Tab_ReadMeBase extends TextTruncator_AdminPage_Tab_Base {
        
    /**
     * 
     * @since        1
     */
    protected function _getReadmeContents( $sFilePath, $sTOCTitle, $asSections=array() ) {
        
        $_oWPReadmeParser = new TextTruncator_AdminPageFramework_WPReadmeParser( 
            $sFilePath,
            array(
                '%PLUGIN_DIR_URL%'  => TextTruncator_Registry::getPluginURL(),
                '%WP_ADMIN_URL%'    => admin_url(),
            )
        );    
        $_sContent = '';
        foreach( ( array ) $asSections as $_sSection  ) {
            $_sContent .= $_oWPReadmeParser->getSection( $_sSection );  
        }        
        if ( $sTOCTitle ) {            
            $_oTOC = new TextTruncator_AdminPageFramework_TableOfContents(
                $_sContent,
                4,
                $sTOCTitle
            );
            return $_oTOC->get();        
        }
        return $_sContent;
        
    }
    
}