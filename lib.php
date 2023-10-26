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
 * Callback implementations for Africa demographic
 *
 * @package    local_demographics
 * @copyright  2023 Wail Abualela
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function local_demographics_after_require_login()
{
    global $DB, $USER;
    if (!is_siteadmin()) {
        $fields = $DB->get_records('user_info_field');
        foreach ($fields as $field) {
            $record_exists = $DB->record_exists('user_info_data', ['userid' => $USER->id, 'fieldid' => $field->id]);
            if ($field->locked == true && $record_exists == false) {
                $field->locked = false;
                $DB->update_record('user_info_field', $field);
            }
            if ($field->locked == false && $record_exists == true) { {
                    $field->locked = true;
                    $DB->update_record('user_info_field', $field);
                }
            }
        }
    }
}

