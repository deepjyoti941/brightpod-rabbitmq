  <button type="button" class="timer_button btn btn-primary" style="display:none" data-toggle="modal" data-target=".bs-example-modal-lg">Start</button>
  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <button class="tracking-remove-all btn btn-danger pull-right custom-position" style="display:none">Discard</button>
          </div>
        </div>
        <div class="row">
          <div id="tracking-content">
            <div id="tracking-form-create" class="tracking-form">
              <div class="row">
                <div class="col-md-3">
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
              <div class="col-md-3">
                <div id="timer-container" class="modal_timer_container">
                 <button class="btn btn-success start-timer" title="Timer play/pause" id="tracking-button-create">START</button>
               </div>
             </div>
           </div>
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
      </div>
    </div>
  </div>
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-59675387-1', 'auto');
    ga('send', 'pageview');

  </script>
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
  <script src="<?php echo base_url('assets/js/date-time-picker.js')?>"></script>

  <script src="<?php echo base_url('assets/js/jquery.json-2.2.min.js')?>"></script>
  <script src="<?php echo base_url('assets/js/domcached-0.1-jquery.js')?>"></script>

  <script src="<?php echo base_url('assets/js/main.js')?>"></script>
</body>
</html>
