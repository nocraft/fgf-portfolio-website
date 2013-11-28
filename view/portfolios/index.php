<?php $title_for_layout = "Portfolio" ?>
<?php echo $this->Session->flash(); ?>
		<section class="secportfolio">
			<div class="menucat">
				<h1><small>
						<a class="all" href="#">All</a>
					<?php $categories = $this->request('Categories','index'); ?>
					<?php foreach ($categories['cats'] as $k => $v): ?>
						<?php if(!isset($categories['jointTotalCat'][$v->id]->totalcategories) == null && $v->typecat =='project') { ?>
						<a href="#<?php if($v->typecat =='project') echo $v->name;?>"><?php if($v->typecat =='project') echo $v->name;?></a>
						<div class="<?php  echo $v->name;?> catdesc hidden"><?php if($v->typecat =='project') echo $v->desccat;?></div>
						<?php }; ?>
					<?php endforeach; ?>
				</small></h1>
			</div>
			<div id="container">
				<?php foreach ($posts as $k => $v): ?>
				<project class="bloc <?php echo $v->catname; ?>">
					<a class="thumb" href="#project<?php echo $k; ?>">
						<div id="project<?php echo $k; ?>" class="item"><img src="<?php echo Router::webroot(substr($v->media['first'],0,-4).'_205x137.jpg'); ?>" alt="" width="205" height="137"/></div>
					</a>
					<a class="medium" href="<?php echo Router::url("portfolios/view/id:{$v->id}/slug:$v->slug"); ?>">
					<div class="info">
						<?php foreach ($v->media as $n => $m): if (is_int($n)) { ?>
						<div id="slideshow<?php echo $k;?>">
							<div id="slideshowWindow">
								<div class="slide">
									<img src="<?php echo Router::webroot(substr($m->file,0,-4).'_615x274.jpg'); ?>" alt="" width="615" height="274"/>
								</div><!--/slide-->									
							</div><!--/slideshowWindow-->
						</div><!--/slideshow-->
						<?php } endforeach; ?>
						<div id="contmeta<?php echo $k;?>" class="contmeta">
							<div class="titre"><?php echo $v->name;?></div>
							<span class="desc"><?php $w = substr(strip_tags($v->content),0,220); echo strlen ($w) >219  ? $w.'...' : $w ;?></span>
							<div class="meta">
								<div class="cat iconic iconic-tag"><?php echo $v->catname;?></div>
								<div class="comment iconic iconic-comment"><?php echo $v->comments['totalcomments']; ?></div>
								<div class="date iconic iconic-calendar_alt">le <?php echo $v->date;?></div>
							</div>
							<div class="suite">voir la suite</div>
						</div>
					</div>
					</a>
				</project>  
			<?php endforeach; ?>	
			</div>


		<div class="cb"></div>
		<hr>
		<div class="pagination portfolio">
			<?php for($i=1; $i <= $page; $i++): ?>
				<span <?php if($i==$this->request->page) echo 'class="current"'; ?>>
					<a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
				</span>
			<?php endfor; ?>
		</div>
		<br/>
		</section>
