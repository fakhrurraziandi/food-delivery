<?php 

require_once('AuthenticatedRestController.php');

class Store extends AuthenticatedRestController{

    public function index_get()
    {

        $current_lat = $this->input->get('current_lat');
        $current_lng = $this->input->get('current_lng');
        $keyword = $this->input->get('keyword');

        $sql = "SELECT * FROM stores";

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