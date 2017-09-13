<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Class Article
 */
class Article extends CI_Model
{

    /**
     * Checks if user have permission to manipulate with the article
     * @param $sessionUserId
     * @param $articleUserId
     * @return bool
     */
    public function checkIfUserOwnsArticle($sessionUserId, $articleUserId)
    {
        return $sessionUserId == $articleUserId;
    }

    /**
     * Get single article by specific id
     * @param $id
     * @return mixed
     */
    public function get_one($id)
    {
        $this->db->select('*');
        $this->db->from('articles');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    /**
     * Get all articles for specific user
     * @return user's articles
     */
    public function get_all($userId)
    {
        $this->db->select('*');
        $this->db->from('articles');
        $this->db->where('user_id', $userId);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Data insertion in articles table
     * @param $data
     * @return bool
     */
    public function insert($data)
    {
        return $this->db->insert('articles', $data);
    }

    /**
     * Data updating in articles table
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($id, $data)
    {
        return $this->db->update('articles', $data, ['id' => $id]);
    }

    /**
     * Data deleting from articles table
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->db->delete("articles", ['id' => $id]);
    }
}