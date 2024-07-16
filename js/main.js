$("#status").on("change", function () {
  var selected_status = this.value;

  $.ajax({
    url: "/moodle/blocks/listallcourses/ajax.php",
    data: { selected_status: selected_status },
    type: "POST",
    success: function (output) {
      console.log(selected_status);
      $(".mytable").html(output);

    },

  });

  if(window.localStorage){
    window.localStorage.setItem("#status-val", '-1');
}
});

if(window.localStorage){
    var item = window.localStorage.getItem("#status-val");
    if(item) $("#status").val(item);
}
