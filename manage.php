<?php
/**
 * @package     local_message
 * @author      Faisal Abid
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once(__DIR__ . '/../../config.php');
global $DB;

$PAGE->set_url(new moodle_url('/local/message/manage.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('manage_messages', 'local_message'));

$messages = $DB->get_records('local_message', null, 'id');

echo $OUTPUT->header();

$templatecontext = (object)[
    'messages' => array_values($messages),
    'editurl' => new moodle_url('/local/message/edit.php'),
];

echo $OUTPUT->render_from_template('local_message/manage', $templatecontext);

if(isset($_GET['did'])){
    $DB->delete_records('local_message', ['id' => $_GET['did']]);
    redirect($CFG->wwwroot . '/local/message/manage.php', get_string('delete_form', 'local_message') . $fromform->messagetext);
}

echo $OUTPUT->footer(); 
?>