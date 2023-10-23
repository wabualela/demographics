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

if ($mform->is_cancelled()) {
} else if ($data = $mform->get_data()) {
   
    if($DB->record_exists('user_info_field', ['shortname' => 'fullname'])) {
        $fieldid = $DB->get_field('user_info_field', 'id', ['shortname' => 'fullname'], IGNORE_MISSING);

       if($fullnamedata = $DB->get_record('user_info_data',[ 'userid' => $USER->id, 'fieldid' => $fieldid], '*', IGNORE_MISSING)) {
             $fullnamedata->data = $data->fullname;
        $DB->update_record('user_info_data', $fullnamedata);
        redirect("{$CFG->wwwroot}", '👍', null, notification::NOTIFY_SUCCESS);
       } else {
        $DB->insert_record('user_info_data', [
            'userid' => $USER->id,
            'fieldid' => $fieldid,
            'data' => $data->fullname,
        ]);
        redirect("{$CFG->wwwroot}", '👍', null, notification::NOTIFY_SUCCESS);
       }
    } else {
        $DB->insert_record('user_info_field', [
            "shortname"=> "fullname",
            "name"=> "Full Name (the name will be use in your Certifications)",
            "datatype"=> "text",
            "description"=> null,
            "descriptionformat"=> "1",
            "categoryid"=> "1",
            "sortorder"=> "2",
            "required"=> "0",
            "locked"=> "1",
            "visible"=> "3",
            "forceunique"=> "0",
            "signup"=> "1",
            "defaultdata"=> null,
            "defaultdataformat"=> "0",
        ]);
    }
}

$PAGE->set_heading($SITE->fullname);
echo $OUTPUT->header();

$mform->display();

echo $OUTPUT->footer();
