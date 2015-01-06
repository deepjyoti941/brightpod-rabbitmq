<div class="container">
	<div class="row">
		<h2>Calender List</h2>
		<hr>
		<table class="calender_list table table-condensed">
			<thead>
        <tr>
          <th></th>
          <th>Calender Id</th>
          <th>Calender Name</th>
        </tr>
      </thead>
      <tbody>
				<?php foreach ($calendars as $key => $row):?>
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
		<button id="export_calender_list" class="btn btn-primary pull-right">export selected calenders</button>

	</div>
	<div class="row">
	  <div id="calender_list_progress" class="col-md-4 col-md-offset-5 display_hidden">
	    <img src="<?php echo base_url('assets/images/loader.gif')?>">
	    exporting calenders...please wait
	  </div>
	  <div id="calender_list_done" class="col-md-4 col-md-offset-5 display_hidden">
	    <span class='label label-success'>Calenders exporeted successfully</span>
	    <p>You can see exports at <a href="<?php echo base_url('exports')?>">HERE</a></p>
	  </div>
	</div>
</div>
