<?php

class Logins extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db_crud = $this->load->database('for_crud', true);
    }

    public function check_login($data)
    {
        $this->db_crud->where('email', $data['email']);
        $this->db_crud->where('password', $data['password']);
        $query = $this->db_crud->get('users');

        $out = array(
            'id' => $query->row()->id,
            'email' => $query->row()->email,
            'is_logged_in' => true
        );
        if ($query->num_rows() == 1) {
            return $out;
        }
        return false;
    }

    public function register_user($data)
    {
        $this->db_crud->insert('users', $data);
        return $this->db_crud->insert_id();
    }

    public function check_email_exists($email)
    {
        $this->db_crud->where('email', $email);
        $query = $this->db_crud->get('users');

        return $query->num_rows() > 0;
    }

    public function check_username_exists($username)
    {
        $this->db_crud->where('username', $username);
        $query = $this->db_crud->get('users');

        return $query->num_rows() > 0;
    }

    public function get_account($id)
    {
        $this->db_crud->where('id', $id);
        $query = $this->db_crud->get('users');
        return $query->row();
    }
}
