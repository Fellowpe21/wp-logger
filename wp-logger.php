<?php
/*
Plugin Name: Automated Login Plugin
Description: Plugin to automate Single Sign-On generation for administrators.
Version: 1.0
Author:  Felipe Viveros
*/

// Add menu item to the WordPress dashboard
add_action('admin_menu', 'automated_login_menu');
function automated_login_menu() {
    add_menu_page('Automated Login', 'Automated Login', 'manage_options', 'automated-login', 'automated_login_page', 'dashicons-admin-network');
}

// Function to display plugin page
function automated_login_page() {
    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        $username = sanitize_user($_POST['username']);

        // Run the wp cli command to generate one-time login link
        $sso_command = shell_exec("wp user one-time-login $username");

        // Output the command
        echo "<p>SSO command for user '$username':</p>";
        echo "<pre>$sso_command</pre>";
    }

    // Display the form
    ?>
    <div class="wrap">
        <h1>Automated Login</h1>
        <form method="post">
            <label for="username">WordPress Username:</label><br>
            <input type="text" id="username" name="username" required><br><br>
            <input type="submit" name="submit" value="Generate SSO">
        </form>
    </div>
    <?php
}
