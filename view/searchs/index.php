<!-- Affichage des flash--> 
<?php $title_for_layout = "Recherche"; ?>
<?php echo $this->Session->flash(); ?>
<div class="wrap blog">
	<section class="blog">
		<section class="search">

			<div><?php echo $total; ?> Résultat pour la recherche "<?php echo $search; ?>".</div>
			<?php foreach ($posts as $k => $v): ?>
			<article>
					<?php if($v->type == 'post'){ ?>
					<h2><a href="<?php echo Router::url("posts/view/id:{$v->id}/slug:$v->slug"); ?>" title=""><?php echo $v->name; ?></a></h2>
					<?php } if($v->type == 'project'){ ?>
					<h2><a href="<?php echo Router::url("portfolios/view/id:{$v->id}/slug:$v->slug"); ?>" title=""><?php echo $v->name; ?></a></h2>
					<?php };?>				

				<aside class="meta">
					<span class="date"><?php echo $v->date; ?></span>
					<?php if($v->type == 'post'){ ?>
					<span class="comments"><a href="<?php echo Router::url("posts/view/id:{$v->id}/slug:$v->slug"); ?>"><?php echo $v->comments['totalcomments']; ?> Commentaire<?php echo ($v->comments['totalcomments']>1) ? 's' : '';  ?></a></span>
					<?php } if($v->type == 'project'){ ?>
					<span class="comments"><a href="<?php echo Router::url("portfolios/view/id:{$v->id}/slug:$v->slug"); ?>"><?php echo $v->comments['totalcomments']; ?> Commentaire<?php echo ($v->comments['totalcomments']>1) ? 's' : '';  ?></a></span>
					<?php };?>
					<span class="category"><a href="<?php echo Router::url('posts/category/slug:'.$v->catslug); ?>"><?php echo $v->catname; ?></a></span>
				</aside>
				<?php if(!empty($v->media['first'])){ ?>
					<?php if($v->type == 'post'){ ?>
					<a href="<?php echo Router::url("posts/view/id:{$v->id}/slug:$v->slug"); ?>" class="thumb"><img src="<?php echo Router::webroot(substr($v->media['first'],0,-4).'_330x210.jpg'); ?>" alt=""></a>
					<?php } if($v->type == 'project'){ ?>
					<a href="<?php echo Router::url("portfolios/view/id:{$v->id}/slug:$v->slug"); ?>" class="thumb"><img src="<?php echo Router::webroot(substr($v->media['first'],0,-4).'_330x210.jpg'); ?>" alt=""></a>
					<?php };?>
				<div class="content">
					<p><?php echo substr(strip_tags($v->content),0,300); ?>...</p>
					<?php if($v->type == 'post'){ ?>
					<p><a href="<?php echo Router::url("posts/view/id:{$v->id}/slug:$v->slug"); ?>" class="btn" title="">Lire l'article</a></p>
					<?php } if($v->type == 'project'){ ?>
					<p><a href="<?php echo Router::url("portfolios/view/id:{$v->id}/slug:$v->slug"); ?>" class="btn" title="">Voir le projet</a></p>
					<?php };?>
				</div>
				<?php }else{ ?> 
				<div class="nothumb">
					<p><?php echo substr(strip_tags($v->content),0,800); ?>...</p> 
					<?php if($v->type == 'post'){ ?>
					<p><a href="<?php echo Router::url("posts/view/id:{$v->id}/slug:$v->slug"); ?>" class="btn" title="">Lire l'article</a></p>
					<?php } if($v->type == 'project'){ ?>
					<p><a href="<?php echo Router::url("portfolios/view/id:{$v->id}/slug:$v->slug"); ?>" class="btn" title="">Voir le projet</a></p>
					<?php };?>
				</div>				
				<?php }; ?>
				<div class="cb"></div>
			</article>
			<?php endforeach ?>
			<div class="cb"></div>
			<hr>
			<br/>
		</section>
	</section>
</div>
<div class="cb"></div>
