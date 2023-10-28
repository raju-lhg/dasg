<?php 

class CAP_Listing_Page {
    public function __construct() {
        add_shortcode( 'cap_listing', array( $this, 'render_listing' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_bootstrap_for_listing_page' ) );
    }
    
    public function render_listing() {
        $api = new CAP_API_Handler();
        $listings = $api->get_listings();

        $items = $listings['listings'];
        $pageDate = $listings['page'];
        
        ob_start();
        ?>
        <div class="container"> <!-- Updated this to Bootstrap's container class -->
            <div class="row">
                <!-- Filters -->
                <div class="col-md-5">
                    <!-- Domain Selection -->
                    <div class="card mb-4">
                        <div class="card-header">Select Domain</div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item">All Domains</li>
                                <li class="list-group-item">Contract Opportunities</li>
                                <!-- ... add other domains here -->
                            </ul>
                        </div>
                    </div>

                    <!-- Keyword Search -->
                    <div class="card mb-4">
                        <div class="card-header">Filter By</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label>Keyword Search</label>
                                <input type="text" class="form-control" placeholder="e.g. 1606ON20Q002">
                            </div>
                            <div>
                                <label>Federal Organizations</label>
                                <select class="form-control">
                                    <option>Select Organization</option>
                                    <!-- ... add organization options here -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Listings -->
                <div class="col-md-7">
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div>
                            <span>Showing 1 - 25 of <?php echo $pageDate['totalElements'] ?> results</span>
                        </div>
                        <div>
                            <select class="form-control" style="width: auto;">
                                <option>Sort by Date Modified/Updated</option>
                                <!-- ... add other sort options here -->
                            </select>
                        </div>
                    </div>

                    <!-- List items -->
                    <?php foreach( $items as $item ): ?>
                        <div class="cap-listing-item card mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $item['title']; ?></h5>
                                <p class="card-text"><?php echo $item['descriptions'][0]['content']; ?></p>
                                <a href="<?php echo get_site_url(); ?>/?page_id=9&id=<?php echo $item['_id']; ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function enqueue_bootstrap_for_listing_page() {
        global $post;
        if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'cap_listing') ) {
            // Add Bootstrap CSS
            wp_enqueue_style( 'bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' );

            // Add Bootstrap JavaScript and Popper.js (optional)
            wp_enqueue_script( 'popper-js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js', array(), '', true );
            wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery', 'popper-js'), '', true );
        }
    }
}

new CAP_Listing_Page();
