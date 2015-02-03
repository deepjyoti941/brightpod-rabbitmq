<div class="container">
<!-- 
	<div class="jumbotron">
		<h1>Brightpod Timer</h1>
		<p>
			Welcome to Brightpod Timer! Track your tasks for project easily.
		</p>
	</div> -->


<!--timer code start here -->

 	<div class="row">
	 	<div class="btn-group pull-right custom-position mannual-time" role="group">
	    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	      Add Manually
	      <span class="caret"></span>
	    </button>
	    <ul class="dropdown-menu" role="menu">
	    <div class="row">
	    	<div class="col-md-6">
	    		<label>start</label>
					<input type="text" name="from-time" id="from-time" value="" class="form-control">
	    	</div>
	    	<div class="col-md-6">
	    		<label>stop</label>
					<input type="text" name="to-time" id="to-time" value="" class="form-control">
	    	</div>
	    </div>
	    <br>
	    <div class="row">
	    	<div class="col-md-12">
	    	  <button class="form-control btn btn-success">Apply</button>
	    	</div>
	    </div>
	    </ul>
	  </div>
    <button class="tracking-remove-all btn btn-danger pull-right custom-position" style="display:none">Discard</button>
  </div>

  <div class="row">
    <div id="tracking-content">
      <div id="tracking-form-create" class="tracking-form">
        <div class="row">
          <div class="col-md-4">
            <input type="text" name="tracking-task-name" id="tracking-task-name" class="form-control" placeholder="what are you working on?">
          </div>
          <div class="col-md-3">
            <select class="form-control" id="project_list">
              <option value="0">select a project</option>
          		<?php foreach ($projects as $key=>$row): ?>
              	<option value="<?php echo $row->project_id; ?>"><?php echo $row->name; ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="col-md-3">
            <select class="form-control" id="task_list">
              <option value="0">select a tasklist</option>
            </select>                    
          </div>
          <div class="col-md-2">
            <div id="timer-container">
             <button class="btn btn-success start-timer" title="Timer play/pause" id="tracking-button-create">START</button>
           </div>
          </div>
        </div>
        <p style="display: none" id="tracking-create-status"></p>
      </div>
      <div id="tracking-form-list" class="tracking-form"></div>
      <div id="tracking-form-remove" class="tracking-form" style="display: none">
        <p id="tracking-remove-confirm"></p>
        <p>
          <input type="button" id="tracking-button-remove" class="btn btn-danger" value="Delete" />
          <a href="#" class="tracking-cancel btn btn-default" rel="tracking-form-remove">Cancel</a>
        </p>
      </div>
      <div id="tracking-form-remove-all" class="tracking-form" style="display: none">
        <p>Are you sure you want discard the task?</p>
        <p>
          <input type="button" id="tracking-button-remove-all" class="btn btn-danger" value="Yes" />
          <a href="#" class="tracking-cancel btn btn-default" rel="tracking-form-remove-all">Cancel</a>
        </p>
      </div>
    </div>
  </div>

  <div class="row">
  	<div class="col-md-12 task-list-group">
			<ul class="list-group ul-task-list" id="task-list">
			<?php foreach ($tasks as $key=>$row): ?>
			  <li class="list-group-item">
			  	<div class="row">
			  		<div class="col-md-6">
			  			<span class="task-name-style"><?php echo $row->task_name; ?></span>
			  			<span rel="<?php echo $row->project_id; ?>" class="label label-default"><?php echo $row->name; ?></span>
			  		</div>

            <div class="col-md-2">
           		<span class="label label-success"><?php echo $row->task_time; ?></span>
           		<span class="label label-success"><?php echo $row->task_date; ?></span>
          	</div>
			  	</div>
			  </li>
        <?php endforeach ?>
			</ul>
  	</div>
  </div>
<!--timer code end here -->

</div>
