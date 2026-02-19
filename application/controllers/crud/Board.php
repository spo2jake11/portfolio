<?php

class Board extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('time');
    }

    public function index()
    {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('crud');
        }
        $title['title'] = 'Welcome to BREADS';
        $data['threads'] = $this->Boards->get_threads();
        $this->session->unset_userdata('current_thread_id');

        // echo '<pre>';
        // print_r($data['threads']);
        $this->load->view('crud/template/header', $title);
        $this->load->view('crud/home/index');
        $this->load->view('crud/home/content', $data);
        $this->load->view('crud/template/footer');
    }

    public function create()
    {

        $slug = url_title($this->input->post('title', true), 'dash', true);
        $data['info'] = array(
            'title' => $this->input->post('title', true),
            'content' => $this->input->post('content', true),
            'user_id' => $this->session->userdata('id'),
            'slug' => $slug,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->Boards->add_thread($data['info']);
        // print_r($data['info']);

        redirect('home');
    }

    public function open_thread($slug)
    {
        $data['thread'] = $this->Boards->get_thread($slug);

        // If thread not found, show 404 page instead of causing property access errors
        if (empty($data['thread'])) {
            show_404();
            return;
        }

        $thread_id = $data['thread']->id;
        $data['comments'] = $this->Boards->get_comments($thread_id);

        // Get replies for each comment
        foreach ($data['comments'] as $key => $comment) {
            $data['comments'][$key]['replies'] = $this->Boards->get_replies($comment['id']);
        }

        $data['title'] = $data['thread']->title;
        $data['id'] = $thread_id;
        $this->session->set_userdata('current_thread_id', $thread_id);

        // echo '<pre>';
        // print_r($data);
        $this->load->view('crud/template/header', $data);
        $this->load->view('crud/home/index');
        $this->load->view('crud/home/thread', $data);
        $this->load->view('crud/template/footer');
    }

    public function time_elapsed($datetime)
    {
        $time = strtotime($datetime);
        $diff = time() - $time;

        if ($diff < 60) return $diff . ' seconds ago';
        if ($diff < 3600) return floor($diff / 60) . ' minutes ago';
        if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
        if ($diff < 604800) return floor($diff / 86400) . ' days ago';

        return date('M d, Y', $time);
    }
    public function add_comment()
    {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('crud');
            return;
        }
        $thread_id = (int) $this->input->post('thread_id', true);
        $thread = $this->Boards->get_thread_by_id($thread_id);
        if (empty($thread) || (int) $thread->active !== 1) {
            $this->session->set_flashdata('error', 'This thread is closed. You cannot add comments.');
            redirect($thread ? $thread->slug : 'home');
            return;
        }
        $data['info'] = array(
            'content' => $this->input->post('comment', true),
            'user_id' => $this->session->userdata('id'),
            'thread_id' => $thread_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->Boards->add_comment($data['info']);
        redirect($thread->slug);
    }

    public function add_reply()
    {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('crud');
            return;
        }
        $thread_id = (int) $this->input->post('thread_id', true);
        $thread = $this->Boards->get_thread_by_id($thread_id);
        if (empty($thread) || (int) $thread->active !== 1) {
            $this->session->set_flashdata('error', 'This thread is closed. You cannot add replies.');
            redirect($thread ? $thread->slug : 'home');
            return;
        }
        $data['info'] = array(
            'content' => $this->input->post('comment', true),
            'user_id' => $this->session->userdata('id'),
            'comment_id' => $this->input->post('comment_id', true),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->Boards->add_reply($data['info']);
        redirect($thread->slug);
    }

    public function edit_comment($comment_id)
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $new = $this->input->post('comment', true);
            $thread_id = (int) $this->input->post('thread_id', true);

            $comment = $this->Boards->get_comment($comment_id);
            if (empty($comment) || (int) $comment['user_id'] !== (int) $this->session->userdata('id')) {
                $thread = $this->Boards->get_thread_by_id($thread_id);
                redirect($thread ? $thread->slug : 'home');
                return;
            }

            $data = array('content' => $new, 'updated_at' => date('Y-m-d H:i:s'));
            $this->Boards->update_comment($comment_id, $data);
            $thread = $this->Boards->get_thread_by_id($thread_id);
            redirect($thread ? $thread->slug : 'home');
            return;
        }
        redirect('home');
    }

    public function edit_reply($reply_id)
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $new = $this->input->post('comment', true);
            $thread_id = (int) $this->input->post('thread_id', true);

            $reply = $this->Boards->get_reply($reply_id);
            if (empty($reply) || (int) $reply['user_id'] !== (int) $this->session->userdata('id')) {
                $thread = $this->Boards->get_thread_by_id($thread_id);
                redirect($thread ? $thread->slug : 'home');
                return;
            }

            $data = array('content' => $new, 'updated_at' => date('Y-m-d H:i:s'));
            $this->Boards->update_reply($reply_id, $data);
            $thread = $this->Boards->get_thread_by_id($thread_id);
            redirect($thread ? $thread->slug : 'home');
            return;
        }
        redirect('home');
    }

    public function delete_reply($reply_id, $thread_id)
    {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('crud');
            return;
        }
        $reply = $this->Boards->get_reply($reply_id);
        if (empty($reply) || (int) $reply['user_id'] !== (int) $this->session->userdata('id')) {
            $thread = $this->Boards->get_thread_by_id($thread_id);
            redirect($thread ? $thread->slug : 'home');
            return;
        }
        $this->Boards->delete_reply($reply_id);
        $thread = $this->Boards->get_thread_by_id($thread_id);
        redirect($thread ? $thread->slug : 'home');
    }

    public function delete_comment($comment_id, $thread_id)
    {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('crud');
            return;
        }
        $comment = $this->Boards->get_comment($comment_id);
        if (empty($comment) || (int) $comment['user_id'] !== (int) $this->session->userdata('id')) {
            $thread = $this->Boards->get_thread_by_id($thread_id);
            redirect($thread ? $thread->slug : 'home');
            return;
        }
        $this->Boards->delete_comment($comment_id);
        $thread = $this->Boards->get_thread_by_id($thread_id);
        redirect($thread ? $thread->slug : 'home');
    }

    public function close_thread($thread_id)
    {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('crud');
            return;
        }
        $thread = $this->Boards->get_thread_by_id($thread_id);
        if (empty($thread) || (int) $thread->user_id !== (int) $this->session->userdata('id')) {
            redirect($thread ? $thread->slug : 'home');
            return;
        }
        $this->Boards->delete_thread($thread_id);
        $slug = $thread->slug;
        redirect($slug);
    }

    public function update_thread($thread_id)
    {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('crud');
            return;
        }
        $thread = $this->Boards->get_thread_by_id($thread_id);
        if (empty($thread) || (int) $thread->user_id !== (int) $this->session->userdata('id')) {
            redirect($thread ? $thread->slug : 'home');
            return;
        }
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            redirect($thread->slug);
            return;
        }
        $title = $this->input->post('title', true);
        $content = $this->input->post('content', true);
        $slug = url_title($title, 'dash', true);
        $this->Boards->update_thread($thread_id, array(
            'title' => $title,
            'content' => $content,
            'slug' => $slug,
            'updated_at' => date('Y-m-d H:i:s')
        ));
        redirect($slug);
    }

    public function history($username)
    {
        $data['threads'] = $this->Boards->get_user_threads($this->session->userdata('id'));
        $data['title'] = 'Your Threads';
        $this->load->view('crud/template/header', $data);
        $this->load->view('crud/home/index');
        $this->load->view('crud/home/history', $data);
        $this->load->view('crud/template/footer');
    }

    public function search_threads()
    {
        $keyword = $this->input->get('keyword', true);
        $data['threads'] = $this->Boards->search_threads($keyword);
        $data['title'] = 'Search Results for "' . $keyword . '"';
        $this->load->view('crud/template/header', $data);
        $this->load->view('crud/home/index');
        $this->load->view('crud/home/search', $data);
        $this->load->view('crud/template/footer');
    }
}
