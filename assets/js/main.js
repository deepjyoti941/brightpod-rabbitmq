(function ($) {

 /**
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


 /**
   * end here
   */


  /**
   * code for notes feature goes here
   */

  // initializing editors
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

  // function to update the online member count
  window.updateOnlineCount = function() {
    $('#widget_counter_member').html($('.widget_member').length);
  }

  $update_editor = $('#update_note_content');
  $update_editor.wysihtml5(opts);

  //trggering post request to pusher api when focus is inside editor (who is editing feature)
  var interval;
  function onfocus() {
    $.post( "/notes/whoisEditing", { channel_name: $.cookie('channel') })
      .done(function( data ) {});

    interval = setInterval(function() {
      updateNote();
    }, 30000);
  }

  //trggering post request to pusher api when focus is out of editor (stopped editing notes)
  function onblur() {
    updateNote();
    clearInterval(interval);
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

  //code to save and update notes to db
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

  $('#export_project').click(function(e) {
    e.preventDefault();
    $(this).attr("disabled", true);
    $('#project_progress').show();

    $.post( "/basecamp/export-projects", {}, function(data) {
      data = $.parseJSON(data);
        if (data.status == 'already_exported') {
        $('#project_progress').hide();
        $('#already_done').show();
        $('#already_done').append('<a href="'+data.export_path+'">'+data.export_path+'</a>');
      } else {
        $('#project_progress').hide();
        $('#project_done').show();
        $('#project_done').append('<a href="'+data.export_path+'">'+data.export_path+'</a>');

      }
    });
  })

  var project_list_arr = [];
  var people_list_arr = [];
  var calender_list_arr = [];

  $('.project_list tbody tr').click(function (event) {
      if (event.target.type !== 'checkbox') {
          $(':checkbox', this).trigger('click');
      }
  });

  $('.people_list tbody tr').click(function (event) {
      if (event.target.type !== 'checkbox') {
          $(':checkbox', this).trigger('click');
      }
  });

  $('.calender_list tbody tr').click(function (event) {
      if (event.target.type !== 'checkbox') {
          $(':checkbox', this).trigger('click');
      }
  });
  $(".project_list input[type='checkbox']").change(function (e) {
      var val
      if ($(this).is(":checked")) {
        $(this).closest('tr').addClass("highlight_row");
        val = $(this).closest('tr td').next().html();
        project_list_arr.push(val);
        console.log(val);
      } else {
        $(this).closest('tr').removeClass("highlight_row");
        val = $(this).closest('tr td').next().html();
        var index = project_list_arr.indexOf(val);
        if (index > -1) {
          project_list_arr.splice(index, 1);
        }
      }
  });

  $(".people_list input[type='checkbox']").change(function (e) {
      var val
      if ($(this).is(":checked")) {
        $(this).closest('tr').addClass("highlight_row");
        val = $(this).closest('tr td').next().html();
        people_list_arr.push(val);
        console.log(val);
      } else {
        $(this).closest('tr').removeClass("highlight_row");
        val = $(this).closest('tr td').next().html();
        var index = people_list_arr.indexOf(val);
        if (index > -1) {
          people_list_arr.splice(index, 1);
        }
      }
  });

  $(".calender_list input[type='checkbox']").change(function (e) {
      var val
      if ($(this).is(":checked")) {
        $(this).closest('tr').addClass("highlight_row");
        val = $(this).closest('tr td').next().html();
        calender_list_arr.push(val);
        console.log(val);
      } else {
        $(this).closest('tr').removeClass("highlight_row");
        val = $(this).closest('tr td').next().html();
        var index = calender_list_arr.indexOf(val);
        if (index > -1) {
          calender_list_arr.splice(index, 1);
        }
      }
  });

  $("#export_project_list").click(function() {
    var user_email = $('#user_email').val();
    if (typeof project_list_arr !== 'undefined' && project_list_arr.length > 0 && user_email != '') {
      var $this = $(this);
      $this.attr("disabled", true);
      $('#project_list_done').show();
      $.post( "/basecamp/export-selected-projects", {project_list:project_list_arr, user_email:user_email})
        .done(function( data ) {
          $this.removeAttr("disabled");
      });
    } else {
      bootbox.alert("You must select atleast one project and enter valid email to export", function() {
      });
    }
  })


  $("#export_people_list").click(function() {

    if (typeof people_list_arr !== 'undefined' && people_list_arr.length > 0) {
      var $this = $(this);
      $this.attr("disabled", true);
      $('#project_list_progress').show();
      $.post( "/basecamp/export-selected-people", {people_list:people_list_arr})
        .done(function( data ) {
          $('#people_list_progress').hide();
          $('#people_list_done').show();
          $this.removeAttr("disabled");
      });
    } else {
      bootbox.alert("You must select atleast one people to export", function() {
      });
    }
  })


  $("#export_calender_list").click(function() {

    if (typeof calender_list_arr !== 'undefined' && calender_list_arr.length > 0) {
      var $this = $(this);
      $this.attr("disabled", true);
      $('#calender_list_progress').show();
      $.post( "/basecamp/export-selected-calenders", {calender_list:calender_list_arr})
        .done(function( data ) {
          $('#calender_list_progress').hide();
          $('#calender_list_done').show();
          $this.removeAttr("disabled");
      });
    } else {
      bootbox.alert("You must select atleast one calender to export", function() {
      });
    }
  })

 /**
   * end here
  */

})(jQuery);
