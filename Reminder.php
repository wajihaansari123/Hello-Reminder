<?php
/**
 * Plugin Name: Reminder Plugin
 * Description: This plugin allows the user to set custom reminders that are shown as notifications in the admin dashboard.
 * Version: 1.1.0
 * Author: Wajiha Ansari
 * Plugin URI: https://example.com
 */

// Create a custom settings page for users to input their reminder
function hw_reminder_menu() {
    add_menu_page('Reminder Settings', 'Reminder Settings', 'manage_options', 'reminder-settings', 'hw_reminder_settings_page', 'dashicons-bell', 110);
}
add_action('admin_menu', 'hw_reminder_menu');

// Settings page content
function hw_reminder_settings_page() {
    ?>
    <div class="wrap">
        <h1>Set Your Reminder</h1>
        <form method="post" action="options.php">
            <?php
            // Output security fields for the registered setting
            settings_fields('hw_reminder_options_group');

            // Output setting sections and fields
            do_settings_sections('reminder-settings');

            // Submit button
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register and define the settings

function hw_register_reminder_settings() {
    // Register the 'hw_reminder_message' setting
    register_setting('hw_reminder_options_group', 'hw_reminder_message');

    // Add a settings section
    add_settings_section('hw_reminder_section', 'Reminder Message', null, 'reminder-settings');

    // Add a settings field for the reminder message
    add_settings_field('hw_reminder_message_field', 'Enter Reminder', 'hw_reminder_message_field_callback', 'reminder-settings', 'hw_reminder_section');
}
add_action('admin_init', 'hw_register_reminder_settings');


// Callback to display the reminder message input field
function hw_reminder_message_field_callback() {
    // Get the current value of the setting
    $reminder = get_option('hw_reminder_message', '');
    echo '<input type="text" id="hw_reminder_message" name="hw_reminder_message" value="' . esc_attr($reminder) . '" style="width:300px;" />';
}

// Show the reminder message as an admin notice

function hw_show_user_reminder() {
    // Get the reminder message set by the user
    $reminder = get_option('hw_reminder_message', '');

    // Display the message if it's not empty
    if (!empty($reminder)) {
        echo '<div class="notice notice-info is-dismissible"><p>' . esc_html($reminder) . '</p></div>';
    }
}
add_action("admin_notices", "hw_show_user_reminder");

// Admin Dashboard Widget 
function hw_add_dashboard_widget(){
    wp_add_dashboard_widget('hw_dashboard_widget', 'Reminder Plugin', 'hw_dashboard_widget_content');
}

function hw_dashboard_widget_content(){
    echo '<p>Use the <strong>Reminder Settings</strong> page to set your reminder.</p>';
}
add_action('wp_dashboard_setup', 'hw_add_dashboard_widget');