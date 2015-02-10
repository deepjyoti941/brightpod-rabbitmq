<div class="container popup_timer_container">
	<div class="row">
		<div class="col-md-12" id="popup_timer">
			<span class="popup_timer">0:00:00</span>
		</div>
		<div class="col-md-12 popup_timer_content" style="padding-left: 210px;">
			<button class="btn btn-success popup_timer_buttons" id="start_popup_timer">START</button>
			<button class="btn btn-success popup_timer_buttons" style="display:none" id="play_popup_timer">PLAY</button>
			<button class="btn btn-danger popup_timer_buttons" style="display:none" id="stop_popup_timer">STOP</button>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12" style="margin-top: 55px;">
			<input type="text" name="popup-task-name" id="popup-task-name" style="padding: 22px;" class="form-control popup_custom" placeholder="what are you working on?">
		</div>
		<div class="col-md-12">
	    <select class="form-control popup_custom" id="project_list">
        <option value="0">select a project</option>
        <?php foreach ($projects as $key=>$row): ?>
         <option value="<?php echo $row->project_id; ?>"><?php echo $row->name; ?></option>
       <?php endforeach ?>
     </select>
		</div>
		<div class="col-md-12">
      <select class="form-control popup_custom" id="task_list">
        <option value="0">select a tasklist</option>
      </select>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<button class="btn btn-success btn-lg btn-block popup_custom">SAVE</button>
		</div>
		<div class="col-md-12">
			<button class="btn btn-danger btn-lg btn-block popup_custom">DISCARD</button>
		</div>
	</div>
</div>