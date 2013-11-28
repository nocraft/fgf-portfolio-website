<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr"> 
        <head>
		<meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="copyright" content="http://nocraft.fr">
        <meta name="author" content="nocraft.fr">
        <meta name="language" content="fr">
        <meta http-equiv="content-language" content="fr">
        <meta property="og:site_name" content="blbbla">
        <meta property="og:title" content="<?php echo isset($title_for_layout)?$title_for_layout:'Mon site'; ?>">
        <meta property="og:url" content="http://www.grafikart.fr/forum/topic/33">
        <meta property="og:language" content="fr">
        
		<title><?php echo isset($title_for_layout)?$title_for_layout:'Mon site'; ?></title>
		<link rel="icon" type="image/x-icon" href="/favicon.ico">

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>		
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
		<link href="<?php echo Router::url('WEBROOT/css/admin.css'); ?>" rel="stylesheet" type="text/css" media="screen" />
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
		<script>
	</script> 
    </head> 
    <body>       
		<header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" style="position: static" role="banner">
		  <div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<h3><a href="<?php echo Router::url('admin/posts/index'); ?>" class="navbar-brand">Administration</a></h3> 
			</div>
			<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
              <ul class="nav navbar-nav"> 
                <li><a href="<?php echo Router::url('admin/posts/index'); ?>">Articles</a></li>
                <li><a href="<?php echo Router::url('admin/portfolios/index'); ?>">Projects</a></li>
                <li><a href="<?php echo Router::url('admin/pages/index'); ?>">Pages</a></li>
                <li><a href="<?php echo Router::url('admin/categories/index'); ?>">Catégories</a></li>
                <li><a href="<?php echo Router::url(); ?>">Voir le site</a></li>
                <li><a href="<?php echo Router::url('users/logout'); ?>">Se déconnecter</a></li>
              </ul>
			</nav>
		  </div>
		</header>
				 
        <div class="container" style="padding-top:60px;">
            <?php echo $this->Session->flash(); ?>
        	<?php echo $content_for_layout; ?>
        </div>
         
    </body> 
    <script type="text/javascript" src="<?php echo Router::webroot('js/datepicker-fr.js'); ?>"></script>
    <script type="text/javascript">
        $(function(){
            $.datepicker.setDefaults( $.datepicker.regional['fr'] ); 
            $( ".datepicker" ).datepicker({
                dateFormat : 'yy-mm-dd'
            });
        })
    </script>
</html>