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
 * Block listallcourses is defined here.
 *
 * @package     block_listallcourses
 * @copyright   2024 Nithin kumar <nithin54@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_listallcourses extends block_base {

    /**
     * Initializes class member variables.
     */
    public function init() {
        // Needed by Moodle to differentiate between blocks.
        $this->title = get_string('pluginname', 'block_listallcourses');
    }

    /**
     * Returns the block contents.
     *
     * @return stdClass The block contents.
     */
    public function get_content() {
        global $DB,$USER,$CFG,$OUTPUT,$PAGE;

        $PAGE->requires->js('/blocks/listallcourses/js/jquery-3.7.1.min.js');
        $PAGE->requires->js('/blocks/listallcourses/js/main.js');
        $PAGE->requires->css('/blocks/listallcourses/style/styles.css');

        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        // $this->content->text = $text;
        $this->content = new stdClass();

        if (!empty($this->config->text)) {
            $this->content->text = $this->config->text;
        } else {

            $sql = 'SELECT * FROM {course} WHERE id <> ?';
            $result = $DB->get_records_sql($sql, [1]);
            // print_r($result);
            // $slno = 0;
            // $table = new html_table();
            // $table->head = array(get_string('slno', 'block_listallcourses'), get_string('courseid', 'block_listallcourses'), get_string('coursename', 'block_listallcourses'));
            // $table->attributes['class'] = 'generaltable myclass';
            // foreach ($result as $course) {
            //     $slno += 1;
            //     $courseId= $course->id;
            //     $courseName = $course->fullname;
            //     $table->data[] = new html_table_row(array($slno, $courseId, $courseName));
            // }
            // $filter = '
            // <div class="filter">
            // <span>Course Type </span>
            // <select name="status" id="status">
            // <option value="-1">All</option>
            // <option value="1">Active</option>
            // <option value="0">Deactive</option>
            // </select>
            // </div>
            // ';
            // $text = $filter;
            // $text .= '<div class="mytable">';
            // $text .= html_writer::table($table);
            // $text .= '</div>';
            // $result = $_POST['result'];
            // var_dump($result);
            // die;
            $records = (object)[
                'records'=> array_values($result),
            ];
            $this->content->text = $OUTPUT->render_from_template('block_listallcourses/list', $records);
        }

        return $this->content;
    }

    /**
     * Defines configuration data.
     *
     * The function is called immediately after init().
     */
    public function specialization() {

        // Load user defined title and make sure it's never empty.
        if (empty($this->config->title)) {
            $this->title = get_string('pluginname', 'block_listallcourses');
        } else {
            $this->title = $this->config->title;
        }
    }

    /**
     * Enables global configuration of the block in settings.php.
     *
     * @return bool True if the global configuration is enabled.
     */
    public function has_config() {
        return true;
    }

    /**
     * Sets the applicable formats for the block.
     *
     * @return string[] Array of pages and permissions.
     */
    public function applicable_formats() {
        return [ 'all' => true ];
    }

    public function _self_test() {
        return true;
    }
}