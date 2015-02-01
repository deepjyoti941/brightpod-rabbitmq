  <button type="button" class="timer_button btn btn-primary" style="display:none" data-toggle="modal" data-target=".bs-example-modal-lg">Start</button>
  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">
            TIMER STATUS
<!--             <div class="row">
              <div id="tracking-bar">
                <input type="checkbox" name="tracking-show-completed" id="tracking-show-completed" value="1" title="Toggle completed" /> Completed
                <input type="checkbox" name="tracking-show-archived" id="tracking-show-archived" value="1" title="Toggle archived" /> Archived
                <button class="tracking-remove-all btn btn-danger pull-right custom-position">Delete all</button>
                <button class="save-tasks btn btn-success pull-right custom-position">Save Tasks</button>
              </div>    
            </div> -->
          </h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div id="tracking-content">
              <div id="tracking-form-create" class="tracking-form">
                <div class="row">
                  <div class="col-md-4">
                  <label>Task Name</label>
                    <input type="text" name="tracking-task-name" id="tracking-task-name" class="form-control" placeholder="what are you working on?">
                  </div>
                  <div class="col-md-4">
                    <label>Task List Name</label>
                    <select class="form-control" id="task_list">
                      <option value="0">select a tasklist</option>
                    </select>                    
                  </div>
                  <div class="col-md-4">
                    <label>Timer</label>
                    <div id="timer-container">

<!--                       <span id="current-timer"></span>
 -->                     <!--  <a href="#" class="start-timer" title="Timer play/pause" id="tracking-button-create"></a> -->
<!--                       <input type="button" id="tracking-button-create" class="btn btn-sm btn-success col-lg-6 pull-right" value="Start">
 -->                    </div>
                  </div>
                </div>
                <p style="display: none" id="tracking-create-status"></p>
              </div>
              <div id="tracking-form-list" class="tracking-form"></div>

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
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--some footer content here -->
  <script src="<?php echo base_url('assets/lib/js/pusher.min.js')?>"></script>
  <script src="<?php echo base_url('assets/js/jquery.min.js')?>"></script>
  <script src="<?php echo base_url('assets/lib/js/jquery.cookie.js')?>"></script>

  <script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('assets/lib/wysiwyg/js/wysihtml5-0.3.0.min.js')?>"></script>
  <script src="<?php echo base_url('assets/lib/wysiwyg/js/bootstrap3-wysihtml5.js')?>"></script>
  <script src="<?php echo base_url('assets/lib/toastr/toastr.js')?>"></script>
  <script src="<?php echo base_url('assets/lib/bootbox/bootbox.min.js')?>"></script>
  <script src="<?php echo base_url('assets/js/moment.js')?>"></script>
  <script src="<?php echo base_url('assets/js/jquery.json-2.2.min.js')?>"></script>
  <script src="<?php echo base_url('assets/js/domcached-0.1-jquery.js')?>"></script>

  <script src="<?php echo base_url('assets/js/main.js')?>"></script>
</body>
</html>
