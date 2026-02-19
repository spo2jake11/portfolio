<?php

class Calc extends CI_Controller
{
    public function index()
    {
        $this->load->view('calculator/index');
    }
}