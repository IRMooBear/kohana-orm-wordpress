<?php
class Model_WP_Post extends Model_WP
{
	protected $_primary_key = 'ID';
	protected $_table_name = 'posts';

	protected $_has_many = array(
		'meta' => array(
			'model' => 'wp_postmeta',
			'foreign_key' => 'post_id',
		),
		'comments' => array(
			'model' => 'wp_comment',
			'foreign_key' => 'comment_post_ID',
		),
		'terms' => array(
			'model' => 'wp_term',
			'through' => 'wp_term_relationship',
			'foreign_key' => 'object_id',
			'far_key' => 'taxonomy_term_id',
		),
	);

	public function add_meta($key, $value)
	{
		$meta = ORM::factory('wp_postmeta');
		
		if($meta->exists($this->pk(), $key))
		{
			$meta = ORM::factory('wp_postmeta')
				->where('post_id','=', $this->pk())
				->and_where('meta_key','=', $key)
				->find()
			;
		}
		else
		{
			$meta->post_id = $this->pk();
		}
		
		$meta->meta_key = $key;
		$meta->meta_value = $value;
		
		$meta->save();
		
		return $meta->saved();
	}

	public function add_term($term)
	{
		$term = ORM::factory('wp_term',array('name' => $term));

		if($term->loaded())
		{
			$relationship = ORM::factory('wp_term_relationship');
			$relationship->object_id = $this->pk();
			$relationship->term_taxonomy_id = $term->pk();
			$relationship->term_order = 0;
			$relationship->save();

			return $relationship->saved() ? true : false;
		}
		return false;
	}
}