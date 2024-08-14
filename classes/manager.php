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

namespace block_listallcourses;

/**
 * Class manager
 *
 * @package    block_listallcourses
 * @copyright  2024 LMSCloud.io
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class manager {

    /**
     * Summary of get_activity_list in a course
     * @param int $cid
     * @return array
     */
    public function get_activities_list($cid) {

        global $DB;

        $sql = "SELECT m.name, cm.id AS intanceid, COUNT(DISTINCT(cm.instance)) AS No_of_Instances,
                COALESCE(COUNT(cc.completionstate),0) AS c_completions
                FROM {modules} m
                JOIN {course_modules} cm ON m.id = cm.module AND cm.course = $cid AND cm.module <> 10
                LEFT JOIN {course_modules_completion} cc ON cm.id = cc.coursemoduleid AND cc.completionstate = 1
                GROUP BY cm.module;";
        return array_values($DB->get_records_sql($sql));

    }

    /**
     * Summary of get_activity_desc
     * @param int $cid
     * @param int $modid
     * @param int $uid
     * @return array
     */
    public function get_activity_desc($cid, $modid, $uid) {

        global $DB;

        $sql = "SELECT m.id, m.name, COALESCE(cc.completionstate,0) AS c_completion_State,
                TRUNCATE(COALESCE(g.rawgrade,0), 2) AS rawgrade, TRUNCATE(COALESCE(g.rawgrademax,0), 2) AS rawgrademax,
                TRUNCATE(COALESCE(g.finalgrade,0), 2) AS finalgrade
                FROM {modules} m
                JOIN {course_modules} cm ON m.id = cm.module AND cm.course = $cid AND cm.id = $modid
                LEFT JOIN {course_modules_completion} cc ON cm.id = cc.coursemoduleid AND cc.completionstate = 1
                AND cc.userid = $uid
                LEFT JOIN {grade_items} gi ON gi.iteminstance = cm.instance AND gi.courseid = $cid
                LEFT JOIN {grade_grades} g ON gi.id = g.itemid AND g.userid = $uid;";
        return array_values($DB->get_records_sql($sql));

    }

    /**
     * Summary of get_allcourse_list
     * @return array
     */
    public function get_allcourse_list() {

        global $DB;

        $sql = "SELECT c.id, c.fullname, COUNT(ue.id) AS enroled, COALESCE(COUNT(cc.userid),0) AS c_completed
                FROM {course} c
                JOIN {enrol} en ON en.courseid = c.id AND c.visible <> 0
                JOIN {user_enrolments} ue ON ue.enrolid = en.id
                JOIN {user} u ON u.id = ue.userid
                LEFT JOIN {course_completions}  cc ON cc.course = c.id AND cc.userid = u.id AND cc.timecompleted is not null
                GROUP BY c.id
                ORDER BY c.id;";
        return array_values($DB->get_records_sql($sql));

    }
}
