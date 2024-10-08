<?php
require_once('../../config.php');
global $DB, $USER;

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/message_manager/index.php'));
$PAGE->set_title('Messages List');
$PAGE->set_heading('Messages List');

require_login();

// Fetch messages
$messages = $DB->get_records('local_message', ['userid' => $USER->id]);

echo $OUTPUT->header();

// Check if there are messages to display
if (!empty($messages)) {
    echo html_writer::start_tag('table', ['class' => 'generaltable']);

    // Table headers
    echo html_writer::start_tag('tr');
    echo html_writer::tag('th', 'Message');
    echo html_writer::tag('th', 'Actions');
    echo html_writer::end_tag('tr');

    // Iterate over the messages and display each one
    foreach ($messages as $message) {
        echo html_writer::start_tag('tr');

        // Message content
        echo html_writer::tag('td', format_string($message->message));

        // Actions (Edit, Delete, Mark as Read links)
        $editurl = new moodle_url('/local/message_manager/edit.php', ['id' => $message->id]);
        $deleteurl = new moodle_url('/local/message_manager/delete.php', ['id' => $message->id]);
        $markreadurl = new moodle_url('/local/message_manager/mark_read.php', ['id' => $message->id]);
        $actions = html_writer::link($editurl, 'Edit') . ' | ' .
                   html_writer::link($deleteurl, 'Delete') . ' | ' .
                   html_writer::link($markreadurl, 'Mark as Read');
        echo html_writer::tag('td', $actions);

        echo html_writer::end_tag('tr');
    }

    echo html_writer::end_tag('table');
} else {
    echo $OUTPUT->notification('No messages found', 'info');
}

// Add a link to add a new message
echo html_writer::link(
    new moodle_url('/local/message_manager/add.php'),
    'Add Message',
    ['class' => 'btn btn-primary mb-3']
);

echo $OUTPUT->footer();
