<div class="container">
	<div class="row">
		<h2>Projects</h2>
		<hr>
		<table class="project_list table table-condensed">
			<thead>
        <tr>
          <th></th>
          <th>Project Id</th>
          <th>Project Name</th>
        </tr>
      </thead>
      <tbody>
				<?php foreach ($projects as $key => $row):?>
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
		<div class="row">
			<div class="col-md-10">
				<input type="text" id="user_email" class="form-control" placeholder="enter email address to get notification when export is done">
			</div>
			<div class="col-md-2">
				<button id="export_project_list" class="btn btn-primary pull-right">export selected projects</button>
			</div>
		</div>
		<br><br><br><br>
	</div>

	<div class="row">
<!-- 	  <div id="project_list_progress" class="col-md-4 col-md-offset-5 display_hidden">
	    <img src="<?php echo base_url('assets/images/loader.gif')?>">
	    exporting projects...please wait
	  </div> -->
	  <div id="project_list_done" class="col-md-4 col-md-offset-5 display_hidden">
	    <span class='label label-success'>You exports are in progress.You will get mail when it is done</span>
	    <p>You can your exports <a href="<?php echo base_url('exports')?>">HERE</a></p>
	  </div>
	</div>
</div>
