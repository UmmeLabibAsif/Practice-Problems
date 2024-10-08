<?php
require_once('../../config.php');
global $DB;

$id = required_param('id', PARAM_INT);
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/message_manager/delete.php', ['id' => $id]));
$PAGE->set_title('Delete Message');
$PAGE->set_heading('Delete Message');

require_login();

$DB->delete_records('local_message', ['id' => $id]);
redirect(new moodle_url('/local/message_manager/index.php'), 'Message deleted successfully!');
