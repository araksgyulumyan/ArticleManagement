<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'helpers/REST_Status.php';


/**
 * Class Articles
 */
class Articles extends REST_Controller
{
    /**
     * Articles constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('article');
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    /**
     * Method that returns 200 ok if article exists and 404 not found in else case
     * @param $id
     */
    public function index_get($id)
    {
        if (!$id) {
            $this->response([
                'status' => REST_Status::FAILED,
                'message' => 'Invalid article id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $sessionUserId = $this->session->userdata('userId');
        if (empty($sessionUserId)) {
            $this->response([
                'status' => REST_Status::FAILED,
                'message' => 'Please login to complete this action'
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }
        $article = $this->article->get_one($id);
        if (!empty($article) && $sessionUserId == $article->user_id) {
            $this->response($article, REST_Controller::HTTP_OK);
        }
        $this->response([
            'status' => REST_Status::FAILED,
            'message' => 'Article not found'
        ], REST_Controller::HTTP_NOT_FOUND);
    }

    /**
     * Method that returns 200ok if all articles are returned
     */
    public function all_get()
    {
        $sessionUserId = $this->session->userdata('userId');
        if ($sessionUserId) {
            $articles = $this->article->get_all($sessionUserId);
            $this->response($articles, REST_Controller::HTTP_OK);
        }
        $this->response([
            'status' => REST_Status::FAILED,
            'message' => 'Please login to complete this action'
        ], REST_Controller::HTTP_UNAUTHORIZED);
    }

    /**
     * Method that returns 200ok if article is created
     */
    public function index_post()
    {
        $sessionUserId = $this->session->userdata('userId');
        $title = $this->post('title');
        $content = $this->post('content');

        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('content', 'content', 'required');
        if (!empty($sessionUserId)) {

            if ($this->form_validation->run() == false) {
                $this->response([
                    'status' => REST_Status::FAILED,
                    'message' => $this->form_validation->error_array()
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $insertion = $this->article->insert([
                'title' => $title,
                'content' => $content,
                'user_id' => $sessionUserId
            ]);
            if ($insertion) {
                $this->response([
                    'status' => REST_Status::SUCCESS,
                    'message' => 'Successfully created!'
                ], REST_Controller::HTTP_OK);
            }
            $this->response([
                'status' => REST_Status::FAILED,
                'message' => 'Unable to create article'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $this->response([
            'status' => REST_Status::FAILED,
            'message' => 'Please login to complete this action'
        ], REST_Controller::HTTP_UNAUTHORIZED);
    }

    /**
     * Method that returns 200ok if article is updated
     * @param $id
     */
    public function index_put($id)
    {
        $sessionUserId = $this->session->userdata('userId');
        $title = $this->put('title');
        $content = $this->put('content');

        $data = array(
            'title' => $title,
            'content' => $content,
        );

        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('content', 'content', 'required');

        if (!empty($sessionUserId)) {
            if ($this->form_validation->run() == false) {
                $this->response([
                    'status' => REST_Status::FAILED,
                    'message' => $this->form_validation->error_array()
                ], REST_Controller::HTTP_BAD_REQUEST);
            }

            $article = $this->article->get_one($id);
            if (!empty($article) && $this->article->checkIfUserOwnsArticle($sessionUserId, $article->user_id)) {
                $update = $this->article->update($id, [
                    'title' => $title,
                    'content' => $content,
                    'user_id' => $sessionUserId
                ]);
                if ($update) {
                    $this->response([
                        'status' => REST_Status::SUCCESS,
                        'message' => 'Successfully updated'
                    ], REST_Controller::HTTP_OK);
                }
            }
            $this->response([
                'status' => REST_Status::FAILED,
                'message' => 'Unable to update article'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $this->response([
            'status' => REST_Status::FAILED,
            'message' => 'Please login to complete this action'
        ], REST_Controller::HTTP_UNAUTHORIZED);
    }

    /**
     * Method that returns 200ok if article is deleted
     * @param $id
     */
    public function index_delete($id)
    {
        $sessionUserId = $this->session->userdata('userId');
        if (!empty($sessionUserId)) {
            $article = $this->article->get_one($id);
            if (!empty($article) && $this->article->checkIfUserOwnsArticle($sessionUserId, $article->user_id)) {
                $delete = $this->article->delete($id);
                if ($delete) {
                    $this->response([
                        'status' => 'success',
                        'message' => 'Successfully deleted!'
                    ], REST_Controller::HTTP_ACCEPTED);
                }
            }
            $this->response([
                'status' => REST_Status::FAILED,
                'message' => 'Unable to delete article'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $this->response([
            'status' => 'failed',
            'message' => 'Please login to complete this action'
        ], REST_Controller::HTTP_UNAUTHORIZED);
    }
}