<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Class User
 */
class User_info extends CI_Model
{
    /**
     * Get user info by specific user_id
     * @param $id
     * @return mixed
     */
    public function get_one_by_user($user_id)
    {
        $this->db->select('*');
        $this->db->from('user_infos');
        $this->db->where('user_id', $user_id);
        return $this->db->get()->row();
    }

    /**
     * Data insertion in user_infos table
     * @param $data
     * @return bool
     */
    public function insert($data)
    {
        return $this->db->insert('user_infos', $data);
    }


    /**
     * Data updating in user_infos table
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($id, $data)
    {
        return $this->db->update('user_infos', $data, ['id' => $id]);
    }
}