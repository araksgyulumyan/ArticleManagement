<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'controllers/api/Articles_Client.php';
require APPPATH . 'helpers/REST_Status.php';


class Articles extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index()
    {
        $sessionUserId = $this->session->userdata('userId');
        if($sessionUserId) {
            $response = [
                'articles' => Articles_Client::getAll($sessionUserId)
            ];
//            var_dump($sessionUserId);die;



            return $this->load->view('articles/index', $response);

        }

    }

}
