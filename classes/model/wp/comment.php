<?php
class Model_WP_Comment extends Model_WP
{
	protected $_primary_key = 'comment_ID';
	protected $_table_name = 'comments';
	
	protected $_has_many = array(
		'meta' => array(
			'model' => 'wp_commentmeta',
			'foreign_key' => 'comment_id',
		),
	);
	
	public function add_meta($key, $value)
	{
		$meta = ORM::factory('wp_commentmeta');
		
		if($meta->exists($this->pk(), $key))
		{
			$meta = ORM::factory('wp_commentmeta')
				->where('comment_id', $this->pk())
				->and_where('meta_key', '=', $key)
				->find()
			;
		}
		else
		{
			$meta->comment_id = $this->pk();
		}
		
		
		$meta->meta_key = $key;
		$meta->meta_value = $value;
		$meta->save();
		
		return $meta->saved();
	}
}