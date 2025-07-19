jQuery(document).ready(function($) {
    $('#csv-import-form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $submitBtn = $('#submit-import');
        var $spinner = $form.find('.spinner');
        var $progressContainer = $('#import-progress');
        var $progressBar = $('#progress-bar-fill');
        var $progressText = $('#progress-text');
        var $progressDetails = $('#progress-details');
        var $message = $('#import-message');
        
        // Reset UI
        $message.removeClass('notice-success notice-error').hide().empty();
        $progressContainer.show();
        $submitBtn.prop('disabled', true);
        $spinner.addClass('is-active');
        
        // Create FormData object
        var formData = new FormData();
        var fileInput = document.getElementById('csv_file');
        
        if (fileInput.files.length === 0) {
            showError('Please select a CSV file to import.');
            return;
        }
        
        formData.append('file', fileInput.files[0]);
        formData.append('action', 'start_ai_agents_import');
        formData.append('nonce', aiAgentsImport.nonce);
        
        // Show initial progress
        updateProgress(0, 'Starting import...');
        
        // Start the import process
        $.ajax({
            url: aiAgentsImport.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var data = response.data;
                    processChunk(data.import_id, 0, data.total_chunks, data.total_rows);
                } else {
                    showError(response.data || 'Failed to start import.');
                    resetForm();
                }
            },
            error: function(xhr, status, error) {
                showError('Error: ' + (xhr.responseJSON && xhr.responseJSON.data ? xhr.responseJSON.data : 'Unknown error occurred'));
                resetForm();
            }
        });
        
        // Process a single chunk
        function processChunk(importId, chunkIndex, totalChunks, totalRows) {
            if (chunkIndex >= totalChunks) {
                // All chunks processed
                updateProgress(100, 'Import completed!');
                showSuccess('Successfully imported ' + totalRows + ' AI Agents.');
                resetForm();
                return;
            }
            
            var currentRow = chunkIndex * 50;
            var progress = Math.round((currentRow / totalRows) * 100);
            
            updateProgress(
                progress,
                'Processing batch ' + (chunkIndex + 1) + ' of ' + totalChunks + '...',
                'Processed ' + currentRow + ' of ' + totalRows + ' rows'
            );
            
            // Process the current chunk
            $.ajax({
                url: aiAgentsImport.ajaxurl,
                type: 'POST',
                data: {
                    action: 'process_ai_agents_chunk',
                    import_id: importId,
                    chunk_index: chunkIndex,
                    nonce: aiAgentsImport.nonce
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var data = response.data;
                        var progress = Math.round((data.processed / data.total) * 100);
                        
                        updateProgress(
                            progress,
                            'Processing batch ' + data.current_chunk + ' of ' + data.total_chunks + '...',
                            'Processed ' + data.processed + ' of ' + data.total + ' rows'
                        );
                        
                        // Show any errors that occurred during this chunk
                        if (data.errors && data.errors.length > 0) {
                            showError(data.errors.join('<br>'));
                        }
                        
                        // Process the next chunk
                        processChunk(importId, chunkIndex + 1, totalChunks, totalRows);
                    } else {
                        showError(response.data || 'Error processing chunk ' + (chunkIndex + 1));
                        resetForm();
                    }
                },
                error: function(xhr, status, error) {
                    showError('Error processing chunk ' + (chunkIndex + 1) + ': ' + (xhr.responseJSON && xhr.responseJSON.data ? xhr.responseJSON.data : 'Unknown error'));
                    resetForm();
                }
            });
        }
        
        // Update progress bar and text
        function updateProgress(percent, text, details) {
            $progressBar.css('width', percent + '%');
            
            if (text) {
                $progressText.text(text);
            }
            
            if (details) {
                $progressDetails.text(details);
            }
        }
        
        // Show success message
        function showSuccess(message) {
            $message
                .removeClass('notice-error')
                .addClass('notice-success')
                .html('<p>' + message + '</p>')
                .show();
        }
        
        // Show error message
        function showError(message) {
            $message
                .removeClass('notice-success')
                .addClass('notice-error')
                .html('<p>' + message + '</p>')
                .show();
        }
        
        // Reset form to initial state
        function resetForm() {
            $submitBtn.prop('disabled', false);
            $spinner.removeClass('is-active');
            $form.trigger('reset');
        }
    });
});
