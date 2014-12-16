(function ($) {

  /*
  * code for rabbitmq mail queue start here
  */

  $("#user_list").on("click", '.send_mail', function () {
    var data = [];
    var post_data = {};
    var $this = $(this);
    var parent_tr = $this.closest('td').parent('tr');
    parent_tr.addClass("highlite");
    $(parent_tr).find('td').each(function () {
      data.push($(this).find('input').val());
    });
    data.splice(-1, 1);
    post_data.name = data[0];
    post_data.email = data[1];
    post_data.task_id = data[2];
    post_data.user_id = data[3];
    post_data.client_id = data[4];
    post_data.added_datetime = data[5];

    notification('email sent');

    $.post("/welcome/queue", post_data)
    .done(function (data) {});
  });

  $("#add_user").on("click", function () {
    var $tableBody = $('#user_list').find("tbody"),
    $trLast = $tableBody.find("tr:last"),
    $trNew = $trLast.clone();
    $trLast.after($trNew);
  });


  /*
  * end here
  */



  /*
  * code for notes here
  */

  $('#note_content').wysihtml5({
    "font-styles":  true, //Font styling, e.g. h1, h2, etc
    "color":        true, //Button to change color of font
    "emphasis":     true, //Italics, bold, etc
    "textAlign":    true, //Text align (left, right, center, justify)
    "lists":        true, //(Un)ordered lists, e.g. Bullets, Numbers
    "blockquote":   true, //Button to insert quote
    "link":         true, //Button to insert a link
    "table":        true, //Button to insert a table
    "image":        true, //Button to insert an image
    "video":        true, //Button to insert video
    "html":         true, //Button which allows you to edit the generated HTML
  });

  opts = {
    "font-styles":  true,
    "color":        true,
    "emphasis":     true,
    "textAlign":    true, 
    "lists":        true, 
    "blockquote":   true,
    "link":         true,
    "table":        true,
    "image":        true,
    "video":        true,
    "html":         true,
    'format-code': false,
    events: { 
        focus : onfocus,
        blur: onblur      
      }
  };

  window.updateOnlineCount = function() {
    $('#widget_counter_member').html($('.widget_member').length);
  }
  
  window.resetWhosEditing = function() {
    $('#whos_editing').text('');
  }

  $update_editor = $('#update_note_content');
  $update_editor.wysihtml5(opts);

  var interval;
  function onfocus() {

    $.post( "/notes/whoisEditing", { channel_name: $.cookie('channel') })
      .done(function( data ) {});

    interval = setInterval(function() { 
      updateNote();
    }, 30000);
  }
  
  function onblur() {

    updateNote();
    clearInterval(interval);
    resetWhosEditing();
    $.post( "/notes/resetWhoisEditing", { channel_name: $.cookie('channel') })
      .done(function( data ) {});
  }

  $('#cancel_notes').hide();

  $('#add_notes').click(function() {
    $(this).hide();
    $('#cancel_notes').show();
    $('#new_notes_section').show();
  })

  $('#cancel_notes').click(function() {
    $(this).hide();
    $('#add_notes').show();
    $('#new_notes_section').hide();
  })


  $('.login-form').submit(function(e) {
    e.preventDefault();
    form = $(this);
    var data = form.serializeArray();
    ajaxCall('/notes/session', data, function(msg) {
      if (msg.success) {
        window.location= ("notes/listing");
      } else {}
    });
  });


  function ajaxCall(ajax_url, ajax_data, successCallback) {
    $.ajax({
      type : "POST",
      url : ajax_url,
      dataType : "json",
      data: ajax_data,
      time : 10,
      success : function(msg) {
        if( msg.success ) {
          successCallback(msg);
        } else {
          alert(msg.errormsg);
        }
      },
      error: function(msg) {
      }
    });
  }

  /*
  * code to save and update notes to db
  */

  var timeoutId;
  $('form.notes-update-form input, textarea').on('input propertychange change', function() {    
    clearTimeout(timeoutId);
    timeoutId = setTimeout(function() {
      updateNote();
    }, 1000);
  });

  function saveToDB() {
    form = $('.notes-form');
    var notes_content = $('#note_content').val();
    var data = form.serializeArray();
    data.push({name: 'note_content', value: notes_content});
    $.ajax({
      url: "/notes/createNotes",
      type: "POST",
      data: data,
      beforeSend: function(xhr) {

      },
      success: function(data) {
        notification('note saved');
        form.each(function(){
          this.reset();
        });
        console.log(data);
      }
    });
  }

  function updateNote() {
    var url = window.location.pathname;
    var note_id = url.substring(url.lastIndexOf('/') + 1);
    form = $('.notes-update-form');
    var data = form.serializeArray();
    data.push({name: 'note_id', value: note_id});
    $.ajax({
      url: "/notes/updateNote",
      type: "POST",
      data: data,
      beforeSend: function(xhr) {
      },
      success: function(data) {
        notification('note auto saved');
      }
    });
  }

  function notification(msg) {
    toastr.success(msg);
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
  }

  $('.notes-form').submit(function(e) {
    saveToDB();
    e.preventDefault();
  });

  $('.notes-update-form').submit(function(e) {
    updateNote();
    e.preventDefault();
  });

  /*
  * end here
  */

})(jQuery);