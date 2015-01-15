<div class="container">
	<div class="row">
		<h2>People List</h2>
		<hr>
		<table class="people_list table table-condensed">
			<thead>
        <tr>
          <th></th>
          <th>People Id</th>
          <th>People Name</th>
        </tr>
      </thead>
      <tbody>
				<?php foreach ($people as $key => $row):?>
		    <tr>
		      <td>
		          <input type="checkbox" />
		      </td>
		      <td><?php echo $row->id?></td>
		      <td><?php echo $row->name?></td>
		    </tr>
		    <?php endforeach?>
      </tbody>
		</table>
		<button id="export_people_list" class="btn btn-primary pull-right">export selected people</button>

	</div>
	<div class="row">
	  <div id="people_list_progress" class="col-md-4 col-md-offset-5 display_hidden">
	    <img src="<?php echo base_url('assets/images/loader.gif')?>">
	    exporting people...please wait
	  </div>
	  <div id="people_list_done" class="col-md-4 col-md-offset-5 display_hidden">
	    <span class='label label-success'>People exporeted successfully</span>
	    <p>You can see exports at <a href="<?php echo base_url('exports')?>">HERE</a></p>
	  </div>
	</div>
</div>
