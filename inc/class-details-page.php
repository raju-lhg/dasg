<?php 

// exclusion -> pirValue, pirKey
// "_type": "opportunity", _id
class CAP_Details_Page {
    public function __construct() {
        add_shortcode( 'cap_details', array( $this, 'render_details' ) );
    }
    
    public function render_details( $atts ) {
        $atts = shortcode_atts( array( 'id' => '' ), $atts );
    
        // If 'id' isn't set in the shortcode, fetch it from the URL.
        if ( empty( $atts['id'] ) ) {
            $atts['id'] = isset( $_GET['id'] ) ? sanitize_text_field( $_GET['id'] ) : '';
        }
        
        $api = new CAP_API_Handler();
        $details = $api->get_details( $atts['id'] );
        
        ob_start();
        ?>
        <div class="cap-container">
            Title : <?php  echo $details['data2']['title']?>
        </div>
        <?php
        return ob_get_clean();
    }
}
new CAP_Details_Page();
