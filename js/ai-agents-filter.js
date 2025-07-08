jQuery(document).ready(function($) {
    // Only run this code on AI Agents archive page
    if (!$('body').hasClass('post-type-archive-ai-agent')) return;

    // Cache selectors specific to AI Agents section
    const $aiAgentsFilter = $('#ai-agents-filter');
    const $aiAgentsResults = $('#ai-agents-results');
    const $aiAgentsCategoryButtons = $('.ai-agents-category-button');
    const $aiAgentsCheckboxes = $aiAgentsFilter.find('input[type="checkbox"]');

    // Handle filter form submission
    $aiAgentsFilter.on('submit', function(e) {
        e.preventDefault();
        filterAIAgents();
    });

    // Handle category button clicks
    $aiAgentsCategoryButtons.on('click', function() {
        $aiAgentsCategoryButtons.removeClass('active-btn');
        $(this).addClass('active-btn');
        filterAIAgents();
    });

    // Handle checkbox changes
    $aiAgentsCheckboxes.on('change', function() {
        filterAIAgents();
    });

    function filterAIAgents() {
        // Show loading state only for AI Agents section
        $aiAgentsResults.addClass('opacity-50');
        $aiAgentsResults.html('<div class="col-span-3 text-center py-12"><div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div></div>');

        // Get selected category
        const selectedCategory = $aiAgentsCategoryButtons.filter('.active-btn').data('category') || '';

        // Get selected features
        const selectedFeatures = [];
        $aiAgentsFilter.find('input[name="features[]"]:checked').each(function() {
            selectedFeatures.push($(this).val());
        });

        // Get selected pricing options
        const selectedPricing = [];
        $aiAgentsFilter.find('input[name="pricing[]"]:checked').each(function() {
            selectedPricing.push($(this).val());
        });

        // Create form data
        const formData = new FormData();
        formData.append('action', 'filter_ai_agents');
        formData.append('nonce', ajax_object.nonce);
        
        if (selectedCategory) {
            formData.append('category', selectedCategory);
        }
        
        if (selectedFeatures.length) {
            selectedFeatures.forEach(feature => {
                formData.append('features[]', feature);
            });
        }
        
        if (selectedPricing.length) {
            selectedPricing.forEach(price => {
                formData.append('pricing[]', price);
            });
        }

        // Send AJAX request
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $aiAgentsResults.html(response.data.html);
                } else {
                    $aiAgentsResults.html('<p class="text-center w-full col-span-3">' + response.data.message + '</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                $('#results').html('<p class="text-center w-full col-span-3">An error occurred. Please try again.</p>');
            },
            complete: function() {
                $aiAgentsResults.removeClass('opacity-50');
            }
        });
    }
});
