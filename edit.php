<?php

/**
 * @package     local_message
 * @author      Faisal Abid
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/local/message/classes/form/edit.php');

global $DB;

$PAGE->set_url(new moodle_url('/local/message/edit.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Edit');

//we want to display our form.
$mform = new edit();

if ($mform->is_cancelled()) 
{
    redirect($CFG->wwwroot . '/local/message/manage.php', get_string('cancel_form', 'local_message'));
} 
else if ($fromform = $mform->get_data()) {
  
        $updateRecord = new stdClass();
        $updateRecord->messagetext = $fromform->messagetext;
        $updateRecord->messagetype = $fromform->messagetype;

        if($fromform->id != NULL){
          $updateRecord->id = $fromform->id;
          $DB->update_record('local_message', $updateRecord);
          redirect($CFG->wwwroot . '/local/message/manage.php', get_string('updated_form', 'local_message') . $fromform->messagetext);
        }
      
        else{
          $DB->insert_record('local_message', $updateRecord);
          //go back to manage page
          redirect($CFG->wwwroot . '/local/message/manage.php', get_string('create_form', 'local_message') . $fromform->messagetext);
        }
  
    
  }


echo $OUTPUT->header();

$mform->display();

echo $OUTPUT->footer(); 
