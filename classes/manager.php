<?php

/**
 * @package     local_message
 * @author      Faisal Abid
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_message;

use dml_exception;
use stdClass;

class manager{
    /** Insert the data into our database table.
     * @param string $message_text
     * @param string $message_type
     * @return bool true if successful
    */
    public function create_message(string $message_text, string $message_type): bool
    {
        global $DB;
        $record_to_insert = new stdClass();
        $record_to_insert->messagetext = $message_text;
        $record_to_insert->messagetype = $message_type;
        try {
            return $DB->insert_record('local_message', $record_to_insert, false);
        } catch (dml_exception $e) {
            return false;
        }
    }

    /** Gets all messages that have not been read by this user
     * @param int $userid the user that we are getting messages for
     * @return array of messages
     */
    // public function get_messages(int $userid): array
    // {
    //     global $DB;
    //     $sql = "SELECT lm.id, lm.messagetext, lm.messagetype 
    //         FROM {local_message} lm 
    //         LEFT OUTER JOIN {local_message_read} lmr ON lm.id = lmr.messageid AND lmr.userid = :userid 
    //         WHERE lmr.userid IS NULL";
    //     $params = [
    //         'userid' => $userid,
    //     ];
    //     try {
    //         return $DB->get_records_sql($sql, $params);
    //     } catch (dml_exception $e) {
    //         // Log error here.
    //         return [];
    //     }
    // }


    /** Update details for a single message.
     * @param int $messageid the message we're trying to get.
     * @param string $message_text the new text for the message.
     * @param string $message_type the new type for the message.
     * @return bool message data or false if not found.
     */
    public function update_message(int $messageid, string $message_text, string $message_type): bool
    {
        global $DB;
        $updateRecord = new stdClass();
        $updateRecord->id = $messageid;
        $updateRecord->messagetext = $message_text;
        $updateRecord->messagetype = $message_type;
        return $DB->update_record('local_message', $updateRecord);
    }




}