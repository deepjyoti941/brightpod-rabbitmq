<div class="container">
<!-- 
	<div class="jumbotron">
		<h1>Brightpod Timer</h1>
		<p>
			Welcome to Brightpod Timer! Track your tasks for project easily.
		</p>
	</div> -->


<!--timer coe start here -->

           <div class="row">
                <button class="tracking-remove-all btn btn-danger pull-right custom-position" style="display:none">Discard</button>
<!--                 <button class="save-tasks btn btn-success pull-right custom-position">Save Tasks</button>   
 -->            </div>

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
<!--                <div class="col-md-3">
                  	</div> -->
	                  <div class="col-md-2">
	                 		<span class="label label-success"><?php echo $row->task_time; ?></span>
	                 		<span class="label label-success"><?php echo $row->task_date; ?></span>
<!-- 	                 		<span><button class="btn btn-default start-timer" title="Restart timer" id="tracking-button-restart"></button></span>
 -->	                  </div>
<!--                <div class="col-md-2">
                  	</div> -->
							  	</div>
							  </li>
                <?php endforeach ?>
							</ul>
          	</div>
          </div>
<!--timer code end here -->



<!-- 	<div class="row">
			<div id="tracking-bar">
				<a href="#" class="tracking-create">New task</a> |
				<a href="#" class="tracking-remove-all">Delete all</a> |
				<input type="checkbox" name="tracking-show-completed" id="tracking-show-completed" value="1" title="Toggle completed" /> Completed
				<input type="checkbox" name="tracking-show-archived" id="tracking-show-archived" value="1" title="Toggle archived" /> Archived
			</div>		
	</div>


	<div class="row">
		<div id="tracking-content">
			<div id="tracking-form-list" class="tracking-form"></div>
			<div id="tracking-form-create" class="tracking-form" style="display: none">
				<p>
					<label for="tracking-task-name">Task name</label>
					<input type="text" name="tracking-task-name" id="tracking-task-name" class="form-control" />
				</p>
				<p>
					<label for="tracking-task-estimate">Estimate time</label>
					<input type="text" name="tracking-task-estimate" id="tracking-task-estimate" class="form-control" />
				</p>
				<p>
					<input type="button" id="tracking-button-create" class="btn btn-success" value="Save" />
					<a href="#" class="tracking-cancel btn btn-danger" rel="tracking-form-create">Cancel</a>
				</p>
				<p style="display: none" id="tracking-create-status"></p>
			</div>
			<div id="tracking-form-update" class="tracking-form" style="display: none">
			<p>
					<label for="tracking-task-name">Task name</label>
					<input type="text" name="tracking-task-name" id="tracking-task-name" class="form-control"/>
				</p>
				<p>
					<label for="tracking-task-estimate">Estimate</label>
					<input type="text" name="tracking-task-estimate" id="tracking-task-estimate" class="form-control" />
				</p>
				<p>
					<input type="checkbox" name="tracking-task-completed" id="tracking-task-completed" /> Task is completed<br />
					<input type="checkbox" name="tracking-task-archived" id="tracking-task-archived" /> Task is archived
				</p>
				<p>
					<label>Created at</label>
					<span id="created"></span>
				</p>
				
				<p>
					<input type="button" id="tracking-button-update" class="btn btn-warning" value="Update" />
					<a href="#" class="tracking-cancel btn btn-default" rel="tracking-form-update">Cancel</a>
				</p>
				<p style="display: none" id="tracking-update-status"></p>
			</div>
			<div id="tracking-form-remove" class="tracking-form" style="display: none">
				<p id="tracking-remove-confirm"></p>
				<p>
					<input type="button" id="tracking-button-remove" class="btn btn-danger" value="Delete" />
					<a href="#" class="tracking-cancel btn btn-default" rel="tracking-form-remove">Cancel</a>
				</p>
			</div>
			<div id="tracking-form-remove-all" class="tracking-form" style="display: none">
				<p>Are you sure you want to delete all tasks?</p>
				<p>
					<input type="button" id="tracking-button-remove-all" class="btn btn-danger" value="Delete all" />
					<a href="#" class="tracking-cancel btn btn-default" rel="tracking-form-remove-all">Cancel</a>
				</p>
			</div>
		</div>
	</div> -->



</div>
