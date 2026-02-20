<?php

class Home extends CI_Controller
{
    public function index()
    {
        $data['docs'] = $this->Homes->getProjects();
        $data['skills'] = $this->Homes->getSkills();

        $this->load->view('portfolio/template/header');
        $this->load->view('portfolio/index', $data);
        $this->load->view('portfolio/content', $data);
        $this->load->view('portfolio/template/footer');
    }
    
}
