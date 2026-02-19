<?php

class Editors extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    // Add a new project to the database
    public function addProjectItem($data)
    {
        return $this->db->insert('posts', $data);
    }

    // Retrieve all projects from the database
    public function getProjects()
    {
        $query = $this->db->get('posts');
        return $query->result_array();
    }

    // Retrieve a specific project by its ID from the database
    public function getProject($id)
    {
        $query = $this->db->get_where('posts', array('id' => $id));
        return $query->row_array();
    }

    // Update a project by ID
    public function updateProject($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('posts', $data);
    }

    // Delete a project by ID
    public function deleteProject($id)
    {
        return $this->db->delete('posts', array('id' => $id));
    }

    // Skills management methods
    public function getSkills()
    {
        $query = $this->db->order_by('id', 'ASC')->get('skills');
        return $query->result_array();
    }

    public function addSkill($data)
    {
        return $this->db->insert('skills', $data);
    }

    public function updateSkill($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('skills', $data);
    }

    public function deleteSkill($id)
    {
        return $this->db->delete('skills', array('id' => $id));
    }

    public function getSkill($id)
    {
        $query = $this->db->get_where('skills', array('id' => $id));
        return $query->row_array();
    }
}
