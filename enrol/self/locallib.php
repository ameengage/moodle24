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
 * Self enrol plugin implementation.
 *
 * @package    enrol_self
 * @copyright  2010 Petr Skoda  {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class enrol_self_enrol_form extends moodleform {
    protected $instance;
    protected $toomany = false;

    /**
     * Overriding this function to get unique form id for multiple self enrolments.
     *
     * @return string form identifier
     */
    protected function get_form_identifier() {
        $formid = $this->_customdata->id.'_'.get_class($this);
        return $formid;
    }

    public function definition() {
        global $DB;

        $mform = $this->_form;
        $instance = $this->_customdata;
        $this->instance = $instance;
        $plugin = enrol_get_plugin('self');

        $heading = $plugin->get_instance_name($instance);
        $mform->addElement('header', 'selfheader', $heading);

        if ($instance->customint3 > 0) {
            // Max enrol limit specified.
            $count = $DB->count_records('user_enrolments', array('enrolid'=>$instance->id));
            if ($count >= $instance->customint3) {
                // Bad luck, no more self enrolments here.
                $this->toomany = true;
                $mform->addElement('static', 'notice', '', get_string('maxenrolledreached', 'enrol_self'));
                return;
            }
        }

        if ($instance->password) {
            // Change the id of self enrolment key input as there can be multiple self enrolment methods.
            $mform->addElement('passwordunmask', 'enrolpassword', get_string('password', 'enrol_self'),
                    array('id' => 'enrolpassword_'.$instance->id));
            //Added Unique Passcode Field [Custom changes Date: 22/1/2013]
            $mform->addElement('passwordunmask', 'uniquepasscode', 'Unique Passcode',
                    array('id' => 'uniquepasscode_'.$instance->id));
            
        } else {
            $mform->addElement('static', 'nokey', '', get_string('nopassword', 'enrol_self'));
        }

        $this->add_action_buttons(false, get_string('enrolme', 'enrol_self'));

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->setDefault('id', $instance->courseid);

        $mform->addElement('hidden', 'instance');
        $mform->setType('instance', PARAM_INT);
        $mform->setDefault('instance', $instance->id);
    }

    public function validation($data, $files) {
        global $DB, $CFG,$USER;

        $errors = parent::validation($data, $files);
        
        $instance = $this->instance;

        if ($this->toomany) {
            $errors['notice'] = get_string('error');
            return $errors;
        }

        if ($instance->password) {
            
            
            if ($data['enrolpassword'] !== $instance->password) {
               
                if ($instance->customint1) {
                    
                    $groups = $DB->get_records('groups', array('courseid'=>$instance->courseid), 'id ASC', 'id, enrolmentkey');
                    $found = false;
                    foreach ($groups as $group) {
                        if (empty($group->enrolmentkey)) {
                            continue;
                        }
                        if ($group->enrolmentkey === $data['enrolpassword']) {
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        // We can not hint because there are probably multiple passwords.
                        $errors['enrolpassword'] = get_string('passwordinvalid', 'enrol_self');
                    }

                } else {
                    
                    $plugin = enrol_get_plugin('self');
                    if ($plugin->get_config('showhint')) {
                        $hint = textlib::substr($instance->password, 0, 1);
                        $errors['enrolpassword'] = get_string('passwordinvalidhint', 'enrol_self', $hint);
                    } else {
                        $errors['enrolpassword'] = get_string('passwordinvalid', 'enrol_self');
                    }
                }
            }
            
            //Code to check whether the user entered the valid and unused passcode
            //and to update it to used if the code entered is valid[Custom changes Date: 22/1/2013]
            $code =$DB->count_records('passcode',array('code'=>$data['uniquepasscode'],'used'=>'0','courseid' =>$instance->courseid ));
                if ($code<=0){
                   $errors['uniquepasscode'] = 'Incorrect Passcode, please try again';
                }
                else{
                    if ($data['enrolpassword'] == $instance->password) {
                        $DB->execute("UPDATE mdl_passcode SET used = '1',username='".$USER->username."',enroll_key='".$data['enrolpassword']."' WHERE courseid=$instance->courseid and code='".$data['uniquepasscode']."'");
                        //Update passcode to another database
                        //$this->update_passcode_status_in_other_db($USER->username,$data['enrolpassword'],$data['uniquepasscode']);
                     }
                    
                }
            //ends [Custom changes Date: 22/1/2013]
        }
        //echo $USER->username; die();
        return $errors;
    }
    
//Custom function to Update passcode to another database
//    public function update_passcode_status_in_other_db($username,$enrollment_key,$passcode){
//        global $CFG;
//        $db_hostname = $CFG->sec_dbhost;
//        $db_name = $CFG->sec_dbname;
//        $db_user = $CFG->sec_dbuser;
//        $db_passwd = $CFG->sec_dbpass;
//        $db = mysql_connect($db_hostname, $db_user, $db_passwd);
//        mysql_select_db($db_name, $db);
//        $sql = "UPDATE mdl_passcode SET used = '1',username='".$username."',enroll_key='".$enrollment_key."' WHERE code='".$passcode."'";
//        $result = mysql_query($sql) or die(mysql_error());
//        die();
//        
//    }

    
    
    
}