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
 * User sign-up form.
 *
 * @package    core
 * @subpackage auth
 * @copyright  1999 onwards Martin Dougiamas  http://dougiamas.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->dirroot.'/user/profile/lib.php');

class login_signup_form extends moodleform {
    function definition() {
        global $USER, $CFG;

        $mform = $this->_form;

        $mform->addElement('header', '', get_string('createuserandpass'), '');


        $mform->addElement('text', 'username', get_string('username'), 'maxlength="100" size="12"');
        $mform->setType('username', PARAM_NOTAGS);
        $mform->addRule('username', get_string('missingusername'), 'required', null, 'server');

        if (!empty($CFG->passwordpolicy)){
            $mform->addElement('static', 'passwordpolicyinfo', '', print_password_policy());
        }
        $mform->addElement('passwordunmask', 'password', get_string('password'), 'maxlength="32" size="12"');
        $mform->setType('password', PARAM_RAW);
        $mform->addRule('password', get_string('missingpassword'), 'required', null, 'server');

        $mform->addElement('header', '', get_string('supplyinfo'),'');

        $mform->addElement('text', 'email', get_string('email'), 'maxlength="100" size="25"');
        $mform->setType('email', PARAM_NOTAGS);
        $mform->addRule('email', get_string('missingemail'), 'required', null, 'server');

        $mform->addElement('text', 'email2', get_string('emailagain'), 'maxlength="100" size="25"');
        $mform->setType('email2', PARAM_NOTAGS);
        $mform->addRule('email2', get_string('missingemail'), 'required', null, 'server');

        $nameordercheck = new stdClass();
        $nameordercheck->firstname = 'a';
        $nameordercheck->lastname  = 'b';
        if (fullname($nameordercheck) == 'b a' ) {  // See MDL-4325
            $mform->addElement('text', 'lastname',  get_string('lastname'),  'maxlength="100" size="30"');
            $mform->addElement('text', 'firstname', get_string('firstname'), 'maxlength="100" size="30"');
        } else {
            $mform->addElement('text', 'firstname', get_string('firstname'), 'maxlength="100" size="30"');
            $mform->addElement('text', 'lastname',  get_string('lastname'),  'maxlength="100" size="30"');
        }

        $mform->setType('firstname', PARAM_TEXT);
        $mform->addRule('firstname', get_string('missingfirstname'), 'required', null, 'server');

        $mform->setType('lastname', PARAM_TEXT);
        $mform->addRule('lastname', get_string('missinglastname'), 'required', null, 'server');

        $mform->addElement('text', 'city', get_string('city'), 'maxlength="120" size="20"');
        $mform->setType('city', PARAM_TEXT);
        $mform->addRule('city', get_string('missingcity'), 'required', null, 'server');
        if (!empty($CFG->defaultcity)) {
            $mform->setDefault('city', $CFG->defaultcity);
        }

        $country = get_string_manager()->get_list_of_countries();
        $default_country[''] = get_string('selectacountry');
        $country = array_merge($default_country, $country);
        $mform->addElement('select', 'country', get_string('country'), $country);
        $mform->addRule('country', get_string('missingcountry'), 'required', null, 'server');

        if( !empty($CFG->country) ){
            $mform->setDefault('country', $CFG->country);
        }else{
            $mform->setDefault('country', '');
        }
        
        $s =& $mform->createElement('select','timezone','Timezone ');
		$opts = array('-12.00,0'=>'(-12.00) International Date Line West',
	'-11.00,0'=>'(-11.00) Midway Island, Samoa',
	'-10.00,0'=>'(-10.00) Hawaii',
	'-9.00,1'=>'(-9.00) Alaska',

	'-8.00,1'=>'(-8.00) Pacific Time (US & Canada)',
	'-7.00,0'=>'(-7.00) Arizona',
	'-7.00,1'=>'(-7.00) Mountain Time (US & Canada)',
	'-6.00,0'=>'(-6.00) Central America, Saskatchewan',
	'-6.00,1'=>'(-6.00) Central Time (US & Canada), Guadalajara, Mexico city',

	'-5.00,0'=>'(-5.00) Indiana, Bogota, Lima, Quito, Rio Branco',
	'-5.00,1'=>'(-5.00) Eastern time (US & Canada)',
	'-4.00,1'=>'(-4.00) Atlantic time (Canada), Manaus, Santiago',
	'-4.00,0'=>'(-4.00) Caracas, La Paz',
	'-3.30,1'=>'(-3.30) Newfoundland',
	'-3.00,1'=>'(-3.00) Greenland, Brasilia, Montevideo',

	'-3.00,0'=>'(-3.00) Buenos Aires, Georgetown',
	'-2.00,1'=>'(-2.00) Mid-Atlantic',
	'-1.00,1'=>'(-1.00) Azores',
	'-1.00,0'=>'(-1.00) Cape Verde Is.',
	'00.00,0'=>'(00.00) Casablanca, Monrovia, Reykjavik',
	'00.00,1'=>'(00.00) GMT. Dublin, Edinburgh, Lisbon, London',

	'+1.00,1'=>'(+1.00) Amsterdam, Berlin, Rome, Vienna, Prague, Brussels',
	'+1.00,0'=>'(+1.00) West Central Africa',
	'+2.00,1'=>'(+2.00) Amman, Athens, Istanbul, Beirut, Cairo, Jerusalem',
	'+2.00,0'=>'(+2.00) Harare, Pretoria',
	'+3.00,1'=>'(+3.00) Baghdad, Moscow, St. Petersburg, Volgograd',
	'+3.00,0'=>'(+3.00) Kuwait, Riyadh, Nairobi, Tbilisi',

	'+3.30,0'=>'(+3.30) Tehran',
	'+4.00,0'=>'(+4.00) Abu Dhadi, Muscat',
	'+4.00,1'=>'(+4.00) Baku, Yerevan',
	'+4.30,0'=>'(+4.30) Kabul',
	'+5.00,1'=>'(+5.00) Ekaterinburg',
	'+5.00,0'=>'(+5.00) Islamabad, Karachi, Tashkent',

	'+5.30,0'=>'(+5.30) Chennai, Kolkata, Mumbai, New Delhi, Sri Jayawardenepura',
	'+5.45,0'=>'(+5.45) Kathmandu',
	'+6.00,0'=>'(+6.00) Astana, Dhaka',
	'+6.00,1'=>'(+6.00) Almaty, Nonosibirsk',
	'+6.30,0'=>'(+6.30) Yangon (Rangoon)',
	'+7.00,1'=>'(+7.00) Krasnoyarsk',

	'+7.00,0'=>'(+7.00) Bangkok, Hanoi, Jakarta',
	'+8.00,0'=>'(+8.00) Beijing, Hong Kong, Singapore, Taipei',
	'+8.00,1'=>'(+8.00) Irkutsk, Ulaan Bataar, Perth',
	'+9.00,1'=>'(+9.00) Yakutsk',
	'+9.00,0'=>'(+9.00) Seoul, Osaka, Sapporo, Tokyo',
	'+9.30,0'=>'(+9.30) Darwin',

	'+9.30,1'=>'(+9.30) Adelaide',
	'+10.00,0'=>'(+10.00) Brisbane, Guam, Port Moresby',
	'+10.00,1'=>'(+10.00) Canberra, Melbourne, Sydney, Hobart, Vladivostok',
	'+11.00,0'=>'(+11.00) Magadan, Solomon Is., New Caledonia',
	'+12.00,1'=>'(+12.00) Auckland, Wellington',
	'+12.00,0'=>'(+12.00) Fiji, Kamchatka, Marshall Is.');



		$s->loadArray($opts);
		$mform->addElement($s);
                
        if ($this->signup_captcha_enabled()) {
            $mform->addElement('recaptcha', 'recaptcha_element', get_string('recaptcha', 'auth'), array('https' => $CFG->loginhttps));
            $mform->addHelpButton('recaptcha_element', 'recaptcha', 'auth');
        }

        profile_signup_fields($mform);

        if (!empty($CFG->sitepolicy)) {
            $mform->addElement('header', '', get_string('policyagreement'), '');
            $mform->addElement('static', 'policylink', '', '<a href="'.$CFG->sitepolicy.'" onclick="this.target=\'_blank\'">'.get_String('policyagreementclick').'</a>');
            $mform->addElement('checkbox', 'policyagreed', get_string('policyaccept'));
            $mform->addRule('policyagreed', get_string('policyagree'), 'required', null, 'server');
        }

        // buttons
        $this->add_action_buttons(true, get_string('createaccount'));

    }

