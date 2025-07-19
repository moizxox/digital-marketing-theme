jQuery(document).ready(function($) {
    var $form = $('#csv-import-form');
    var $fileInput = $('#csv_file');
    var $submitBtn = $('#submit-import');
    var $progress = $('#import-progress');
    var $progressBar = $('#progress-bar-fill');
    var $progressText = $('#progress-text');
    var $progressDetails = $('#progress-details');
    var $importMessage = $('#import-message');
    
    $form.on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData();
        formData.append('file', $fileInput[0].files[0]);
        formData.append('action', 'start_ai_tools_import');
        formData.append('nonce', aiToolsImport.nonce);
        
        // Show progress UI
        $progress.show();
        $submitBtn.prop('disabled', true);
        $importMessage.hide().removeClass('notice-success notice-error');
        $progressBar.css('width', '0%');
        $progressText.text('Preparing import...');
        $progressDetails.empty();
        
        // Start the import process
        $.ajax({
            url: aiToolsImport.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        var percent = Math.round((e.loaded / e.total) * 100);
                        $progressBar.css('width', percent + '%');
                        $progressText.text('Uploading: ' + percent + '%');
                    }
                }, false);
                return xhr;
            }
        }).done(function(response) {
            if (response.success) {
                startProcessingChunks(response.data.import_id, response.data.total_chunks, response.data.total_rows);
            } else {
                showError(response.data || 'Failed to start import');
                $submitBtn.prop('disabled', false);
            }
        }).fail(function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            showError('Failed to start import. Please check the console for details.');
            $submitBtn.prop('disabled', false);
        });
    });
    
    function startProcessingChunks(importId, totalChunks, totalRows) {
        var processedChunks = 0;
        
        function processNextChunk() {
            if (processedChunks >= totalChunks) {
                // All chunks processed
                $progressBar.css('width', '100%');
                $progressText.text('Import complete!');
                $submitBtn.prop('disabled', false);
                showSuccess('Import completed successfully!');
                return;
            }
            
            // Update progress
            var progress = Math.round((processedChunks / totalChunks) * 100);
            $progressBar.css('width', progress + '%');
            $progressText.text('Processing batch ' + (processedChunks + 1) + ' of ' + totalChunks + '...');
            
            // Process the next chunk
            $.ajax({
                url: aiToolsImport.ajaxurl,
                type: 'POST',
                data: {
                    action: 'process_ai_tools_chunk',
                    import_id: importId,
                    chunk_index: processedChunks,
                    nonce: aiToolsImport.nonce
                },
                dataType: 'json'
            }).done(function(response) {
                if (response.success) {
                    processedChunks++;
                    
                    // Update progress
                    var progress = Math.round((response.data.processed / response.data.total) * 100);
                    $progressBar.css('width', progress + '%');
                    $progressText.text('Processed ' + response.data.processed + ' of ' + response.data.total + ' items');
                    
                    // Show any errors
                    if (response.data.errors && response.data.errors.length > 0) {
                        var errorHtml = '<div class="notice notice-warning"><p>Some errors occurred in the last batch:</p><ul>';
                        response.data.errors.forEach(function(error) {
                            errorHtml += '<li>' + error + '</li>';
                        });
                        errorHtml += '</ul></div>';
                        $progressDetails.append(errorHtml);
                    }
                    
                    // Process next chunk
                    processNextChunk();
                } else {
                    showError(response.data || 'Error processing batch');
                    $submitBtn.prop('disabled', false);
                }
            }).fail(function(xhr, status, error) {
                console.error('Chunk processing error:', status, error);
                showError('Failed to process batch. Please check the console for details.');
                $submitBtn.prop('disabled', false);
            });
        }
        
        // Start processing chunks
        processNextChunk();
    }
    
    function showError(message) {
        $importMessage.removeClass('notice-success').addClass('notice-error')
            .html('<p>' + message + '</p>')
            .show();
    }
    
    function showSuccess(message) {
        $importMessage.removeClass('notice-error').addClass('notice-success')
            .html('<p>' + message + '</p>')
            .show();
    }
});
