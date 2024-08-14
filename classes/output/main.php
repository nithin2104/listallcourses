<?php
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
 * Class listallcourses
 *
 * @package    block_listallcourses
 * @copyright  2024 LMSCloud.io
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_listallcourses\output;


use block_listallcourses\manager as manager;
use renderable;
use templatable;
use renderer_base;

/**
 * Summary of listallcourses
 */
class main implements renderable, templatable {

    /**
     * Summary of context
     * @var \context
     */
    protected $context;

    /**
     * Summary of __construct
     * @param mixed $context
     */
    public function __construct($context) {
        $this->context = $context;
    }

    /**
     * Summary of export_for_template
     * @param \renderer_base $output
     * @return \stdClass|array
     */
    public function export_for_template(renderer_base $output) {
        global $USER, $OUTPUT, $DB, $COURSE;

        $data = new \stdClass();
        $managerobj = new manager();

        if ($this->context->contextlevel == 50) {

            $data->records = $managerobj->get_activities_list($COURSE->id);
            $data->course = true;

        } else if ($this->context->contextlevel == 70) {

            $modid = optional_param('id', 0, PARAM_INT);
            if ($modid == 0) {
                $modid = optional_param('update', 0, PARAM_INT);
            }
            $activitieslist = $managerobj->get_activity_desc($COURSE->id, $modid, $USER->id);
            $data->name = $activitieslist[0]->name;
            $data->completionstate = $activitieslist[0]->c_completion_state == 1 ? "Completed" : "Not Completed";
            $data->rawgrade = $activitieslist[0]->finalgrade;
            $data->rawgrademax = $activitieslist[0]->rawgrademax;
            $data->module = true;

        } else {

            $data->records = $managerobj->get_allcourse_list();
            $data->all = true;
        }
        return $data;

    }
}
