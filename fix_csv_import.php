<?php
/**
 * This script contains the fixed CSV import functions for AI Tools and AI Agents
 * To apply these changes, replace the corresponding functions in functions.php
 */

/**
 * Fixed version of handle_start_ai_tools_import
 */
function handle_start_ai_tools_import_fixed()
{
    // Verify nonce and permissions
    if (!check_ajax_referer('ai_tools_import_nonce', 'nonce', false)) {
        wp_send_json_error('Invalid nonce');
    }

    if (!current_user_can('manage_options')) {
        wp_send_json_error('Insufficient permissions');
    }

    // Get the uploaded file
    if (empty($_FILES['file'])) {
        wp_send_json_error('No file uploaded');
    }

    $file = $_FILES['file'];

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        wp_send_json_error('File upload error: ' . $file['error']);
    }

    // Parse the CSV into chunks
    $csv_data = array();
    $header = array();
    
    // Open the CSV file with error handling
    if (($handle = fopen($file['tmp_name'], 'r')) !== FALSE) {
        // Get the header row
        $header = fgetcsv($handle);
        
        // Read the rest of the file
        while (($row = fgetcsv($handle)) !== FALSE) {
            $csv_data[] = $row;
        }
        
        fclose($handle);
    } else {
        wp_send_json_error('Failed to open the uploaded file');
    }
    
    $chunks = array_chunk($csv_data, 50);  // 50 rows per chunk

    // Store chunks in a transient (expires in 1 hour)
    $import_id = 'ai_tools_import_' . time();
    set_transient($import_id, array(
        'total' => count($csv_data),
        'processed' => 0,
        'chunks' => $chunks,
        'header' => $header,
        'errors' => array()
    ), HOUR_IN_SECONDS);

    wp_send_json_success(array(
        'import_id' => $import_id,
        'total_chunks' => count($chunks),
        'total_rows' => count($csv_data)
    ));
}

/**
 * Fixed version of handle_start_ai_agents_import
 */
function handle_start_ai_agents_import_fixed()
{
    // Verify nonce and permissions
    if (!check_ajax_referer('ai_agents_import_nonce', 'nonce', false)) {
        wp_send_json_error('Invalid nonce');
    }

    if (!current_user_can('manage_options')) {
        wp_send_json_error('Insufficient permissions');
    }

    // Get the uploaded file
    if (empty($_FILES['file'])) {
        wp_send_json_error('No file uploaded');
    }

    $file = $_FILES['file'];

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        wp_send_json_error('File upload error: ' . $file['error']);
    }

    // Parse the CSV into chunks
    $csv_data = array();
    $header = array();
    
    // Open the CSV file with error handling
    if (($handle = fopen($file['tmp_name'], 'r')) !== FALSE) {
        // Get the header row
        $header = fgetcsv($handle);
        
        // Read the rest of the file
        while (($row = fgetcsv($handle)) !== FALSE) {
            $csv_data[] = $row;
        }
        
        fclose($handle);
    } else {
        wp_send_json_error('Failed to open the uploaded file');
    }
    
    $chunks = array_chunk($csv_data, 50);  // 50 rows per chunk

    // Store chunks in a transient (expires in 1 hour)
    $import_id = 'ai_agents_import_' . time();
    set_transient($import_id, array(
        'total' => count($csv_data),
        'processed' => 0,
        'chunks' => $chunks,
        'header' => $header,
        'errors' => array()
    ), HOUR_IN_SECONDS);

    wp_send_json_success(array(
        'import_id' => $import_id,
        'total_chunks' => count($chunks),
        'total_rows' => count($csv_data)
    ));
}
?>

<!-- Instructions for applying these changes: 
1. Replace the existing handle_start_ai_tools_import() function in functions.php with the fixed version above
2. Replace the existing handle_start_ai_agents_import() function in functions.php with the fixed version above
3. The main changes are:
   - Using fgetcsv() with a file handle instead of file() + array_map()
   - Proper error handling for file operations
   - Better handling of CSV fields that contain line breaks
-->
