<?php
/**
 * @package     local_message
 * @author      Faisal Abid
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class edit extends moodleform {
    //Add elements to form
    public function definition() {
        global $CFG, $DB;
       
        $choices = array();
        $choices['0'] = \core\output\notification::NOTIFY_WARNING;
        $choices['1'] = \core\output\notification::NOTIFY_SUCCESS;
        $choices['2'] = \core\output\notification::NOTIFY_ERROR;
        $choices['3'] = \core\output\notification::NOTIFY_INFO;
        $mform = $this->_form; // Don't forget the underscore! 

        if(isset($_GET['messageid'])){
            $data = $DB->get_record('local_message', ['id' => $_GET['messageid']]);

            $mform->addElement('text', 'messagetext', get_string('message_text', 'local_message')); // Add elements to your form.
            $mform->setType('messagetext', PARAM_NOTAGS);                   // Set type of element.
            $mform->setDefault('messagetext', $data->messagetext);        // Default value.
            
            $mform->addElement('select', 'messagetype',  get_string('message_type', 'local_message'), $choices);
            $mform->setDefault('messagetype', $data->messagetype);
            $this->add_action_buttons();
        
        }
        else{
            $mform->addElement('text', 'messagetext', get_string('message_text', 'local_message')); // Add elements to your form.
            $mform->setType('messagetext', PARAM_NOTAGS);                   // Set type of element.
            $mform->setDefault('messagetext', get_string('enter_message', 'local_message'));        // Default value.
            
            $mform->addElement('select', 'messagetype',  get_string('message_type', 'local_message'), $choices);
            $mform->setDefault('messagetype', '3');
            $this->add_action_buttons();
        }
    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}