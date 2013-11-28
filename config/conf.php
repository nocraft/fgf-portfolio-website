<?php
class Conf{
	static $debug = 1; 

	static $databases = array(

		'default' => array(
			'host'		=> '127.0.0.1',
			'database'	=> 'franciscofolio',
			'login'		=> 'franciscofolio',
			'password'	=> '$cqsper07$'
		)
	);


}
// Déclaration des SALT
define('PREFIX_SALT', 'DYhG93b0qyJfIxfs2guVoUubWwvniR2G0FgaC9mi');
define('SUFFIX_SALT', 'im9CagF0G2RinvwWbuUoVug2sfxIfJyq 0b39GhYD');

Router::prefix('cockpit','admin');

//home
Router::connect('', 'posts/index');

//page
Router::connect(':slug-:id','pages/view/id:([0-9]+)/slug:([a-z0-9\-]+)');

//blog
Router::connect('blog/:slug-:id','posts/view/id:([0-9]+)/slug:([a-z0-9\-]+)');
Router::connect('blog/categorie/:slug','posts/category/slug:([a-z0-9\-]+)');
Router::connect('blog/archive/:created','posts/archive/created:([a-z0-9\-]+)');
Router::connect('blog','posts/index');
Router::connect('blog/*','posts/*');

//portfolio
Router::connect('portfolio/:slug-:id','portfolios/view/id:([0-9]+)/slug:([a-z0-9\-]+)');
Router::connect('portfolio','portfolios/index');
Router::connect('portfolio/*','portfolios/*');

//search
Router::connect('search','searchs/index');
Router::connect('search*','searchs/index*');


//admin
Router::connect('cockpit', 'cockpit/posts/index');
