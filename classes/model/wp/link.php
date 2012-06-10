<?php
class Model_WP_Link extends Model_WP
{
	protected $_primar_key = 'link_id';
	protected $_table_name = 'links';
	
	protected $_belongs_to = array(
		'user' => array(
			'model' => 'wp_user',
			'foreign_key' => 'link_owner',
		),
	);
}