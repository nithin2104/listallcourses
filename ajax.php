<?php

require_once (__DIR__ . "/../../config.php");
require_login();
global $DB, $USER;

$selected_status = optional_param("selected_status", 0, PARAM_INT);

if ($selected_status == -1) {
    $sql = "select id, fullname, shortname from {course} where id <> ?";
    $result = $DB->get_records_sql($sql, ['id' => 1]);

} else {
    $sql = "select id, fullname, shortname from {course} where id <> ? and VISIBLE = ?";
    $result = $DB->get_records_sql($sql, ['id' => 1, 'VISIBLE' => $selected_status]);
}

$table = new html_table();
$table->head = [
    get_string('courseid', 'block_listallcourses'),
    get_string('coursename', 'block_listallcourses'),
    get_string('coursesname', 'block_listallcourses')
];
$table->attributes['class'] = 'generaltable myclass';
foreach ($result as $course) {
    $id = $course->id;
    $courseName = $course->fullname;
    $shortname = $course->shortname;
    $table->data[] = new html_table_row([$id, $courseName, $shortname]);
}
echo html_writer::table($table);
