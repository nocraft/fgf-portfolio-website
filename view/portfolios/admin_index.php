<div class="page-header">
	<h1><?php echo $total; ?> Projects</h1>
</div>

<table class="table table-hover">
	<thead>
		<tr>
			<th>ID</th>
			<th>En ligne ?</th>
			<th>Date</th>
			<th>Titre</th>
			<th>Catégorie</th>
			<th>Media</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($posts as $k => $v): ?>
			<tr>
				<td><?php echo $v->id; ?></td>
				<td><span class="label <?php echo ($v->online==1)?'label-success':'label-danger'; ?>"><?php echo ($v->online==1)?'En ligne':'Hors ligne'; ?></span></td>
				<td><?php echo $v->created; ?></td>
				<td><?php echo $v->name; ?></td>
				<td><?php echo $v->catname; ?></td>
				<td><?php echo count($v->media); ?></td>
				<td>
					<a href="<?php echo Router::url('admin/portfolios/edit/'.$v->id); ?>">Editer</a>
					<a onclick="return confirm('Voulez vous vraiment supprimer ce contenu'); " href="<?php echo Router::url('admin/portfolios/delete/'.$v->id); ?>">Supprimer</a>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>

<a href="<?php echo Router::url('admin/portfolios/edit'); ?>" class="primary btn">Ajouter un project</a>

<div>
  <ul class="pagination">
  <?php for($i=1; $i <= $page; $i++): ?>
    <li <?php if($i==$this->request->page) echo 'class="active"'; ?>><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
  <?php endfor; ?>
  </ul>
</div>

