// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * filter course types
 *
 * @module     block_listallcourses/main
 * @copyright  2024 LMSCloud.io
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require(['jquery'], function($) {

$("#status").on("change", function() {
    var selectedstatus = this.value;

    $.ajax({
      url: "/moodle/blocks/listallcourses/ajax.php",
      data: {selectedstatus: selectedstatus},
      type: "POST",
      success: function(output) {
        $(".mytable").html(output);

      },

    });

    if (window.localStorage) {
      window.localStorage.setItem("#status-val", '1');
  }
  });

  if (window.localStorage) {
      var item = window.localStorage.getItem("#status-val");
      if (item) {
          $("#status").val(item);
      }
  }
});
