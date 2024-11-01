(function($){
    $( document ).ready( function() {
        
        // parse the passed data
        if ( 'undefined' === typeof trunk8_enabler ) {
            return true;
        }
        $.each( trunk8_enabler, function( _iIndex, _aScrollbar ) {
                        
            if ( 'undefined' === typeof _aScrollbar[ 'selector' ] ) {
                return true; // continue
            }

            var _aSettings = {
                lines: Number( _aScrollbar[ 'lines' ] ),
                fill: _aScrollbar[ 'fill' ] 
                ? _aScrollbar[ 'fill' ] 
                : '&hellip;',
                side: _aScrollbar[ 'side' ],
                tooltip: -1 !== $.inArray( _aScrollbar[ 'tooltip' ], [ "1", "true", "True", 1, true ] ),
                width: 'auto' === _aScrollbar[ 'width' ]
                    ? 'auto'                                 
                    : Number( _aScrollbar[ 'width' ] ),
                parseHTML: -1 !== $.inArray( _aScrollbar[ 'parseHTML' ], [ "1", "true", "True", 1, true ] ),
            };

            // Initialize the scrollbar.
            $( _aScrollbar[ 'selector' ] ).trunk8( _aSettings );

            // if ( 1 === _aSettings[ 'lines' ] ) {
                // $( _aScrollbar[ 'selector' ] ).css( 'white-space', 'nowrap' );
                // $( _aScrollbar[ 'selector' ] ).css( 'overflow', 'hidden' );
                // $( _aScrollbar[ 'selector' ] ).css( 'text-overflow', 'ellipsis' );
            // }
            
            $.each( _aScrollbar[ 'inline_css' ], function( _iIndex, _aInlineCSS ) {
                
                // Check if values are set.
                if ( 'undefined' === typeof _aInlineCSS[ 'property' ] ) {
                    return true; // continue
                }                
                if ( 'undefined' === typeof _aInlineCSS[ 'value' ] ) {
                    return true; // continue
                }                

                $( _aScrollbar[ 'selector' ] ).css(
                    _aInlineCSS[ 'property' ],
                    _aInlineCSS[ 'value' ]
                );
                
            } );
            
            
        });            
        
    });
    
}(jQuery))