    function definition_after_data(){
        $mform = $this->_form;
        $mform->applyFilter('username', 'trim');
    }

    function validation($data, $files) {
        global $CFG, $DB;
        $errors = parent::validation($data, $files);

        $authplugin = get_auth_plugin($CFG->registerauth);

        if ($DB->record_exists('user', array('username'=>$data['username'], 'mnethostid'=>$CFG->mnet_localhost_id))) {
            $errors['username'] = get_string('usernameexists');
        } else {
            //check allowed characters
            if ($data['username'] !== textlib::strtolower($data['username'])) {
                $errors['username'] = get_string('usernamelowercase');
            } else {
                if ($data['username'] !== clean_param($data['username'], PARAM_USERNAME)) {
                    $errors['username'] = get_string('invalidusername');
                }

            }
        }

        //check if user exists in external db
        //TODO: maybe we should check all enabled plugins instead
        if ($authplugin->user_exists($data['username'])) {
            $errors['username'] = get_string('usernameexists');
        }


        if (! validate_email($data['email'])) {
            $errors['email'] = get_string('invalidemail');

        } else if ($DB->record_exists('user', array('email'=>$data['email']))) {
            $errors['email'] = get_string('emailexists').' <a href="forgot_password.php">'.get_string('newpassword').'?</a>';
        }
        if (empty($data['email2'])) {
            $errors['email2'] = get_string('missingemail');

        } else if ($data['email2'] != $data['email']) {
            $errors['email2'] = get_string('invalidemail');
        }
        if (!isset($errors['email'])) {
            if ($err = email_is_not_allowed($data['email'])) {
                $errors['email'] = $err;
            }

        }

        $errmsg = '';
        if (!check_password_policy($data['password'], $errmsg)) {
            $errors['password'] = $errmsg;
        }

        if ($this->signup_captcha_enabled()) {
            $recaptcha_element = $this->_form->getElement('recaptcha_element');
            if (!empty($this->_form->_submitValues['recaptcha_challenge_field'])) {
                $challenge_field = $this->_form->_submitValues['recaptcha_challenge_field'];
                $response_field = $this->_form->_submitValues['recaptcha_response_field'];
                if (true !== ($result = $recaptcha_element->verify($challenge_field, $response_field))) {
                    $errors['recaptcha'] = $result;
                }
            } else {
                $errors['recaptcha'] = get_string('missingrecaptchachallengefield');
            }
        }
        // Validate customisable profile fields. (profile_validation expects an object as the parameter with userid set)
        $dataobject = (object)$data;
        $dataobject->id = 0;
        $errors += profile_validation($dataobject, $files);

        return $errors;

    }

    /**
     * Returns whether or not the captcha element is enabled, and the admin settings fulfil its requirements.
     * @return bool
     */
    function signup_captcha_enabled() {
        global $CFG;
        return !empty($CFG->recaptchapublickey) && !empty($CFG->recaptchaprivatekey) && get_config('auth/email', 'recaptcha');
    }

}
