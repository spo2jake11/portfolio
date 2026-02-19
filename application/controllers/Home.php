<?php

class Home extends CI_Controller
{
    public function index()
    {
        $data['docs'] = $this->Homes->getProjects();

        $this->load->view('portfolio/template/header');
        $this->load->view('portfolio/index');
        $this->load->view('portfolio/content', $data);
        $this->load->view('portfolio/template/footer');
    }
}
