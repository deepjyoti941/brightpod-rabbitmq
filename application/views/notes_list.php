<div class="col-md-4">
	<button type="button" id="add_notes" class="btn col-lg-6 send-message-btn" aria-label="Left Align">
		<i class="fa fa-plus"></i> Add Notes
	</button>
	<button type="button" id="cancel_notes" class="btn col-lg-6 send-message-btn" aria-label="Left Align">
		<i class="fa fa-times"></i> Cancel
	</button>
	</br></br>
</div>

<form class="notes-form" method="post">
	<div id="new_notes_section" class="col-md-12">
	  <div class="form-group">
	    <label>Title </label>
			<input type="text" class="form-control" id="note_title" name="note_title">
	  </div>
	  <div class="form-group">
	    <label>Content </label>
			<textarea id="note_content" name="note_content" class="form-control" style="height:250px"></textarea>
		</div>
		  <div class="btn-panel">
		    <input type="submit" class="col-lg-3 btn send-message-btn pull-right" value="save">
			</div>
		</br></br></br></br>
		<hr>
	</div>
</form>

<div class="col-md-12">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">
	    Notes List</h3>
	  </div>
	  <ul class="list-group" id="notes_listing">
			<?php foreach ($notes as $key=>$row): ?>
				<a href="<?php echo base_url().'notes/'.$row->id ?>" class="list-group-item"><strong><?php echo $row->name ?></strong> (Last Updated: <?php echo $row->updated_on ?> By <i><?php echo $row->user_name ?></i>)</a>
			<?php endforeach ?>
	  </ul>
	</div>
</div>
