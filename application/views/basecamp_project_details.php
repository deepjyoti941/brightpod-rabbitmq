<div class="container">
	<div class="row">
		<h2>Project details for <strong><?php echo $project->name;?></strong></h2>
		<hr>

		<div class="bs-callout bs-callout-danger" id="callout-modal-youtube">
	    <h4>Basic Details</h4>
	    <p>description: <strong><?php echo $project->description;?></strong></p>
	    <p>is_client_project: <strong><?php echo $project->is_client_project;?></strong></p>
	    <p>created_at: <strong><?php echo $project->created_at;?></strong></p>
	    <p>updated_at: <strong><?php echo $project->updated_at;?></strong></p>
	    <p>url: <strong><?php echo $project->url;?></strong></p>
	    <p>app_url: <strong><?php echo $project->app_url;?></strong></p>

	  </div>

		<div class="bs-callout bs-callout-info" id="callout-modal-youtube">
	    <h4>Creator of project</h4>
	    <img src="<?php echo $project->creator->avatar_url;?>">
	    <p>Id: <strong><?php echo $project->creator->id;?></strong></p>
	    <p>Name: <strong><?php echo $project->creator->name;?></strong></p>
	  </div>

		<div class="bs-callout bs-callout-warning" id="callout-modal-youtube">
	    <h4>Full Object</h4>
	    <pre>
				<?php var_dump($project);?>
			</pre>
	  </div>

	</div>
</div>
