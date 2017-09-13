<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'helpers/REST_Status.php';

/**
 * Class Users
 */
class Users extends REST_Controller
{
    /**
     * Users constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user');
        $this->load->model('user_info');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    /**
     * Method that returns 200 ok if user exists and 404 not found in else case
     * @param $id
     */
    public function index_get($id)
    {
        if (!$id) {
            $this->response([
                'status' => REST_Status::FAILED,
                'message' => 'Invalid user id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $user = $this->user->get_one($id);

        if ($user) {
            $this->response([
                'id' => $user->id,
                'username' => $user->username,
            ], REST_Controller::HTTP_OK);
        }
        $this->response([
            'status' => REST_Status::FAILED,
            'message' => 'User not found'
        ], REST_Controller::HTTP_NOT_FOUND);
    }

    /**
     * User login functionality, returns 200ok if user is logged in
     */
    public function login_post()
    {
        $username = $this->post('username');
        $password = $this->post('password');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == false) {
            $this->response([
                'status' => REST_Status::FAILED,
                'message' => 'Username and password are required'],
                REST_Controller::HTTP_BAD_REQUEST);
        }
        $user = $this->user->get_by_username($username);
        if (!empty($user) && $user->password == $password) {
            $this->session->set_userdata('isUserLoggedIn', TRUE);
            $this->session->set_userdata('userId', $user->id);
            $this->response([
                'status' => REST_Status::SUCCESS,
                'message' => 'Logged in successfully',
            ], REST_Controller::HTTP_OK);
        }

        $this->response([
            'status' => REST_Status::FAILED,
            'message' => 'Wrong username or password'
        ], REST_Controller::HTTP_NOT_FOUND);
    }

    /**
     * User register functionality, returns 200ok if user is registered
     */
    public function register_post()
    {
        $username = $this->post('username');
        $password = $this->post('password');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]|min_length[5]',
            [
                'is_unique' => 'This username is already taken',
                'min_length' => 'Username must contain at least 5 characters'

            ]);
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]',
            [
                'min_length' => 'Password must contain at least 6 characters'
            ]);

        if ($this->form_validation->run() == false) {
            $this->response([
                'status' => REST_Status::FAILED,
                'message' => $this->form_validation->error_array()
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $insertion = $this->user->insert([
            'username' => $username,
            'password' => $password
        ]);

        if ($insertion) {
            $this->response([
                'status' => REST_Status::SUCCESS,
                'message' => 'Successfully registered'
            ], REST_Controller::HTTP_CREATED);
        }
        $this->response([
            'status' => REST_Status::FAILED,
            'message' => 'Unable to create user'
        ], REST_Controller::HTTP_BAD_REQUEST);
    }

    /**
     * User logout
     */
    public function logout_post()
    {
        $this->session->unset_userdata('isUserLoggedIn');
        $this->session->unset_userdata('userId');
        $this->session->sess_destroy();
        return $this->response([
            'status' => REST_Status::SUCCESS,
            'message' => 'User is logged out'
        ], REST_Controller::HTTP_OK);
    }

    public function info_post()
    {
        $sessionUserId = $this->session->userdata('userId');
        if (!empty($sessionUserId)) {
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('surname', 'surname', 'required');
            if ($this->form_validation->run() == false) {
                $this->response([
                    'status' => REST_Status::FAILED,
                    'message' => $this->form_validation->error_array()
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $name = $this->post('name');
            $surname = $this->post('surname');
            $insertion = $this->user_info->insert([
                'name' => $name,
                'surname' => $surname,
                'user_id' => $sessionUserId
            ]);
            if ($insertion) {
                $this->response([
                    'status' => REST_Status::SUCCESS,
                    'message' => 'User info is created successfully'
                ], REST_Controller::HTTP_CREATED);
            }
            $this->response([
                'status' => REST_Status::FAILED,
                'message' => 'Unable to create user info'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $this->response([
            'status' => REST_Status::FAILED,
            'message' => 'Please login to complete this action'
        ], REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function info_put()
    {
        $sessionUserId = $this->session->userdata('userId');
        if (!empty($sessionUserId)) {
            $name = $this->put('name');
            $surname = $this->put('surname');
            $data = array(
                'name' => $name,
                'surname' => $surname,
            );
            $this->form_validation->set_data($data);
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('surname', 'surname', 'required');

            if ($this->form_validation->run() == false) {
                $this->response([
                    'status' => REST_Status::FAILED,
                    'message' => $this->form_validation->error_array()
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $user_info = $this->user_info->get_one_by_user($sessionUserId);
            if (!empty($user_info)) {
                $update = $this->user_info->update($sessionUserId, [
                    'name' => $name,
                    'surname' => $surname,
                    'user_id' => $sessionUserId
                ]);
                if ($update) {
                    $this->response([
                        'status' => REST_Status::SUCCESS,
                        'message' => 'User info was updated successfully'
                    ], REST_Controller::HTTP_OK);
                }
                $this->response([
                    'status' => REST_Status::FAILED,
                    'message' => 'Unable to update user info'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $this->response([
                'status' => REST_Status::FAILED,
                'message' => 'Nothing to update'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        $this->response([
            'status' => REST_Status::FAILED,
            'message' => 'Please login to complete this action'
        ], REST_Controller::HTTP_UNAUTHORIZED);
    }
}