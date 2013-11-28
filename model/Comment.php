<?php
class Comment extends Model{
	
	var $validate = array(
		'pseudo' => array(
			'rule' => '([a-z0-9\-]+)',
			'message' => ''
		),
		'mail' => array(
			'rule' => '^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$',
			'message' => ''
		),
		'content' => array(
			'rule' => 'notEmpty',
			'message' => ''
		)
	);

}