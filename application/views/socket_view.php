
<script type="text/javascript">

  function updateOnlineCount() {
    $('#widget_counter_member').html($('.widget_member').length);
  }
  
  function resetWhosEditing () {
    $('#whos_editing').text('');
  }
  var channel = "<?php echo 'presence-'.$note['channel'] ?>";
  pusher = new Pusher('dd7bae8d4eea81d560ec');
  Pusher.channel_auth_endpoint = '/notes/auth';
  online_channel = pusher.subscribe(channel);

  pusher.connection.bind('connected', function() {
    online_channel.bind('pusher:subscription_succeeded', function(members) {
      var whosonline_html = '';
      members.each(function(member) {
        whosonline_html += '<li class="widget_member" id="widget_member_' + 
        member.id + '">' + member.info.username + '</li>';
      });
      $('#widget_online_list').html(whosonline_html);
      updateOnlineCount();
    });

    online_channel.bind('pusher:member_added', function(member) {
      $('#widget_online_list').append('<li class="widget_member" ' +
        'id="widget_member_' + member.id + '">' + member.info.username + '</li>');
      updateOnlineCount();
    });

    online_channel.bind('pusher:member_removed', function(member) {
      $('#widget_member_' + member.id).remove();

        resetWhosEditing();
        updateOnlineCount();
      });
    });

    online_channel.bind('whos_editing', function(data) {
      $('#whos_editing').text(data.message)
    });


  $('form.notes-update-form input, textarea').on('input propertychange change', function() {    
    $.post( "/notes/whoisEditing", { channel_name: channel })
    .done(function( data ) {

    });
  });
</script>