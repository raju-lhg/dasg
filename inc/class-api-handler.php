<?php 

class CAP_API_Handler {
    private $base_url = 'https://sam.gov/api/prod/';
    
    public function get_listings() { 
        $api_endpoint = $this->base_url . "sgs/v1/search/";

        $response = wp_remote_get(add_query_arg(array(
            'page' => 0,
            'index' => '_all',
            'random' => $this->generateRandomNumber(8),
            'size'=> 25,
            'q' => 611420
        ), $api_endpoint)); 

        if (is_wp_error($response)) {
            return 'Failed to fetch listings. ' . $response->get_error_message();
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        $results = [];
        if(isset($data['_embedded']) && isset($data['_embedded']['results'])){
            $results['listings'] = $data['_embedded']['results'];
            // Uncomment the next line if you want to return the page info as well
            $results['page'] = $data['page'];
        } 

        // var_dump($results['listings'][0]);

        return $results; 
    }
    
    public function get_details($entity_id) {
        $endpoint = $this->base_url . 'opps/v2/opportunities/' . $entity_id . "?random=" . $this->generateRandomNumber(10);
        $response = wp_remote_get($endpoint);

        if (is_wp_error($response)) {
            return 'Failed to fetch details. ' . $response->get_error_message();
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        // var_dump($data);

        // Here, we are assuming that the API returns the details directly.
        // If there's a nested structure, adjust this part accordingly.
        return $data;
    }

    public function generateRandomNumber($length) {
        $min = pow(10, $length - 1);
        $max = pow(10, $length) - 1;
        return rand($min, $max);
    }
}
