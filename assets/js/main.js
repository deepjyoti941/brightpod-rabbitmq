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

   	$.post("/cli/clientMailSend", post_data)
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
  		$.post( "/cli/client", {project_list:project_list_arr, user_email:user_email})
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



  /**
   * code for timer feature goes here
   */

   $('.timer_button').click(function(e) {
    e.preventDefault(); //cancel native click event
    $("#timer_modal").modal('show'); //insert retrieved data into modal, and then show it
    $("#save-task").remove();
    if ($('#project_list > option').length == 1) {
    	$.ajax({
    		type: "POST",
    		url: "/timer/projects",
    		success: function (data) {
    			$.each(JSON.parse(data),function(i,obj) {
    				console.log(obj);
    				var project_list = "<option value="+obj.project_id+">"+obj.name+"</option>";
    				$(project_list).appendTo('#project_list'); 
    			});
    		},
    		error: function() {
    			alert('Ajax did not succeed');
    		}
    	});
    };
  });

  function doc_keyUp(e) {
    //shift + z key combination
    if (e.shiftKey && e.keyCode == 90) {
    	$('.timer_button').click();
    }
  }

  document.addEventListener('keyup', doc_keyUp, false);

  $('#project_list').on('change', function (e) {
    $(".loader").show();
  	$('#task_list').empty()
  	var project_id = this.value;
  	$.ajax({
  		type: "POST",
  		data: {project_id: project_id},
  		url: "/timer/tasklist",
  		success: function (data) {
        $(".loader").hide();
  			$.each(JSON.parse(data),function(i,obj) {
  				console.log(obj);
          var task_list = "<option value="+obj.list_id+">"+obj.list_name+"</option>";
          $(task_list).appendTo('#task_list');

  			});
  		},
  		error: function() {
  			alert('Ajax did not succeed');
  		}
  	});
  });

  $(".mannual-time").on('click', '.dropdown-menu', function (e) {
    e.stopPropagation();
  });


	var jTask = {
		showArchived: false,
		showCompleted: false,
		intervals: [],
		timer: [],
		bind: function () {
      $("#timer-popup").on("click", function (e) {
        e.preventDefault();
        window.open("http://localhost:8000/timer/timerPopup","popupWindow", "width=1200, height=400, scrollbars=yes");

      });

			$(".tracking-create").on("click", function (e) {
				e.preventDefault();
				$(".tracking-form").hide();
				$("#tracking-form-create").show();
			});
			$(".tracking-form").on("click",".tracking-item .tracking-update", function (e) {
				e.preventDefault();
				$(".tracking-form").hide();
				var namespace = $(this).attr("rel");
				$("#tracking-button-update").attr("rel", namespace);
				var est = $.DOMCached.get('estimate', namespace);
				if (est !== null) {
					$("#tracking-form-update input[name='tracking-task-name']").val(namespace);
					$("#tracking-form-update input[name='tracking-task-estimate']").val(est);
					$("#tracking-form-update input[name='tracking-task-completed']").attr("checked", $.DOMCached.get("completed", namespace));
					$("#tracking-form-update input[name='tracking-task-archived']").attr("checked", $.DOMCached.get("archived", namespace));								
					$("#tracking-form-update span#created").text($.DOMCached.get('created', namespace));
				}
				$("#tracking-form-update").show();
			});
			$(".tracking-form").on("click",".tracking-item .tracking-remove", function (e) {
				e.preventDefault();
				$(".tracking-form").hide();
				$("#tracking-button-remove").attr("rel", $(this).attr("rel"));
				$("#tracking-remove-confirm").html("Are you sure you want to delete <strong>" + $(this).attr("rel") + "</strong>?");
				$("#tracking-form-remove").show();
			});

			$(".tracking-remove-all").on("click", function (e) {
				e.preventDefault();
        var confirmation = confirm("Are you sure you want to discard!");
        if (confirmation == true) {
          $(this).hide();
          $.DOMCached.flush_all();
          $("#tracking-form-remove-all").hide();
          $(".tracking-remove-all ").hide();
          $("#tracking-task-name").val("");
          $("#project_list").val('0');
          $('#task_list option').val('0');
          $('#task_list option').text('select a tasklist');
          $.DOMCached.flush_all();
          var timer_dom = '<button class="btn btn-success start-timer" title="Timer play/pause" id="tracking-button-create">START</button>';
          $('#timer-container').empty();
          $('#timer-container').append(timer_dom);
          jTask.index();
        } else {}
			});
			$("#tracking-show-archived").bind("click change", function () {
				jTask.showArchived = $(this).is(":checked");
				jTask.index();
			});
			$("#tracking-show-completed").bind("click change", function () {
				jTask.showCompleted = $(this).is(":checked");
				jTask.index();
			});
			$(".tracking-cancel").on("click", function (e) {
				e.preventDefault();
				$("#" + $(this).attr("rel")).hide().find("input:text").val("");
        $("#tracking-form-create").show();
				$("#tracking-form-list").show();

			});

      $('.tracking-form').on('click','#timer-container .tracking-power', function (e) {
        e.preventDefault();
        jTask.toggleTimer($(this), $(this).attr('rel'));
      });

			$('.tracking-form').on('click','.tracking-item .tracking-power', function (e) {
				e.preventDefault();
				jTask.toggleTimer($(this), $(this).attr('rel'));
			});

      $('.tracking-form').on('click','#timer-container #save-task', function (e) {
        e.preventDefault();
        $(".loader").show();
        var current_storage = $.DOMCached.getStorage();
        console.log(current_storage);

        if ($("#tracking-task-name").val() == '' || $("#project_list").val()==0 || $("#task_list").val()==0) {

          alert('you must select task name with project and task list');
          $(".loader").hide();

        } else {

          var data = {};
          for (namespace in current_storage) {
            data.task_name = $("#tracking-task-name").val();
            data.timer = jTask.hms($.DOMCached.get("timer", namespace));
            data.timer_duration = $.DOMCached.get("timer", namespace);
            data.project_id = $("#project_list").val();
            data.created_date = $.DOMCached.get("created", namespace);
            data.task_list_id = $("#task_list").val();
          }

          console.log(data);

          $.ajax({
            type: "POST",
            data: data,
            url: "/timer/saveTask",
            success: function (data) {
              $(".loader").hide();
              $.DOMCached.flush_all();

            },
            error: function() {
              alert('some error occured');
            }
          });
        
        var project_name = $('#project_list option:selected').text();    
        var task_list_dom = '<li class="list-group-item"><div class="row"><div class="col-md-6"><span class="task-name-style">'+data.task_name+'</span><span rel="'+data.project_id+'"class="label label-default">'+project_name+'</span></div>';
            task_list_dom += '<div class="col-md-2"><span class="label label-success">'+data.timer+'</span>&nbsp<span class="label label-success">'+data.created_date+'</span></div>';
        $("#task-list").prepend(task_list_dom);
        $(".tracking-remove-all ").hide();
        $("#tracking-task-name").val("");
        $("#project_list").val('0');
        $('#task_list option').val('0');
        $('#task_list option').text('select a tasklist');
        var timer_dom = '<button class="btn btn-success start-timer" title="Timer play/pause" id="tracking-button-create">START</button>';
        $('#timer-container').empty();
        $('#timer-container').append(timer_dom);
        }

      });
  
      $("#task-list").on("click","#tracking-button-restart", function (e) {
        e.preventDefault();
        $this = $(this);

        if ($("#tracking-timer")) {
          $.DOMCached.flush_all();
          var parent = $this.parent().parent().siblings();
          var task_name = parent.find('.task-name-style').text();
          var project_id = parent.find($('span[rel]')).attr("rel");
          $("#tracking-task-name").val(task_name);
          $("#project_list").val(project_id);
          $(".loader").show();
          $.ajax({
            type: "POST",
            data: {project_id: project_id},
            url: "/timer/tasklist",
            success: function (data) {
              $(".loader").hide();
              $.each(JSON.parse(data),function(i,obj) {
                console.log(obj);
                  var task_list = "<option value="+obj.list_id+">"+obj.list_name+"</option>";
                  $('#task_list').empty();
                  $(task_list).appendTo('#task_list');

              });
            },
            error: function() {
              alert('Ajax did not succeed');
            }
          });
          $('#task_list option').val('0');
          $('#task_list option').text('select a tasklist');
          var timer_dom = '<button class="btn btn-success start-timer" title="Timer play/pause" id="tracking-button-create">START</button>';
          $('#timer-container').empty();
          $('#timer-container').append(timer_dom);
        }
      })

			$("#tracking-button-remove").on("click", function () {
				$.DOMCached.deleteNamespace($(this).attr("rel"));
				$(this).attr("rel", "");
				$("#tracking-form-remove").hide();
				jTask.index();		
			});

      $('.tracking-form').on('click','#timer-container #tracking-button-create', function (e) {
        e.preventDefault();

          var task_list_details = {};
          task_list_details.id = $('#task_list').val();
          task_list_details.name = $('#task_list option:selected').text();
          var namespace = $("#tracking-form-create :input[name='tracking-task-name']").val();   
          if ($.DOMCached.get('timer', namespace) === null) {
            $.DOMCached.set('timer', 0, false, namespace);
            $.DOMCached.set('project_id', $('#project_list').val(), false, namespace);
            $.DOMCached.set('task_list_details', task_list_details, false, namespace);


            var started = [];
            var d = new Date();
            var created = [d.getFullYear(), d.getMonth() + 1, d.getDate()]; 
            $.DOMCached.set('created', created.join("-"), false, namespace);
            $("#tracking-create-status").hide().text("");
            started[namespace] = $.DOMCached.get("started", namespace);
            jTask.timer[namespace] = $.DOMCached.get("timer", namespace);
            console.log(started[namespace]);
            console.log(jTask.hms(jTask.timer[namespace]));
            var timer_dom = '<span class="tracking-timer">' + jTask.hms(jTask.timer[namespace]) + '</span><button class="btn btn-default tracking-power tracking-power-on' + (started[namespace] ? ' tracking-power-on' : '') + '" title="Timer on/off" rel="' + namespace + '"></button>'
            timer_dom += '<button class="btn btn-success pull-right" title="Save Task" id="save-task">SAVE</button>&nbsp'
            $('.tracking-remove-all').show();
            $('#timer-container').empty();
            $('#timer-container').append(timer_dom);
            jTask.toggleTimer($(this), namespace);

          } else {
            $("#tracking-create-status").text("Task with the same name already exists.").show();
          }
			});
      
      $(".save-tasks").on("click", function() {
        var data = $.parseJSON(localStorage.dom_storage);
        console.log(localStorage.dom_storage);
      });
		},
		index: function () {
			var p = '',
				conditions = [],
				created,
				archived,
				completed,
				namespace,
				started = [],
				storage = $.DOMCached.getStorage();
			conditions.push('true');
			if (!this.showArchived) {
				conditions.push('!archived');
			}
			if (!this.showCompleted) {
				conditions.push('!completed');
			}
			for (namespace in storage) {
        started[namespace] = $.DOMCached.get("started", namespace);
        if (started[namespace]) {
          this.timerScheduler(namespace);
        }
			}

			$("#tracking-form-list").empty().append(p).show();
      $("#tracking-form-create").show();
		},
    runningTask: function () {
      var started = [];
      var current_storage = $.DOMCached.getStorage();
      for (namespace in current_storage) {

        jTask.timer[namespace] = $.DOMCached.get("timer", namespace);
        started[namespace] = $.DOMCached.get("started", namespace);
        var project_id = $.DOMCached.get("project_id", namespace);
        var task_list_details = $.DOMCached.get("task_list_details", namespace);
        $('#task_list option').val(task_list_details.id);
        $('#task_list option').text(task_list_details.name);
        $('#project_list').val(project_id);
        var current_timer_dom = '<span class="tracking-timer">' + this.hms(jTask.timer[namespace]) + '</span><button class="btn btn-default tracking-power' + (started[namespace] ? ' tracking-power-on' : '') + '" title="Timer on/off" rel="' + namespace + '"></button>';
        current_timer_dom += '<button class="btn btn-success pull-right" title="Save Task" id="save-task">SAVE</button>&nbsp'
        console.log(namespace);
        $('#tracking-task-name').val(namespace);
        $('#timer-container').empty();
        $('#timer-container').append(current_timer_dom);
        var save_button = '<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>'
        var started = [];
        started[namespace] = $.DOMCached.get("started", namespace);
        if (started[namespace] || !started[namespace]) {
          $('.tracking-remove-all').show();
        }
      }
    },
		init: function () {
			this.bind();
			this.index();
      this.runningTask();
		},

    currentTimerScheduler: function (namespace) {
      clearInterval(this.intervals[namespace]);
      this.intervals[namespace] = setInterval(function () {
        if ($.DOMCached.get("started", namespace)) {
          jTask.timer[namespace]++;
          $.DOMCached.set("timer", jTask.timer[namespace], false, namespace);
          $("#timer-container").children().text(jTask.hms(jTask.timer[namespace]));
        }
      }, 1000);
    },
		timerScheduler: function (namespace) {
			clearInterval(this.intervals[namespace]);
			this.intervals[namespace] = setInterval(function () {
				if ($.DOMCached.get("started", namespace)) {
					jTask.timer[namespace]++;
					$.DOMCached.set("timer", jTask.timer[namespace], false, namespace);
					$(".tracking-power[rel='" + namespace + "']").siblings(".tracking-timer").eq(0).text(jTask.hms(jTask.timer[namespace]));
				}
			}, 1000);
		},
		toggleTimer: function (jQ, namespace) {
			if (!$.DOMCached.get("started", namespace)) {
				$.DOMCached.set("started", true, false, namespace);
				this.timer[namespace] = $.DOMCached.get("timer", namespace);
				this.timerScheduler(namespace);
				jQ.addClass("tracking-power-on");
			} else {
				$.DOMCached.set("started", false, false, namespace);
				jQ.removeClass("tracking-power-on");
			}
		},
		hms: function (secs) {
			secs = secs % 86400;
			var time = [0, 0, secs], i;
			for (i = 2; i > 0; i--) {
				time[i - 1] = Math.floor(time[i] / 60);
				time[i] = time[i] % 60;
				if (time[i] < 10) {
					time[i] = '0' + time[i];
				}
			}
			return time.join(':');
		}
	};

	jTask.init();

 /**
   * end here
   */

 })(jQuery);
