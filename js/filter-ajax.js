jQuery(document).ready(function($) {
    // Handle filter form changes
    $('form').on('change', 'input', function() {
        filterTools();
    });

    // Handle category button clicks
    $('.category-button').on('click', function() {
        // Toggle active class
        $('.category-button').removeClass('active-btn');
        $(this).addClass('active-btn');
        
        // Trigger filter with category
        filterTools($(this).data('category'));
    });

    function filterTools(category = '') {
        $.ajax({
            url: filter_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_ai_tools',
                nonce: filter_vars.nonce,
                category: category,
                features: $('input[name="features[]"]:checked').map(function() {
                    return this.value;
                }).get(),
                pricing: $('input[name="pricing[]"]:checked').map(function() {
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
    }
});
