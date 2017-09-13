<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'controllers/api/Users_Client.php';
require APPPATH . 'helpers/REST_Status.php';


class Users extends CI_Controller
{
    private $loginResponse;
    private $registerResponse;

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');

    }

    public function login()
    {
        $data = $this->input->post();
        if (!empty($data)) {
            $response = Users_Client::login($data);
            if ($response->status == REST_Status::SUCCESS) {
                $this->session->set_userdata('isUserLoggedIn', TRUE);
                $this->session->set_userdata('userId', $response->data);
                redirect('http://articlemanagement.dev/articles/index', 'location', 301);
            }
            $this->loginResponse = [
                'loginResponse' => $response
            ];
        }
        return $this->load->view('users/loginAndRegister', $this->loginResponse);
    }

    public function register()
    {
        $data = $this->input->post();
        if (!empty($data)) {
            $response = Users_Client::register($data);
            $this->registerResponse = [
                'registerResponse' => $response
            ];
        }
        return $this->load->view('users/loginAndRegister', $this->registerResponse);
    }
}
