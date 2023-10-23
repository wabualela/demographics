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

namespace local_demographics\form;

use moodleform;
/**
 * Class demographics_form
 *
 * @package    local_demographics
 * @copyright  2023 Wail Abualela
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

 class demographics_form extends moodleform {

    function definition() {
        global $USER, $CFG;
    
        $mform = $this->_form;

        /* Full name */
        $mform->addElement('text', 'fullname', get_string('fullname','local_demographics'), 'maxlength="100" size="12" autocapitalize="none"');
        $mform->setType('fullname', PARAM_RAW);
        $mform->addRule('fullname', get_string('missingfullname','local_demographics'), 'required', null, 'client');
        
        /* Gender */
        $genders = ['choose' => 'Choose...','Male'=> 'Male','Female'=> 'Female'];
        $mform->addElement('select', 'gender', get_string('gender','local_demographics'), $genders);
        $mform->setDefault('gender', 'Choose...');
        $mform->addRule('gender', get_string('missinggender','local_demographics'), 'required', null, 'client');

        $this->add_action_buttons(false, get_string('save','local_demographics'));
    }

    public function validation($data, $files) {
        $errors = [];
        
        if(isset($data['gender']) && $data['gender'] == 'choose') {    
            $errors['gender'] = get_string('pleasechooseagender','local_demographics');
        }

        return $errors;
    }
}
