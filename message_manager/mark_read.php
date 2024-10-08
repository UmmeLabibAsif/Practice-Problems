<?php
require_once('../../config.php');
global $DB, $USER;

$id = required_param('id', PARAM_INT);
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/message_manager/mark_read.php', ['id' => $id]));
$PAGE->set_title('Mark as Read');
$PAGE->set_heading('Mark as Read');

require_login();

// Mark the message as read
$message = $DB->get_record('local_message', ['id' => $id, 'userid' => $USER->id], '*', MUST_EXIST);
$message->isread = 1;
$DB->update_record('local_message', $message);

redirect(new moodle_url('/local/message_manager/index.php'), 'Message marked as read!');
