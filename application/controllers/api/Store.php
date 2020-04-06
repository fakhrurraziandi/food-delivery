<?php 

require_once('AuthenticatedRestController.php');

class Store extends AuthenticatedRestController{

    public function index_get()
    {

        $current_lat = $this->input->get('current_lat');
        $current_lng = $this->input->get('current_lng');
        $radius = 10; // km
        $keyword = $this->input->get('keyword');

        $sql = "SELECT * FROM stores";
        
        /* 
        TODO
        -- Query for keyword search
        -- Query for location search with radius
         */

        $query = $this->db->query($sql);
        $stores = $query->result();

        $this->response([
            'status' => true,
            'data' => [
                'stores' => $stores
            ]
        ], 200);
    }

}