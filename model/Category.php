<?php
class Category extends Model{

	var $table = 'categories'; 

	var $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'message' => 'Vous devez préciser un titre'
		),
		'slug' => array(
			'rule' => '([a-z0-9\-]+)',
			'message' => "L'url n'est pas valide"
		),
		'desccat' => array(
			'rule' => 'notEmpty',
			'message' => 'Vous devez préciser la description'
		),
		'typecat' => array(
			'rule' => 'notEmpty',
			'message' => "post ou project ?"
		)
	);


}