<?php 

use chriskacerguis\RestServer\RestController;

class Auth extends RestController{

    public function __construct()
    {
        parent::__construct();
    }

    public function login_post()
    {

        $this->form_validation->set_rules([
            ['field' => 'email', 'label' => 'Email', 'rules' => 'required|valid_email'],
            ['field' => 'password', 'label' => 'Passsword', 'rules' => 'required'],
        ]);
        
        if($this->form_validation->run() == false){
            $this->response([
                'status' => false,
                'error' => $this->form_validation->error_array(),
            ], 200);
        }

        $query = $this->db->query("SELECT * FROM users WHERE email = ? AND password = ? ", [
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password')),
        ]);

        if($query->num_rows() > 0){

            $user = $query->row();

            $this->db->query("INSERT INTO api_token (token, user_id, expired_at) VALUES (?, ?, ?)", [
                md5(rand(1, 9999)),
                $user->id,
                'expired_at' => date('Y-m-d H:i:s', strtotime('+1 day', time()))
            ]);

            $api_token_id = $this->db->insert_id();
            $query = $this->db->query("SELECT * FROM api_token WHERE id = ?", [$api_token_id]);
            $user->api_token = $query->result();

            // create api_token
            $this->response([
                'status' => true,
                'data' => [
                    'user' => $user
                ]
            ], 200);

        }else{

            $this->response([
                'status' => false,
                'error' => [
                    'email' => 'User not found'
                ]
            ], 200);
        }
    }

    public function logout_post(){

        $this->form_validation->set_rules([
            ['field' => 'token', 'label' => 'Token', 'rules' => 'required'],
        ]);

        if($this->form_validation->run() == false){
            $this->response([
                'status' => false,
                'error' => $this->form_validation->error_array(),
            ], 200);
        }

        $query = $this->db->query("SELECT * FROM api_token WHERE token = ?", [
            $this->input->post('token')
        ]);

        if($query->num_rows() === 0){
            $this->response([
                'status' => false,
                'error' => [
                    'token' => 'Token invalid, failed to logout'
                ]
            ], 200);
        }

        $this->response([
            'status' => true,
            'message' => 'Logged out succesfully',
        ], 200);

    }
}