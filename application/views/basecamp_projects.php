<div class="container">
	<div class="row">
		<h2>Projects</h2>
		<hr>
		<ul class="list-group" id="notes_listing">
<?php foreach ($projects as $key => $row):?>
	<a href="<?php echo base_url() . 'basecamp/projects/' . $row->id?>" class="list-group-item"><strong><?php echo $row->name?></strong></a>
<?php endforeach?>
</ul>
	</div>
</div>
