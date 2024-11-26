<?php

// extends class Model
class Token_model extends CI_Model
{
    
    public function insert_token($username,
            $token
            )
    {
        $data = array(
            "username"=> $username,
            "token"=> $token
            );
        $cek_token = $this->db->select('*')->from('token')->where('username',$username)->where('token',$token)->get()->row();
        if(empty($cek_token)){
            $this->db->insert("token", $data);    
        }

        
        $response['status'] = 200;
        $response['error'] = false;
        // $response['pushToken'] = $insert;
        return $response;
    }
    
}