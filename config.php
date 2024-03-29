<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'mysqli';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'moodle24';
$CFG->dbuser    = 'root';
$CFG->dbpass    = 'mindzpark';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbsocket' => 0,
);

$CFG->wwwroot   = 'http://localhost/moodle24';
$CFG->dataroot  = 'C:\\xampp\\moodledata';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 0777;

$CFG->passwordsaltmain = 'br9Z@`40qx=z./rao;Xr5TnQP;<q';

require_once(dirname(__FILE__) . '/lib/setup.php');



// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
