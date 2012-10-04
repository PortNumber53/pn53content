<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: mauricio
 * Date: 9/15/12 5:11 PM
 * Package: Package_Name
 * Description: something meaningful about the file
 */

class Model_User extends Kohana_Model_Database {

	private $_table_name = 'user';
	private $_primary_key = '_id';

	protected $_table_columns = array(
		'_id' => array('data_type' => 'varchar', 'is_nullable' => false),
		'data' => array('data_type' => 'texct', 'is_nullable' => false),
		'created_at' => array('data_type' => 'timestamp', 'is_nullable' => true),
		'updated_at' => array('data_type' => 'datetime', 'is_nullable' => true),
	);

	public function login(&$data = array()) {
		$select = DB::select()->from($this->_table_name)->order_by('_id');
		$select->where('_id', '=', $data['username']);
		$query = $select->as_assoc()->execute();
		$result_set = $query->as_array();

		if ($result_set)
		{
			if (count($result_set) == 1)
			{
				$temp = json_decode($result_set[0]['data'], TRUE);
				$result_set[0] = array_merge($result_set[0], $temp);
				unset($result_set[0]['data']);

				$result = $result_set[0];
				if ($result['status'] == 'I')
				{
					$result['error'] = 1;
					$result['error_message'] = 'Account is disabled.';
				}
				else
				{
					if ($result['password'] == $data['password'])
					{
						$result['error'] = 0;
						$result['error_message'] = 'Account found.';
					}
					else
					{
						$result['error'] = 1;
						$result['error_message'] = 'Wrong password';
					}
				}
			}
			else
			{
				//////Something weird is happening... email myself
				$result = false;
			}
		}
		else
		{
			$result = false;
		}

		if ($result && $data['remember_me'])
		{
			Cookie::set('user', json_encode($data));
		}
		else
		{
			Cookie::delete('user');
		}
		return $result;
	}

	public function load($_id)
	{
		$query = DB::select()->from($this->_table_name)->where($this->_primary_key, '=', $_id);
		$result_set = $query->execute()->as_array();
		if (count($result_set) == 1)
		{
			$result = $result_set[0];
			$array = json_decode($result_set[0]['data'], true);
			unset($result['data']);
			$result = array_merge($result, $array);

			return $result;
		}
		else
		{
			return false;
		}
	}

	public function save(& $post)
	{
		unset($post['btnaction']);

		if (empty($post['first_published']))
		{
			$post['first_published'] = date('Y-m-d H:i:s');
		}
		if (empty($post['last_updated']))
		{
			$post['last_updated'] = $post['first_published'];
		}

		//Check if URL already exists
		$temp = $this->load($post['_id']);
		if ($temp) {
			$post['_id'] = $temp['_id'];
			$post = array_merge($temp, $post);
		}

		$row_data = array(
			'_id' => $post['username'],
			'data' => json_encode($post),
			'updated_at' => date('Y-m-d H:i:s'),
		);

		if (! $temp)
		{
			$result = DB::insert($this->_table_name, array_keys($row_data))->values($row_data)->execute();
			$post['_id'] = $result[0];
		}
		else
		{
			$result = DB::update($this->_table_name)->set($row_data)->where($this->_primary_key, '=', $row_data[$this->_primary_key])->execute();
		}

		return true;
	}
}