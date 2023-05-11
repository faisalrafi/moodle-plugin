<?php


function local_message_before_footer(){

    global $USER, $DB;

    $sql = "SELECT lm.id, lm.messagetext, lm.messagetype FROM {local_message} lm 
            LEFT OUTER JOIN {local_message_read} lmr ON lm.id = lmr.messageid
            WHERE lmr.userid <> :userid OR lmr.userid IS NULL";

    $params = [
        'userid' => $USER->id,
    ]; 

    $messages = $DB->get_records_sql($sql, $params);

    foreach($messages as $message)
    {
        // $type = \core\output\notification::NOTIFY_INFO;
        if($message->messagetype === '0'){
            $type = \core\output\notification::NOTIFY_WARNING;
        }
        if($message->messagetype === '1'){
            $type = \core\output\notification::NOTIFY_SUCCESS;
        }
        if($message->messagetype === '2'){
            $type = \core\output\notification::NOTIFY_ERROR;
        }
        if($message->messagetype === '3'){
            $type = \core\output\notification::NOTIFY_INFO;
        }
        // \core\notification::add($message->messagetext, $type);

        $readrecord = new stdClass();
        $readrecord->messageid = $message->id;
        $readrecord->userid = $USER->id;
        $readrecord->timeread = time();
        $DB->insert_record('local_message_read', $readrecord);
    }

   
}