<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Index_model
 *
 * @package    Models
 * @subpackage null
 * @category   Models
 * @author     Guilherme Gatti
 * @link       null
 */
class User_model extends CI_Model{

	/**
	 * Construct of CI_Model
	 *
	 * @param  null  Do not have a param
	 * @return null  Do not have a return
	 */
	public function __construct()
	{
	
		/**
		 * Instead the construct of CI_Model
		 */
		parent::__construct();

	}

	/**
	 * Get all the users in the table
	 *
	 * @param  null   Do not have a param
	 * @return array  Return the query result
	 */
	public function get_all()
	{
		/**
		 * Select all the user query results of the table
		 *
		 * @var array $query  Select all the users
		 */
		$query = $this->db->get("tbl_users");
		
		/**
		 * Return the query result
		 */
		return $query;

	}

	/**
	 * Select the segment and use to return a value
	 *
	 * @param  string $address  Select address
	 * @return array  			Return the query result
	 */
	public function get_user($address)
	{

		/**
		 * Select the user query result of the table when the id is equal to the segment var
		 *
		 * @var array $query  Select all the users
		 */
		$query = $this->db->get_where("tbl_users", array("address" => $address));
		
		/**
		 * Return the query result
		 */
		return $query;
	}

	/**
	 * Insert an new user in the table
	 *
	 * @param  string $data  All the form information
	 * @return null  		 Do not have a return
	 */
	public function insert_user($data)
	{

		/**
		 * Insert all the form information in the user table
		 */
		$this->db->insert("tbl_users", $data);
        return $this->db->insert_id();
	}

	/**
	 * Update an user in the table
	 *
	 * @param  int $id    	 Get the user id
	 * @param  string $data  All the form information
	 * @return null  		 Do not have a return
	 */
	public function update_user($address, $data)
	{

		/**
		 * Update all the form information in the user table referent to the id
		 */
		$this->db->where("address", $address);
		$this->db->update("tbl_users", $data);
	}

	/**
	 * Delete an user in the table
	 *
	 * @param  string $id    Get the user id
	 * @return null  		 Do not have a return
	 */
	public function delete_user($address)
	{

		/**
		 * Update the user table referent to the id
		 */
		$this->db->where("address", $address);
		$this->db->delete("tbl_users");

	}

}
