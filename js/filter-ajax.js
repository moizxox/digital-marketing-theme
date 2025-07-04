jQuery(document).ready(function($) {
    $('form').on('change', 'input', function() {
        var form = $(this).closest('form');
        var formData = form.serialize();

        $.ajax({
            url: filter_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_ai_tools',
                nonce: filter_vars.nonce,
                features: form.find('input[name="features[]"]:checked').map(function() {
                    return this.value;
                }).get(),
                pricing: form.find('input[name="pricing[]"]:checked').map(function() {
                    return this.value;
                }).get()
            },
            beforeSend: function() {
                $('#results').html('<p>Loading...</p>');
            },
            success: function(data) {
                $('#results').html(data);
            },
            error: function() {
                $('#results').html('<p>An error occurred. Please try again.</p>');
            }
        });
    });
});
