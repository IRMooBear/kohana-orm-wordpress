<?php
class Model_WP_User extends Model_WP
{
	protected $_table_name = 'users';
	protected $_primary_key = 'ID';
	
	protected $_has_many = array(
		'posts' => array(
			'model' => 'wp_post',
			'foreign_key' => 'post_author',
		),
		'comments' => array(
			'model' => 'wp_comment',
			'foreign_key' => 'user_id',
		),
		'links' => array(
			'model' => 'wp_link',
			'foreign_key' => 'link_owner',
		),
	);
	
	public function add_meta($key, $value)
	{
		
		$meta = ORM::factory('wp_usermeta');
		
		if($meta->exists($this->pk(), $key))
		{
			$meta = ORM::factory('wp_usermeta')
				->where('user_id', $this->pk())
				->and_where('meta_key', '=', $key)
				->find()
			;
		}
		else
		{
			$meta->user_id = $this->pk();
		}
		
		$meta->meta_key = $key;
		$meta->meta_value = $value;
		$meta->save();
		
		return $meta->saved();
	}
}