<?php

class Homes extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    public function getProjects()
    {
        $query = $this->db
                ->order_by('created_by', 'DESC')
                ->get('posts');
        return $query->result_array();
    }

    public function getSkills()
    {
        $query = $this->db->order_by('id', 'ASC')->get('skills');
        return $query->result_array();
    }
}