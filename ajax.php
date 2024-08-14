<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Ajax file
 *
 * @package     block_listallcourses
 * @copyright   2024 Nithin kumar <nithin54@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use block_listallcourses\manager as manager;

require_once(__DIR__ . "/../../config.php");
require_once($CFG->dirroot . '/course/lib.php');

require_login();

global $DB, $USER;

$selectedstatus = optional_param("selectedstatus", 0, PARAM_INT);

if ($selectedstatus == 1) {
            $result = (new manager)->get_allcourse_list();

} else {
    $result2 = (new manager)->get_allcourse_list();
    $result = enrol_get_my_courses();

    foreach ($result2 as $rec2) {
        foreach ($result as $rec1) {
            if ($rec1->id == $rec2->id) {
                $rec1->enroled = $rec2->enroled;
                $rec1->c_completed = $rec2->id == $rec1->id ? $rec2->c_completed : 0;
            }
        }
    }

}

$table = "<div class='mytable'>";
$table .= "<table class='generaltable myclass'>
<thead>
<tr>
<th>" . get_string('courseid', 'block_listallcourses') . "</th>
<th>" . get_string('coursename', 'block_listallcourses') . "</th>
<th>" . get_string('enroled', 'block_listallcourses') . "</th>
<th>" . get_string('coursecompleted', 'block_listallcourses') . "</th>
</tr>
</thead>
<tbody>";
foreach ($result as $course) {

    $table .= "
    <tr>
      <td>" . $course->id . "</td>
      <td> <a href='$CFG->wwwroot/course/view.php?id=$course->id'>" . $course->fullname . "</a></td>
      <td>" . $course->enroled . "</td>
      <td>" . $course->c_completed . "</td>
    </tr>
    ";

}
$table .= "</tbody></table></div>";

echo $table;
