<?php
class Model_WP_Commentmeta extends Model_WP
{
	protected $_primary_key = 'meta_id';
	protected $_table_name = 'commentmeta';
	
	public function exists($comment_id, $key)
	{
		return (bool) $this
			->where('comment_id','=', $comment_id)
			->and_where('meta_key', '=', $key)
			->count_all()
		;
	}
}