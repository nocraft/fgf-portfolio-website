<?php $title_for_layout = $post->name; ?>
<?php echo $this->Session->flash(); ?>
<section class="portfolios view">
	<viewer>
		<div id="viewer" class="view">
						<div class="fullv">
							<a href="<?php echo Router::webroot($post->media['first']); ?>">
							<img src="<?php echo Router::webroot($post->media['first']); ?>"/>
							</a>
						</div>
		</div>
		<div id="container2" class="contentthumb">

						<?php foreach ($post->media as $n => $m): if (is_int($n)) { ?>
						<a alt="<?php echo $m->name ?>" href="#projectv<?php echo $n; ?>">
							<div id="thumb<?php echo $n;?>">
								<div class="thumbv">
									<img src="<?php echo Router::webroot(substr($m->file,0,-4).'_205x137.jpg'); ?>" alt=""/>
								</div>
							</div>
						</a>
						<?php } endforeach; ?>
		</div>
	</viewer>
	<projet>
		<?php echo $post->content;?>
	</projet>
	<aside id="comments">
		<hr>
		<div class="title">
			
			<span><strong><?php echo $post->comments['totalcomments']; ?></strong> Commentaire<?php echo ($post->comments['totalcomments']>1) ? 's' : '';  ?></span>
		</div>

		<form action="<?php echo Router::url("portfolios/view/".$post->id."/".$post->slug); ?>" id="commentForm" method="post">
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
			<hr>
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