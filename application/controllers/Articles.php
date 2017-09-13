<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Articles extends CI_Controller
{
    public function index()
    {
        return $this->load->view('articles/index');
    }
}
