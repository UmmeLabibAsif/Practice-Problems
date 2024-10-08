<?php
require_once('../../config.php');
global $DB, $USER;

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/message_manager/bulk.php'));
$PAGE->set_title('Bulk Operations');
$PAGE->set_heading('Bulk Operations');

require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $messageids = required_param_array('messageids', PARAM_INT);
    $action = required_param('action', PARAM_ALPHA);

    if ($action === 'delete') {
        // Delete selected messages
        foreach ($messageids as $id) {
            $DB->delete_records('local_message', ['id' => $id, 'userid' => $USER->id]);
        }
        redirect(new moodle_url('/local/message_manager/index.php'), 'Messages deleted successfully!');
    } elseif ($action === 'markread') {
        // Mark selected messages as read
        foreach ($messageids as $id) {
            $message = $DB->get_record('local_message', ['id' => $id, 'userid' => $USER->id], '*', MUST_EXIST);
            $message->isread = 1;
            $DB->update_record('local_message', $message);
        }
        redirect(new moodle_url('/local/message_manager/index.php'), 'Messages marked as read!');
    }
}

// Fetch messages
$messages = $DB->get_records('local_message', ['userid' => $USER->id]);

$templatecontext = [
    'messages' => array_map(function($message) {
        return [
            'id' => $message->id,
            'message' => $message->message,
        ];
    }, $messages),
    'bulkurl' => new moodle_url('/local/message_manager/bulk.php')
];

echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_message_manager/bulk', $templatecontext);
echo $OUTPUT->footer();
