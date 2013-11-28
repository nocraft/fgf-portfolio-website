<div class="page-header">
	<h1>Editer un catégorie</h1>
</div>

<form action="<?php echo Router::url('admin/categories/edit/'.$id); ?>" method="post">
	<?php echo $this->Form->input('name','Titre'); ?>
  	<?php echo $this->Form->input('slug','Url'); ?>
  	<?php echo $this->Form->input('desccat','Description',array('type'=>'textarea','class'=>'xxlarge wysiwyg','rows'=>5)); ?>
  	<?php echo $this->Form->input('typecat','Typecat',array('options' => array('post' => 'post','project' => 'project'))); ?>

	<?php echo $this->Form->input('id','hidden'); ?>
	<br>
	<div class="actions">
		<input type="submit" class="btn primary" value="Envoyer">
	</div>
</form>