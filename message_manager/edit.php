<?php
require_once('../../config.php');
global $DB, $USER;

$id = required_param('id', PARAM_INT);
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/message_manager/edit.php', ['id' => $id]));
$PAGE->set_title('Edit Message');
$PAGE->set_heading('Edit Message');

require_login();

$message = $DB->get_record('local_message', ['id' => $id], '*', MUST_EXIST);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message->message = required_param('message', PARAM_TEXT);
    $DB->update_record('local_message', $message);
    redirect(new moodle_url('/local/message_manager/index.php'), get_string('messagesuccess', 'local_message_manager'));
}

echo $OUTPUT->header();
$templatecontext = ['message' => $message->message];
echo $OUTPUT->render_from_template('local_message_manager/edit', $templatecontext);
echo $OUTPUT->footer();
