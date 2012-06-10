<?php
class Model_WP_Term_Taxonomy extends Model_WP
{
	protected $_primary_key = 'term_taxonomy_id';
	protected $_table_name = 'term_taxonomy';
	
	public function recount_relationships()
	{
		$statistics = ORM::factory('wp_term_relationship')
			->select(array('term_taxonomy_id','id'),array(DB::expr('COUNT(*)'),'count'))
			->group_by('term_taxonomy_id')
			->find_all()
			->as_array('id', 'count');

		foreach($statistics as $term_id => $count)
		{
			$term = ORM::factory('wp_term_taxonomy', $term_id);
			$term->count = $count;
			$term->save();
		}
	}
}