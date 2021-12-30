<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main_Model extends CI_Model
{
    public function __construct()
    {
        $this->tableName = 'tbl_mintinfo';
    }

    /*
     * Fetch files data from the database
     * @param id returns a single record if specified, otherwise all records
     */
    public function getRows($id = '')
    {
        $this->db->select('id, wallet_address, file_list, desc, info, price, count, uploaded_at');
        $this->db->from('tbl_mintinfo');
        if ($id) {
            $this->db->where('id', $id);
            $query = $this->db->get();
            $result = $query->row_array();
        } else {
            $this->db->order_by('uploaded_at', 'desc');
            $query = $this->db->get();
            $result = $query->result_array();
        }

        return !empty($result) ? $result : false;
    }

    /*
     * Insert file data into the database
     * @param array the data for inserting into the table
     */
    public function insert_data($data = array())
    {
        $insert = $this->db->insert('tbl_mintinfo', $data);
        return $this->db->insert_id();
        // return $insert ? true : false;
    }
    
    public function update_data($id, $data)
	{
		/**
		 * Update all the form information in the user table referent to the id
		 */
		$this->db->where("id", $id);
		$this->db->update("tbl_mintinfo", $data);
	}
    
    public function ellipseAddress($address, $width)
    {
        if (!$address) {
            return '';
        }

        return substr($address, 0, $width) . '...' . substr($address, -$width);
    }

}
