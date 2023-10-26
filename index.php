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
use core\output\notification;
use local_demographics\form\demographics_form;

/**
 * TODO describe file index
 *
 * @package    local_demographics
 * @copyright  2023 Wail Abualela
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

require_login();

$url = new moodle_url('/local/demographics/index.php', []);
$PAGE->set_url($url);
$PAGE->set_context(context_system::instance());

$mform = new demographics_form();
$mform->set_data([
    'fullname' => $USER->profile['fullname'],
    'gender' => $USER->profile['gender'],
]);

if ($mform->is_cancelled()) {
} else if ($data = $mform->get_data()) {
    $fields = $DB->get_record('user_info_field');
    foreach ($fields as $fieldname) {
        $fieldid = $DB->get_field('user_info_field', 'id', ['shortname' => $fieldname], IGNORE_MISSING);
        $fielddata = $data->$fieldname;
        $DB->insert_record('user_info_data', [
            'userid' => $USER->id,
            'fieldid' => $fieldid,
            'data' => $fielddata,
        ]);
    }
    redirect("{$CFG->wwwroot}", '👍', null, notification::NOTIFY_SUCCESS);
}

$PAGE->set_heading($SITE->fullname);
echo $OUTPUT->header();

$mform->display();

echo $OUTPUT->footer();
