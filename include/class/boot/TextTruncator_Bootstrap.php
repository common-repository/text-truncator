<?php
/**
 * Text Truncator
 * 
 * http://en.michaeluno.jp/text-truncator/
 * Copyright (c) 2015 Michael Uno
 * 
 */

/**
 * Loads the plugin.
 * 
 * @since       1
 */
final class TextTruncator_Bootstrap extends TextTruncator_AdminPageFramework_PluginBootstrap {
    
    /**
     * User constructor.
     */
    protected function construct()  {}        

        
    /**
     * Register classes to be auto-loaded.
     * 
     * @since        1
     */
    public function getClasses() {
        
        // Include the include lists. The including file reassigns the list(array) to the $_aClassFiles variable.
        $_aClassFiles   = array();
        $_bLoaded       = include( dirname( $this->sFilePath ) . '/include/class-list.php' );
        if ( ! $_bLoaded ) {
            return $_aClassFiles;
        }
        return $_aClassFiles;
                
    }

    /**
     * Sets up constants.
     */
    public function setConstants() {
    }    
    
    /**
     * Sets up global variables.
     */
    public function setGlobals() {
    }    
    
    /**
     * The plugin activation callback method.
     */    
    public function replyToPluginActivation() {

        $this->_checkRequirements();
        
    }
        
        /**
         * 
         * @since            3
         */
        private function _checkRequirements() {

            $_oRequirementCheck = new TextTruncator_AdminPageFramework_Requirement(
                TextTruncator_Registry::$aRequirements,
                TextTruncator_Registry::NAME
            );
            
            if ( $_oRequirementCheck->check() ) {            
                $_oRequirementCheck->deactivatePlugin( 
                    $this->sFilePath, 
                    __( 'Deactivating the plugin', 'text-truncator' ),  // additional message
                    true    // is in the activation hook. This will exit the script.
                );
            }        
             
        }    

        
    /**
     * The plugin activation callback method.
     */    
    public function replyToPluginDeactivation() {
        
        TextTruncator_WPUtility::cleanTransients( 
            array(
                TextTruncator_Registry::TRANSIENT_PREFIX,
                'apf_',
            )
        );
        
    }        
    
        
    /**
     * Load localization files.
     * 
     * @callback    action      init
     */
    public function setLocalization() {
        
        // This plugin does not have messages to be displayed in the front end.
        if ( ! $this->bIsAdmin ) { 
            return; 
        }
        
        load_plugin_textdomain( 
            TextTruncator_Registry::TEXT_DOMAIN, 
            false, 
            dirname( plugin_basename( $this->sFilePath ) ) . '/' . TextTruncator_Registry::TEXT_DOMAIN_PATH
        );
        
    }        
    
    /**
     * Loads the plugin specific components. 
     * 
     * @remark        All the necessary classes should have been already loaded.
     */
    public function setUp() {
        
        // This constant is set when uninstall.php is loaded.
        if ( defined( 'DOING_PLUGIN_UNINSTALL' ) && DOING_PLUGIN_UNINSTALL ) {
            return;
        }
            
        // Option Object - must be done before the template object.
        // The initial instantiation will handle formatting options from earlier versions of the plugin.
        TextTruncator_Option::getInstance();
     
        // Admin pages
        if ( $this->bIsAdmin ) {            
        
            new TextTruncator_AdminPage( 
                TextTruncator_Registry::$aOptionKeys[ 'setting' ], 
                $this->sFilePath 
            );

        }
        
        // CSS & Scripts
        if ( ! $this->bIsAdmin ) {
            new TextTruncator_ScriptLoader;
        }
        
    }

    
}