jQuery.noConflict();
(function ($) {

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
    post_data.added_datetime = data[5]
    toastr.success('email sent');
    toastr.options = {
      "closeButton": false,
      "debug": false,
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
    $.post("/welcome/queue", post_data)
      .done(function (data) {});
  });

  $("#add_user").on("click", function () {
    var $tableBody = $('#user_list').find("tbody"),
      $trLast = $tableBody.find("tr:last"),
      $trNew = $trLast.clone();
    $trLast.after($trNew);
  });


})(jQuery);