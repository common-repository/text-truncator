<?php
/**
 * Text Truncator
 * 
 * http://en.michaeluno.jp/amazon-auto-inks/
 * Copyright (c) 2015 Michael Uno; Licensed GPLv2
 */

/**
 * Provides an abstract base for bases.
 * 
 * @since        1
 */
abstract class TextTruncator_AdminPage_RootBase {
    
    /**
     * Stores callback method names.
     * 
     * @since   3
     */
    protected $aMethods = array(
        'replyToLoadPage',
        'replyToDoPage',
        'replyToDoAfterPage',
        'replyToLoadTab',
        'replyToDoTab',
        'validate',
    );

    /**
     * Handles callback methods.
     * @since        1
     * @return      mixed
     */
    public function __call( $sMethodName, $aArguments ) {
        
        if ( in_array( $sMethodName, $this->aMethods ) ) {
            return isset( $aArguments[ 0 ] ) 
                ? $aArguments[ 0 ] 
                : null;
        }       
        
        trigger_error( 
            TextTruncator_Registry::NAME . ' : ' . sprintf( 
                __( 'The method is not defined: %1$s', 'text-truncator' ),
                $sMethodName 
            ), 
            E_USER_WARNING 
        );        
    }
   
    /**
     * A user constructor.
     * @since        1
     * @return      void
     */
    protected function construct( $oFactory ) {}
    
}