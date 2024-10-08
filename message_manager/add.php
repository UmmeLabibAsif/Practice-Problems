<?php
require_once('../../config.php');
global $DB, $USER;

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/message_manager/add.php'));
$PAGE->set_title('Add Message');
$PAGE->set_heading('Add Message');

require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = new stdClass();
    $data->message = required_param('message', PARAM_TEXT);
    $data->userid = $USER->id;
    $data->timecreated = time();
    $data->isread = 0;

    $DB->insert_record('local_message', $data);
    redirect(new moodle_url('/local/message_manager/index.php'), get_string('messagesuccess', 'local_message_manager'));
}

echo $OUTPUT->header();
$templatecontext = [];
echo $OUTPUT->render_from_template('local_message_manager/add', $templatecontext);
echo $OUTPUT->footer();
