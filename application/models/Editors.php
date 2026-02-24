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
        $this->db->trans_begin();
        $this->db->insert('posts', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
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
        $this->db->trans_begin();
        $this->db->where('id', $id);
        $this->db->update('posts', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }

    // Delete a project by ID
    public function deleteProject($id)
    {
        $this->db->trans_begin();
        $this->db->delete('posts', array('id' => $id));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }

    // Skills management methods
    public function getSkills()
    {
        $query = $this->db->order_by('id', 'ASC')->get('skills');
        return $query->result_array();
    }

    public function addSkill($data)
    {
        $this->db->trans_begin();
        $this->db->insert('skills', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }

    public function updateSkill($id, $data)
    {
        $this->db->trans_begin();
        $this->db->where('id', $id);
        $this->db->update('skills', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }

    public function deleteSkill($id)
    {
        $this->db->trans_begin();
        $this->db->delete('skills', array('id' => $id));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }

    public function getSkill($id)
    {
        $query = $this->db->get_where('skills', array('id' => $id));
        return $query->row_array();
    }
}
