<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: mauricio
 * Date: 9/20/12 2:00 AM
 * Package: Package_Name
 * Description: something meaningful about the file
 */

class Model_Image extends Kohana_Model_Database {

	private $_table_name = 'image';
	private $_primary_key = '_id';

	protected $_table_columns = array(
		'_id' => array('data_type' => 'varchar', 'is_nullable' => false),
		'data' => array('data_type' => 'texct', 'is_nullable' => false),
		'created_at' => array('data_type' => 'timestamp', 'is_nullable' => true),
		'updated_at' => array('data_type' => 'datetime', 'is_nullable' => true),
	);

	public function empty_post()
	{
		$post = array(
			'_id' => '',
			'data' => '',
			'created_at' => '',
			'updated_at' => '',
		);
		foreach ($this->_table_columns as $key=>$value)
		{
			$post[$key] = '';
		}
		return $post;
	}

	public function count_all()
	{
		$sql = 'SELECT count(id) as rows FROM tbl_content';

		$count = DB::select( array('COUNT("id")', 'num_rows'))->from('content')->execute()->get('num_rows', 0);
		return (int)$count;
	}


	public function get_number_of_pages($posts_per_page=50)
	{
		$count = DB::select( array('COUNT("'.$this->_primary_key.'")', 'num_rows'))->from($this->_table_name)->execute()->get('num_rows', 0);
		$pages = ceil($count / $posts_per_page);
		return (int)$pages;
	}

	public function get_posts($query=null, $page=1, $posts_per_page=50) {

		if ($page > 0)
		{
			$page--;
		}
		//$page = $page * $posts_per_page;
		//$sql = 'SELECT * FROM tbl_content ORDER BY last_updated DESC, first_published DESC LIMIT ' . $page . ',' . $posts_per_page;

		$result = DB::select()->from($this->_table_name)->execute()->as_array();
		foreach ($result as &$item)
		{
			$item = array_merge($item, json_decode($item['data'], TRUE));
			switch ($item['mimetype'])
			{
				case "image/gif":
					$item['format'] = "gif";
					break;
				case "image/png":
					$item['format'] = "png";
					break;
				default: $item['format'] = 'jpg';
			}
			unset($item['data']);
		}
		return $result;
	}


	public function filter($filter = array(), $page, $num_posts = 50)
	{

		if ($page > 0)
		{
			$page--;
		}
		$offset = ($page * $num_posts);

		$select = DB::select()->from($this->_table_name)->order_by('id');
		if (count($filter) > 0)
		{
			foreach ($filter as $item)
			{
				$select->where($item[0], $item[1], $item[2]);
			}
		}
		$query = $select->offset($offset)->limit($num_posts)->as_assoc()->execute();

		return $query->as_array();
	}


	public function validate(& $post)
	{
		return true;
	}


	public function save(& $post)
	{
		unset($post['btnaction']);

		if (empty($post['created_at']))
		{
			$post['created_at'] = date('Y-m-d H:i:s');
		}
		if (empty($post['updated_at']))
		{
			$post['updated_at'] = $post['created_at'];
		}

		//Check if _ID already exists
		$temp = $this->get_post_by_id($post['_id']);
		if ($temp) {
			$post['_id'] = $temp['_id'];
		}

		$_id = $post['_id'];
		unset($post['_id']);
		$row_data = array(
			'_id' => $_id,
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
			$return = DB::update($this->_table_name)->set($row_data)->where($this->_primary_key, '=', $row_data['_id'])->execute();
		}

		return true;
	}


	public function get_last_posts($n = 10)
	{
		$result = DB::select()->from($this->_table_name)->order_by('updated_at', 'desc')->limit($n)->execute();
		return $result->as_array();
	}


	public function get_post_by_id($_id)
	{
		$query = DB::select()->from($this->_table_name)->where($this->_primary_key, '=', $_id);
		#echo (string) $query;
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

	public function get_urls($n = 1000, $with_redirect=true)
	{
		if ($with_redirect)
		{
			$result = DB::select($this->_primary_key)->from($this->_table_name)->order_by('updated_at', 'desc')->limit($n)->execute();
			$result_array = $result->as_array();
		}
		else
		{
			$result = DB::select($this->_primary_key, 'data')->from('content')->order_by('updated_at', 'desc')->limit($n)->execute();
			$result_array = $result->as_array();
			foreach ($result_array as $id=>&$key)
			{
				if (!empty($key['data']))
				{
					$array = json_decode($key['data'], TRUE);
					unset($key['data']);
					if (!empty($array['redirect_url']))
					{
						unset($result_array[$id]);
					}
				}
			}
		}

		return $result_array;
	}
}
