<?php

class Boards extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->db_crud = $this->load->database('for_crud', true);
    }

    public function add_thread($data)
    {
        $this->db_crud->insert('threads', $data);
    }

    public function get_threads()
    {
        $query = $this->db_crud->select("threads.title AS title, threads.content AS content, threads.id AS id, threads.slug AS slug, threads.active AS active, users.username AS username, threads.created_at AS created_at,
            (
                SELECT COUNT(*) FROM comments WHERE comments.thread_id = threads.id AND comments.active = 1
            ) + (
                SELECT COUNT(*) FROM replies JOIN comments ON replies.comment_id = comments.id WHERE comments.thread_id = threads.id AND replies.active = 1 AND comments.active = 1
            ) AS total_comments_replies
            ")
            ->from('threads')
            ->join('users', 'threads.user_id = users.id')
            ->order_by('threads.created_at', 'DESC')
            ->get();

        return $query->result_array();
    }
    public function get_thread($slug)
    {
        $query = $this->db_crud->select('threads.title AS title, threads.content AS content, threads.slug AS slug, threads.id AS id, threads.user_id AS user_id, threads.active AS active, threads.created_at AS created_at, threads.updated_at AS updated_at, users.username AS username')
            ->from('threads')
            ->join('users', 'threads.user_id = users.id')
            ->where('threads.slug', $slug)
            ->get();
        return $query->row();
    }

    public function get_thread_by_id($thread_id)
    {
        $query = $this->db_crud->select('threads.id, threads.slug, threads.active, threads.user_id')
            ->from('threads')
            ->where('threads.id', $thread_id)
            ->get();
        return $query->row();
    }

    public function update_thread($thread_id, $data)
    {
        $this->db_crud->where('id', $thread_id)
            ->update('threads', $data);
    }

    public function get_comments($thread_id)
    {
        $query = $this->db_crud->select('comments.id AS id, comments.content AS content, comments.created_at AS comment_time, comments.updated_at AS updated_at, users.username AS username, comments.user_id AS user_id')
            ->from('comments')
            ->join('users', 'comments.user_id = users.id')
            ->where('comments.thread_id', $thread_id)
            ->where('comments.active', 1)
            ->order_by('comments.created_at', 'DESC')
            ->get();
        return $query->result_array();
    }

    public function get_replies($comment_id)
    {
        $query = $this->db_crud->select('replies.id AS id, replies.content AS content, replies.created_at AS created_at, replies.updated_at AS updated_at, users.username AS username, replies.user_id AS user_id')
            ->from('replies')
            ->join('users', 'replies.user_id = users.id')
            ->where('replies.comment_id', $comment_id)
            ->where('replies.active', 1)
            ->order_by('replies.created_at', 'DESC')
            ->get();
        return $query->result_array();
    }

    public function add_comment($data)
    {
        $this->db_crud->insert('comments', $data);
    }

    public function get_comment($comment_id)
    {
        $query = $this->db_crud->select('*')
            ->from('comments')
            ->where('id', $comment_id)
            ->get();
        return $query->row_array();
    }

    public function get_reply($reply_id)
    {
        $query = $this->db_crud->select('*')
            ->from('replies')
            ->where('id', $reply_id)
            ->get();
        return $query->row_array();
    }

    public function update_comment($comment_id, $data)
    {
        $this->db_crud->where('id', $comment_id)
            ->update('comments', $data);
    }

    public function update_reply($reply_id, $data)
    {
        $this->db_crud->where('id', $reply_id)
            ->update('replies', $data);
    }

    public function add_reply($data)
    {
        $this->db_crud->insert('replies', $data);
    }

    public function delete_reply($reply_id)
    {
        $this->db_crud->where('id', $reply_id)
            ->update('replies', array('active' => 0));
    }

    public function delete_comment($comment_id)
    {
        $this->db_crud->where('id', $comment_id)
            ->update('comments', array('content' => 'Comment has been deleted', 'active' => 0));
    }

    public function delete_thread($thread_id)
    {
        $this->db_crud->where('id', $thread_id)
            ->update('threads', array('active' => 0));
    }

    public function get_user_threads($user_id)
    {
        $query = $this->db_crud->select('threads.title AS title, threads.content AS content, threads.id AS id, threads.slug AS slug, threads.active AS active, users.username AS username, threads.created_at AS created_at')
            ->from('threads')
            ->join('users', 'threads.user_id = users.id')
            ->where('threads.user_id', $user_id)
            ->order_by('threads.created_at', 'DESC')
            ->get();

        return $query->result_array();
    }

    public function search_threads($keyword)
    {
        $query = $this->db_crud->select("threads.title AS title, threads.content AS content, threads.id AS id, threads.slug AS slug, threads.active AS active, users.username AS username, threads.created_at AS created_at,
            (
                SELECT COUNT(*) FROM comments WHERE comments.thread_id = threads.id AND comments.active = 1
            ) + (
                SELECT COUNT(*) FROM replies JOIN comments ON replies.comment_id = comments.id WHERE comments.thread_id = threads.id AND replies.active = 1 AND comments.active = 1
            ) AS total_comments_replies
            ")
            ->from('threads')
            ->join('users', 'threads.user_id = users.id')
            ->like('threads.title', $keyword)
            ->or_like('threads.content', $keyword)
            ->order_by('threads.created_at', 'DESC')
            ->get();

        return $query->result_array();
    }
}
