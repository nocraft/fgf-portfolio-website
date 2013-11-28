<?php $title_for_layout = $post->name; ?>
<?php echo $this->Session->flash(); ?>

<section class="posts view">
	<article>
		<?php echo $post->content;?>
	</article>
	<aside id="comments">
		<hr>
		<div class="title">
			<span><strong><?php echo $post->comments['totalcomments']; ?></strong> Commentaire<?php echo ($post->comments['totalcomments']>1) ? 's' : '';  ?></span>
		</div>
		<form action="<?php echo Router::url("posts/view/".$post->id."/".$post->slug); ?>" id="commentForm" method="post">	
			<div class="input text required">
				<?php echo $this->Form->input('pseudo','Pseudo'); ?>
			</div>		
			<div class="input text mail required">
				<?php echo $this->Form->input('mail','Email'); ?>
			</div>		
			<div class="input textarea required">
				<?php echo $this->Form->input('content','Commentaire :',array('type'=>'textarea','class'=>'xxlarge','rows'=>5)); ?>
			</div>	
			<div class="submit">
				<input type="submit" value="Envoyer">
			</div>
			<div style="display:none;">
				<?php echo $this->Form->input('created','hidden'); ?>
			</div>
		</form>

		<?php foreach($post->comments['comments'] as $k => $v): ?>         
		<div class="comment" id="comment<?php echo $v->id; ?>">

			<div class="avatar">
				<img src="<?php echo Router::webroot('css/img/anonymous.png'); ?>" alt="">			
			</div>
			<div class="message">
				<div class="author">
					<strong><a href="<?php echo $v->mail; ?>"><?php echo $v->pseudo; ?></a></strong>
					<em> - <?php echo $v->created; ?></em>
				</div>
				<div class="content">
					<?php echo $v->content; ?>
				</div>
			</div>
		</div>
		<?php endforeach ?>
	</aside>
</section>