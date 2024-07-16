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
 * This file keeps track of upgrades to the listallcourses block
 *
 * @since 3.8
 * @package block_listallcourses
 * @copyright 2019 Jake Dallimore <jrhdallimore@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once("{$CFG->libdir}/db/upgradelib.php");

/**
 * Upgrade code for the listallcourses block.
 *
 * @param int $oldversion
 */
function xmldb_block_listallcourses_upgrade($oldversion) {
    global $DB, $CFG, $OUTPUT;

    $dbman = $DB->get_manager();

    // Automatically generated Moodle v3.8.0 release upgrade line.
    // Put any upgrade step following this.

    if ($oldversion < 2024070305) {
        $table = new xmldb_table("block_listallcourses");
        $table->add_field("id", XMLDB_TYPE_INTEGER,"11", null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field("userid", XMLDB_TYPE_INTEGER, "11", null, XMLDB_NOTNULL, null, null);
        $table->add_field("timeaccessed", XMLDB_TYPE_CHAR, "100", null, XMLDB_NOTNULL, null, null);
        $table->add_key("primary", XMLDB_KEY_PRIMARY, array("id"));

        if(!$dbman->table_exists($table) ) {
            $dbman->create_table($table);
        }

        
        upgrade_block_savepoint(true, 2024070305, 'listallcourses', false);
    }

    return true;
}
