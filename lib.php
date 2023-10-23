<?php
use core\output\notification;

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

// function local_demographics_after_require_login() {
//     global $CFG;
//     if (!is_siteadmin() || $_SERVER['REQUEST_URI'] != "/local/demographics/index.php") {
//         redirect("{$CFG->wwwroot}/local/demographics/index.php");
//     }
// }

function local_demographics_after_config()
{
    global $USER, $CFG;
    if (isloggedin() && !isguestuser()) {
        if (!is_siteadmin()) {
            if ($_SERVER['REQUEST_URI'] !== "/local/demographics/index.php") {
                // die(var_dump($_SERVER['REQUEST_URI'] !== "/local/demographics/index.php"));
                redirect(
                    "{$CFG->wwwroot}/local/demographics/index.php"
                    ,
                    'Please fill the requited fields',
                    10,
                    notification::NOTIFY_INFO
                );
            }
        }
    }
}

