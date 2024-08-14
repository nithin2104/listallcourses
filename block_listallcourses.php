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
 * @copyright   2024 Nithin kumar <nithin54@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Summary of block_listallcourses
 */
class block_listallcourses extends block_base {

    /**
     * Initializes class member variables.
     * Setting Title of the page
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
        global $DB, $USER, $CFG, $OUTPUT, $COURSE;

        $this->page->requires->js_call_amd('block_listallcourses/main');
        $this->page->requires->css('/blocks/listallcourses/style/styles.css');

        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }
        $context = $this->page->context;

        $renderable = new \block_listallcourses\output\main($context);
        $renderer = $this->page->get_renderer('block_listallcourses');

        $this->content = new stdClass();
        $this->content->text = $renderer->render($renderable);
        $this->content->footer = '';

        return $this->content;
    }
    /**
     * Summary of specialization
     * Setting page title in different contexts
     * @return void
     */
    public function specialization() {

        // Load user defined title and make sure it's never empty.
        $titlecontext = $this->page->context;
        if ($titlecontext->contextlevel == 50) {
            $this->title = get_string('listofactivities', 'block_listallcourses');
        } else if ($titlecontext->contextlevel == 70) {
            $this->title = get_string('activitydesc', 'block_listallcourses');
        } else {
            $this->title = get_string('pluginname', 'block_listallcourses');
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

    /**
     * Summary of _self_test
     * @return bool
     */
    public function self_test() {
        return true;
    }
}
