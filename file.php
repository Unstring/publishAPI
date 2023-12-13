<?php

$directoryPath = '/app/services/avatar';
$command = 'chmod 755 ' . $directoryPath;

$output = shell_exec($command);

// Checking the output can help verify if the command executed successfully
if ($output === null) {
    echo "Permissions changed successfully for: $directoryPath";
} else {
    echo "Failed to change permissions for: $directoryPath";
    // Log the error if needed
    error_log("Failed to change permissions for: $directoryPath");
}
