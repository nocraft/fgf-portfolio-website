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
        <meta property="og:url" content="http://www.nocraft.fr/forum/topic/33">
        <meta property="og:language" content="fr">
        
		<title><?php echo isset($title_for_layout)?$title_for_layout:'Mon site'; ?></title>
		<link rel="icon" type="image/x-icon" href="/favicon.ico">
		<link class="usertheme" href="<?php echo Router::url('WEBROOT/css/fgf_tiredeyes.css'); ?>" rel="stylesheet">
		<link href="<?php echo Router::url('WEBROOT/css/bootstrap.css'); ?>" rel="stylesheet">
		<link href="<?php echo Router::url('WEBROOT/css/bootstrap-responsive.css'); ?>" rel="stylesheet">
		<script type="text/javascript" src="<?php echo Router::url('WEBROOT/js/jquery-1.10.2.min.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo Router::url('WEBROOT/js/jquery.cookie.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo Router::url('WEBROOT/js/masonry.pkgd.min.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo Router::url('WEBROOT/js/main.js'); ?>"></script>
    </head> 
    <body><?php $namecache = ($this->request->controller.'_'.$this->request->action.'_'.$this->request->page.str_replace('/', '_', $this->request->url)); ?>

		<div id="root"> 
			<!-- Affichage du header --> 
			<div class="toptitre">
				<div class="wrap">
				<span class="selecttheme">
					<ul id="nav">
						<li><a class="theme1" href="" rel="<?php echo Router::webroot('css/fgf_tiredeyes.css'); ?>"></a></li>
						<li><a class="theme2" href="" rel="<?php echo Router::webroot('css/fgf_whiteclean.css'); ?>"></a></li>
					</ul>
				</span>
				<span>FRANCISCO GARCIA FERNANDEZ | CG ARTIST</span>
				<hr/>
				</div>
			</div>
			<header class="header">
    			<div class="wrap">
    				<a href="<?php echo Router::url('blog'); ?>" class="logo"><img></a>
    				<nav>
						<a href="<?php echo Router::url('posts/index'); ?>">Blog</a>
						<a href="<?php echo Router::url('portfolios/index'); ?>">Portfolio</a>
    					<?php $pagesMenu = $this->request('Pages','getMenu'); ?>
						  <?php foreach($pagesMenu as $p): ?>
							<a href="<?php echo Router::url('pages/view/id:'.$p->id.'/slug:'.$p->slug); ?>" title="<?php echo $p->name; ?>"><?php echo $p->name; ?></a>
						  <?php endforeach; ?>
						<form method="get" action="<?php echo Router::url('searchs/index'); ?>" id="commentForm">
							<input name="q" placeholder="Rechercher" x-webkit-speech="">
						</form>
						<select id="responsive-selector">
							<option value="<?php echo Router::url('posts/index'); ?>" class="active">Blog</option>
							<option value="<?php echo Router::url('portfolios/index'); ?>">Portfolio</option>
						</select>
					</nav>
    			</div>
      		</header>
			
			<!-- Affichage du subhead -->
			<section id="Parallax" class="subhead">
					<span class="bullheader" >clic ici</span>
					<img src="<?php echo Router::webroot('css/img/header/header1.jpg'); ?>">

				<div class="wrap" id="subhead">
					<?php if(($this->request->controller == 'homes') && ($this->request->action == 'view')){ ?>
						<h1><?php echo "Acceuil"; ?></h1>					
					<?php } if(($this->request->controller == 'posts') && ($this->request->action == 'index')){ ?>
						<h1><?php echo "Blog"; ?></h1>
						<div class="meta">
							<a class="descselect">Le blog rassemble les different nouveauté, 
							des articles ainsi que les differents projects realisé</a>
						</div>
					<?php } if(($this->request->controller == 'posts') && ($this->request->action == 'view')){ ?>
						<h1><?php echo ucfirst($this->vars['post']->name); ?></h1>
						<div class="meta">
							<a class="iconic iconic-tag"><?php echo $this->vars['post']->catname; ?></a> |
							<a class="iconic iconic-comment"><?php echo $this->vars['post']->comments['totalcomments']; ?> Commentaire<?php echo ($this->vars['post']->comments['totalcomments']>1) ? 's' : '';  ?></a> |
							<a class="iconic iconic-calendar_alt">Le <?php echo $this->vars['post']->date; ?></a>
						</div>
					<?php } if(($this->request->controller == 'posts') && ($this->request->action == 'category')){ ?>
						<h1><?php echo $this->vars['title']; ?> (<?php echo $this->vars['total']; ?>)</h1>
					<?php } if(($this->request->controller == 'posts') && ($this->request->action == 'archive')){ ?>
						<h1><?php echo $this->vars['title']; ?> (<?php echo $this->vars['total']; ?>)</h1>						
					<?php } if(($this->request->controller == 'pages') && ($this->request->action == 'view')){ ?>
						<h1><?php echo $this->vars['page']->name; ?></h1>
					<?php } if(($this->request->controller == 'portfolios') && ($this->request->action == 'index')){ ?>
						<h1 id="titreselect"><?php echo ucfirst(substr($this->request->url,1));?></h1>
						<div class="meta">
							<a id="descselect" class="descselect"></a>
							<a id="catselect" class="iconic iconic-tag"></a>
							<a id="comselect" class="iconic iconic-comment"></a>
							<a id="dateselect" class="iconic iconic-calendar_alt">Le </a>
						</div>							
					<?php } if(($this->request->controller == 'portfolios') && ($this->request->action == 'view')){ ?>
						<h1><?php echo ucfirst($this->vars['post']->name); ?></h1>
						<div class="meta">
							<a class="iconic iconic-tag"><?php echo $this->vars['post']->catname; ?> |</a>
							<a class="iconic iconic-comment"><?php echo $this->vars['post']->comments['totalcomments']; ?> Commentaire<?php echo ($this->vars['post']->comments['totalcomments']>1) ? 's' : '';  ?> |</a>
							<a class="iconic iconic-calendar_alt">Le <?php echo $this->vars['post']->date; ?></a>
						</div>
					<?php } if(($this->request->controller == 'portfolios') && ($this->request->action == 'category')){ ?>
						<h1><?php echo $this->vars['title']; ?> (<?php echo $this->vars['total']; ?>)</h1>
					<?php } if(($this->request->controller == 'xx') && ($this->request->action == 'xx')){ ?>
					<div class="meta">
						<a class="iconic iconic-tag"><?php echo $this->vars['post']->catname; ?> |</a>
						<a class="iconic iconic-comment"><?php echo $this->vars['post']->comments['totalcomments']; ?> Commentaire<?php echo ($this->vars['post']->comments['totalcomments']>1) ? 's' : '';  ?> |</a>
						<a class="iconic iconic-calendar_alt">Le <?php echo $this->vars['post']->date; ?></a>
					</div>
					<?php }?>
				</div>
			</section>
			
			<!-- Affichage du file d'ariane --> 
			<section class="breadcrumb">
				<div class="wrap">
					<?php $breadcrumb = $this->request('Posts', 'getBreadcrumb'); ?>
					<nav class="breadcrumb">
						<?php foreach($breadcrumb as $k => $v) : ?>
							<div itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
								<a href="<?php echo Router::url($v.'/'); ?>"><?php echo $v; ?></a>			
							</div>
						<?php endforeach; ?>
					</nav>
					<nav class="navbar">
						<!--<?php if($this->request->controller == 'portfolios'){  ?>
						<a href="#" class="list grid" id="gridList">Grille</a>
						<a href="#" class="tag" id="showFilter">Filtrer par catégorie</a>
						<?php }; ?>-->
					</nav>
				</div>
			</section>
			
			<!-- Affichage le content --> 
			<div class="wrap2">
			<?php echo $content_for_layout;?>
			</div>
			<!-- Affichage le footer --> 
			<div class="wrap">
				<div class="footer">
					<span>Copyright 2013. All Rights Reserved. Design & Developed by fgf .version0.3</span>
				</div>
			</div>			
			<!-- reset --> 
			<div class="cb"></div>
		</div>
    </body> 
</html>
