<?php
$message = array();
class Crud extends CI_Controller
{



    public function __construct()
    {
        parent::__construct();
        $this->load->model("Logins");
    }

    public function index()
    {
        if ($this->session->userdata('is_logged_in')) {
            redirect('home');
        }

        $data['title'] = 'Welcome to Nightboard';

        $this->load->view('crud/template/header', $data);
        $this->load->view('crud/login/index');
        $this->load->view('crud/template/footer');
    }

    public function validate_login()
    {
        $data['info'] = array(
            'email' => $this->input->post('email', true),
            'password' => $this->input->post('password', true)
        );

        $val = $this->Logins->check_login($data['info']);

        if ($val !== false) {
            $this->session->set_userdata($val);
            $data['info'] = array(
                'email' => $data['info']['email'],
                'username' => $this->Logins->get_account($val['id'])->username,
                'id' => $val['id'],
                'is_logged_in' => true
            );
            $this->session->set_userdata($data['info']);
            redirect('home');
        } else {

            $this->session->set_flashdata('error', 'Invalid email or password');
            redirect('crud');
        }
    }

    public function validate_register()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_check_email_unique');
        $this->form_validation->set_rules('name', 'Name', 'required|callback_check_username_unique');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('check_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $errors = array_values($this->form_validation->error_array());
            $this->session->set_flashdata('errors', $errors);
            redirect('crud');
        } else {
            $this->register();
        }
    }
    public function register()
    {
        $data['info'] = array(
            'email' => $this->input->post('email', true),
            'password' => $this->input->post('password', true),
            'username' => $this->input->post('name', true),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $user_id = $this->Logins->register_user($data['info']);
        if ($user_id) {
            $this->session->set_flashdata('success', 'Registration successful!');
            redirect('crud');
        } else {
            $this->session->set_flashdata('error', 'Registration failed.');
            redirect('crud');
        }
    }

    /**
     * Form validation callback: ensure email is unique in crud database.
     */
    public function check_email_unique($email)
    {
        if ($this->Logins->check_email_exists($email)) {
            $this->form_validation->set_message('check_email_unique', 'This email is already registered.');
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Form validation callback: ensure username is unique in crud database.
     */
    public function check_username_unique($username)
    {
        if ($this->Logins->check_username_exists($username)) {
            $this->form_validation->set_message('check_username_unique', 'This username is already taken.');
            return FALSE;
        }
        return TRUE;
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('crud');
    }
}
