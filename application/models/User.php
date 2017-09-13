<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Class User
 */
class User extends CI_Model
{
    /**
     * Checks if user exists
     * @param $data
     * @return bool
     */
    public function checkIfUserExistsForUsernameAndPassword($data)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('username', $data['username']);
        $this->db->where('password', $data['password']);
        $resultCount = $this->db->get()->num_rows();
        return $resultCount > 0;
    }

    /**
     * Get user by username
     * @param $username
     * @return mixed
     */
    public function get_by_username($username)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('username', $username);
        return $this->db->get()->row();
    }

    /**
     * Get user by specific id
     * @param $id
     * @return mixed
     */
    public function get_one($id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    /**
     * Data insertion in users table
     * @param $data
     * @return bool
     */
    public function insert($data)
    {
        return $this->db->insert('users', $data);
    }
}