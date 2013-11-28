<div class="widget categories">
	<div class="title"><span>Catégories</span></div>		
		<?php $categories = $this->request('Categories','index'); ?>
		<?php foreach ($categories['cats'] as $k => $v): ?>
					<?php if (isset($categories['jointTotalCat'][$v->id]->totalcategories)){ ?>
					<a href="<?php echo Router::url('posts/category/slug:'.$v->slug); ?>"><?php echo $v->name; ?><em><?php echo isset($categories['jointTotalCat'][$v->id]->totalcategories)? $categories['jointTotalCat'][$v->id]->totalcategories :'0'; ?></em></a>
					<?php }; ?>
		<?php endforeach ?>
</div>
<div class="widget categories">
	<div class="title"><span>Archives</span></div>
	
		<?php foreach(array_slice($categories['jointDatePostId'], 0, 6) as $k => $v): ?>
     		<a href="<?php echo Router::url('posts/archive/created:'.$k); ?>"><?php echo $v['date']; ?><em><?php echo isset($v['totalByDate'])?$v['totalByDate']:'0';?></em></a>
		<?php endforeach ?>

<?php if(count($categories['jointDatePostId']) > 7){  ?>
	<a id="seemore" href="#" class="seemore iconic iconic-arrow_down">Voir plus</a>
	<div id="hidden" class="hidden">
		<?php foreach(array_slice($categories['jointDatePostId'], 7) as $k => $v): ?>
     		<a href="<?php echo Router::url('posts/archive/created:'.$k); ?>"><?php echo $v['date']; ?><em><?php echo isset($v['totalByDate'])?$v['totalByDate']:'0';?></em></a>
		<?php endforeach  ?>
	</div>
 <?php } ?>
</div>