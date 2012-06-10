<?php
class Model_WP_Usermeta extends Model_WP
{
	protected $_primary_key = 'umeta_id';
	protected $_table_name = 'usermeta';
	
	public function exists($user_id, $key)
	{
		return (bool) $this
			->where('user_id','=', $user_id)
			->and_where('meta_key','=', $key)
			->count_all()
		;				
	}
}