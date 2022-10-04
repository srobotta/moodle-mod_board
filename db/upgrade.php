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
 * Upgrade functions.
 * @package     mod_board
 * @author      Mike Churchward <mike@brickfieldlabs.ie>
 * @copyright   2021 Brickfield Education Labs <https://www.brickfield.ie/>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * The main upgrade function.
 * @param int $oldversion
 * @return bool
 */
function xmldb_board_upgrade(int $oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2021052400) {
        // Board savepoint reached.
        upgrade_mod_savepoint(true, 2021052400, 'board');
    }

    if ($oldversion < 2021052405) {
        // Define field userscanedit to be added to board.
        $table = new xmldb_table('board');
        $field = new xmldb_field('userscanedit', XMLDB_TYPE_INTEGER, '1', null, null, null, '0', 'postby');

        // Conditionally launch add field userscanedit.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Board savepoint reached.
        upgrade_mod_savepoint(true, 2021052405, 'board');
    }

    if ($oldversion < 2021052406) {

        // Define field sortorder to be added to board_notes.
        $table = new xmldb_table('board_notes');
        $field = new xmldb_field('sortorder', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'timecreated');

        // Conditionally launch add field sortorder.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Board savepoint reached.
        upgrade_mod_savepoint(true, 2021052406, 'board');
    }

    if ($oldversion < 2021052407) {
        mod_board_remove_unattached_ratings();
        // Board savepoint reached.
        upgrade_mod_savepoint(true, 2021052407, 'board');
    }

    if ($oldversion < 2021052408) {

        // Define field enableblanktarget to be added to board.
        $table = new xmldb_table('board');
        $field = new xmldb_field('enableblanktarget', XMLDB_TYPE_INTEGER, '1', null, null, null, '0', 'singleusermode');

        // Conditionally launch add field enableblanktarget.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Board savepoint reached.
        upgrade_mod_savepoint(true, 2021052408, 'board');
    }

    if ($oldversion < 2021052409) {

        // Define field completionnotes to be added to board.
        $table = new xmldb_table('board');
        $field = new xmldb_field('completionnotes', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'userscanedit');

        // Conditionally launch add field completionnotes.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Board savepoint reached.
        upgrade_mod_savepoint(true, 2021052409, 'board');
    }

    if ($oldversion < 2022040101) {

        // Define field singleusermode to be added to board.
        $table = new xmldb_table('board');
        $field = new xmldb_field('singleusermode', XMLDB_TYPE_INTEGER, '4', null, null, null, '0', 'userscanedit');

        // Conditionally launch add field singleusermode.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field ownerid to be added to board_history.
        $table = new xmldb_table('board_history');
        $field = new xmldb_field('ownerid', XMLDB_TYPE_INTEGER, '10', null, null, null, null, 'groupid');

        // Conditionally launch add field ownerid.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field owner to be added to board_notes.
        $table = new xmldb_table('board_notes');
        $field = new xmldb_field('ownerid', XMLDB_TYPE_INTEGER, '10', null, null, null, null, 'columnid');

        // Conditionally launch add field owner.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        upgrade_mod_savepoint(true, 2022040101, 'board');
    }

    if ($oldversion < 2022040102) {

        // Define field locked to be added to board_columns.
        $table = new xmldb_table('board_columns');
        $field = new xmldb_field('locked', XMLDB_TYPE_INTEGER, '4', null, null, null, null, 'name');

        // Conditionally launch add field locked.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $field = new xmldb_field('sortorder', XMLDB_TYPE_INTEGER, '10', null, null, null, null, 'name');

        // Conditionally launch add field sortorder.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Board savepoint reached.
        upgrade_mod_savepoint(true, 2022040102, 'board');
    }

    return true;
}
