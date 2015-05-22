<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Books_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	public function get($id = NULL){
		if(!is_null($id)){
			$query = $this->db->where("id", $id)->get('books');
			if($query->num_rows() === 1){
				return $query->row_array();
			}
			return NULL;
		}

		$query = $this->db->get('books');
			if($query->num_rows() > 0){
				return $query->result_array();
			}
			return NULL;
	}

	public function save($book){
		try{
			$this->db->set($this->_setBook($book))->insert("books");
			return TRUE;
		}catch(Exception $e){
			return NULL;
		}
			
	}

	public function update($id, $book){
		try{
			$this->db->set($this->_setBook($book))->where("id", $id)->update("books");
			return TRUE;
		}catch(Exception $e){
			return NULL;
		}
		
	}

	private function _setBook($book){
		return array(
			"name" => $book["name"],
			"author" => $book["author"],
			"pub_date" => $book["pub_date"]
		);
	}

	public function delete($id){
		try{
			$this->db->where("id", $id)->delete("books");
			return TRUE;
		}catch(Exception $e){
			return NULL;
		}
		
	}
}