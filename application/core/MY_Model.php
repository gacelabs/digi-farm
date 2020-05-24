<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		// $ci =& get_instance();
		// debug($ci->accounts);
	}

	public function get($table=FALSE, $where=FALSE, $field=FALSE, $func='result', $redirect_url='')
	{
		if ($table) {
			if ($field) {
				$this->db->select($field);
			}
			if ($where) {
				$this->db->where($where);
			}
			$data = $this->db->get($table);
			// debug($data);
			if ($data->num_rows()) {
				if ($redirect_url != '') {
					redirect(base_url($redirect_url == 'home' ? '' : $redirect_url));
				} else {
					return $data->{$func.'_array'}();
				}
			}
		}
		return FALSE;
	}

	public function query($string=FALSE, $func='result')
	{
		if ($string) {
			$data = $this->db->query($string);
			// debug($data);
			if ($data->num_rows()) {
				return $data->{$func.'_array'}();
			}
		}
		return FALSE;
	}

	public function create($table=FALSE, $post=FALSE, $redirect_url='')
	{
		if ($table AND $post) {
			/*if ($this->db->field_exists('version', $table)) {
				$post = (array)$post;
				$post['version'] = 1;
			}*/
			$this->db->insert($table, $post);
			if ($redirect_url != '') {
				redirect(base_url($redirect_url == 'home' ? '' : $redirect_url));
			} else {
				return $this->db->insert_id();
			}
		}
		return FALSE;
	}

	public function save($table=FALSE, $set=FALSE, $where=FALSE, $redirect_url='', $callback=false)
	{
		if ($table AND $set AND $where) {
			if ($this->db->field_exists('version', $table)) {
				$data = $this->get($table, $where, 'version', 'row');
				$set = (array)$set;
				$set['version'] = (int)$data['version'] + 1;
			}
			$this->db->update($table, $set, $where);
			$id = $this->get($table, $where, 'id', 'row')['id'];
			if ($redirect_url != '') {
				if ($callback) {
					$callback($id);
				}
				redirect(base_url($redirect_url == 'home' ? '' : $redirect_url));
			} else {
				return $id;
			}
		}
		return FALSE;
	}

	public function remove($table=FALSE, $where=FALSE, $redirect_url='')
	{
		if ($table AND $where) {
			$this->db->delete($table, $where);
			if ($redirect_url != '') {
				redirect(base_url($redirect_url == 'home' ? '' : $redirect_url));
			} else {
				return $this->db->affected_rows();
			}
		}
		return FALSE;
	}
}
