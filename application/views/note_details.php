<div class="col-lg-3">
  <div class="btn-panel btn-panel-conversation">
  </div>
</div>

<div class="col-lg-offset-1 col-lg-7">
  <div class="btn-panel btn-panel-msg">
    <a href="/notes/listing" class="btn  col-lg-6  send-message-btn_new pull-right" role="button"><i class="fa fa-plus"></i> New Notes</a>
  </div>
</div>

<div class="conversation-wrap col-lg-2" id="online_list">
  <div id="widget_main_container">
    <div id="widget_online">
      <p>Online Team Members (<span id="widget_counter_member">0</span>)</p>
      <hr>
      <ul id="widget_online_list" class="list-group">
      </ul>
    </div>
    <div class="clear"></div>
    <hr>
      <label>Who is editing</label><br>
      <ul id="whos_editing" class="list-group">
      </ul>
 </div>
</div>

<form class="notes-update-form" method="post">
  <div class="message-wrap col-lg-9">
    <div class="send-wrap ">
      <label>Title </label>
      <input type="text" class="form-control" name="note_title" value="<?php echo $note['name'] ?>">
      <label>Content </label>
      <textarea id="update_note_content" name="update_note_content" class="form-control" style="height:350px"><?php echo $note['description'] ?></textarea>
    </div>
    <div class="btn-panel">
      <input type="submit" class="col-lg-4 text-right btn   send-message-btn pull-right" value="Update">
  </div>
  </div>
</form>