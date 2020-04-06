<?php

use chriskacerguis\RestServer\RestController;

class AuthenticatedRestController extends RestController{

    public function __construct()
    {
        parent::__construct();

        // Validating api_token
        $request_headers = $this->input->request_headers();
        
        if(isset($request_headers['Authorization']) && !empty($request_headers['Authorization'])){
            
            $auth_token = $request_headers['Authorization'];

            $query = $this->db->query("SELECT * FROM api_token WHERE token = ?", [
                'token' => $auth_token
            ]);

            if($query->num_rows() === 0){
                $this->response([
                    'status' => false,
                    'message' => 'Unauthenticated'
                ], 200);
            }
        }else{
            $this->response([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 200);
        }

        
    }
}