<?php

/** AI Tool Submission Modal */
?>
<div id="aiSubmissionModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-semibold text-gray-800">Submit Your AI Tool</h3>
                    <button type="button" onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                        <span class="text-2xl">&times;</span>
                    </button>
                </div>
                
                <form id="aiToolForm" class="space-y-6" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="package_type" id="packageType" value="">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tool Name -->
                        <div class="md:col-span-2">
                            <label for="tool_name" class="block text-sm font-medium text-gray-700 mb-1">Tool Name <span class="text-red-500">*</span></label>
                            <input type="text" id="tool_name" name="tool_name" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Email -->
                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <!-- Website URL -->
                        <div class="md:col-span-2">
                            <label for="website_url" class="block text-sm font-medium text-gray-700 mb-1">Website URL <span class="text-red-500">*</span></label>
                            <input type="url" id="website_url" name="website_url" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   placeholder="https://">
                        </div>
                        
                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                            <select id="category" name="category" required 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Select a category</option>
                                <option value="seo">SEO</option>
                                <option value="content">Content</option>
                                <option value="marketing">Marketing</option>
                                <option value="email_automation">Email Automation</option>
                                <option value="other">Other</option>
                            </select>
                            <div id="otherCategoryContainer" class="mt-2 hidden">
                                <input type="text" id="other_category" name="other_category" 
                                       placeholder="Please specify" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                            </div>
                        </div>
                        
                        <!-- Pricing Model -->
                        <div>
                            <label for="pricing_model" class="block text-sm font-medium text-gray-700 mb-1">Pricing Model</label>
                            <select id="pricing_model" name="pricing_model" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="free">Free</option>
                                <option value="freemium">Freemium</option>
                                <option value="paid">Paid</option>
                                <option value="one_time">One-time Purchase</option>
                                <option value="subscription">Subscription</option>
                                <option value="custom">Custom</option>
                            </select>
                        </div>
                        
                        <!-- Package Type -->
                        <div>
                            <label for="package_type_select" class="block text-sm font-medium text-gray-700 mb-1">Package Type <span class="text-red-500">*</span></label>
                            <select id="package_type_select" name="package_type_select" required 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="basic">Basic Package ($49.99)</option>
                                <option value="premium">Premium Package ($299.99)</option>
                            </select>
                        </div>
                        
                        <!-- Logo Upload -->
                        <div class="md:col-span-2">
                            <label for="logo_upload" class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                            <div class="mt-1 flex items-center">
                                <input type="file" id="logo_upload" name="logo_upload" accept="image/*" 
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                        
                        <!-- Short Description -->
                        <div class="md:col-span-2">
                            <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">Short Description <span class="text-red-500">*</span></label>
                            <textarea id="short_description" name="short_description" rows="2" required
                                     class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                     placeholder="A brief description of your tool (max 200 characters)"></textarea>
                        </div>
                        
                        <!-- Full Description -->
                        <div class="md:col-span-2">
                            <label for="full_description" class="block text-sm font-medium text-gray-700 mb-1">Full Description <span class="text-red-500">*</span></label>
                            <textarea id="full_description" name="full_description" rows="4" required
                                     class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                     placeholder="Detailed description of your tool's features and benefits"></textarea>
                        </div>
                        
                        <!-- Primary Features / USP -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Primary Features / USP <span class="text-red-500">*</span></label>
                            <div id="features-container" class="space-y-2">
                                <div class="flex items-center">
                                    <input type="text" name="features[]" required
                                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Feature 1">
                                    <button type="button" onclick="removeFeature(this)" class="ml-2 text-red-500 hover:text-red-700">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <button type="button" onclick="addFeature()" class="mt-2 inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="-ml-0.5 mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Feature
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Submit & Pay
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Thank You Popup -->
<div id="thankYouPopup" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
  <div class="bg-white px-6 py-4 rounded-md shadow-md text-center">
    <h2 class="text-xl font-semibold text-green-600">Thank you! 🎉</h2>
    <p class="text-gray-700 mt-2">Your tool has been submitted successfully. You will be redirected to the payment page.</p>
  </div>
</div>

<script>
// Make sure jQuery is loaded
if (typeof jQuery === 'undefined') {
    var script = document.createElement('script');
    script.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
    script.onload = function() {
        console.log('jQuery loaded successfully');
    };
    document.head.appendChild(script);
}

// Modal functions
function openModal(packageType) {
    document.getElementById('packageType').value = packageType;
    document.getElementById('package_type_select').value = packageType;
    document.getElementById('aiSubmissionModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('aiSubmissionModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Category other field toggle
document.getElementById('category').addEventListener('change', function() {
    const otherContainer = document.getElementById('otherCategoryContainer');
    otherContainer.style.display = this.value === 'other' ? 'block' : 'none';
    if (this.value !== 'other') {
        document.getElementById('other_category').value = '';
    }
});

// Add/remove feature fields
function addFeature() {
    const container = document.getElementById('features-container');
    const featureCount = container.querySelectorAll('input[type="text"]').length + 1;
    
    const featureDiv = document.createElement('div');
    featureDiv.className = 'flex items-center';
    featureDiv.innerHTML = `
        <input type="text" name="features[]" required
               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
               placeholder="Feature ${featureCount}">
        <button type="button" onclick="removeFeature(this)" class="ml-2 text-red-500 hover:text-red-700">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;
    container.appendChild(featureDiv);
}

function removeFeature(button) {
    const container = document.getElementById('features-container');
    if (container.querySelectorAll('input[type="text"]').length > 1) {
        button.closest('.flex').remove();
    } else {
        button.previousElementSibling.value = '';
    }
}

document.querySelector('#aiToolForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    formData.append('action', 'submit_ai_tool');
    formData.append('nonce', '<?php echo wp_create_nonce('submit_ai_tool_nonce'); ?>');

    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {
            document.getElementById('thankYouPopup').classList.remove('hidden');
            closeModal();

            setTimeout(() => {
                document.getElementById('thankYouPopup').classList.add('hidden');
                const packageType = formData.get('package_type_select');

                if (packageType === 'basic') {
                    window.location.href = 'https://buy.stripe.com/4gM7sL2Eq34l6jN4wz5J60k';
                } else if (packageType === 'premium') {
                    window.location.href = 'https://buy.stripe.com/eVq28r6UG48pgYr8MP5J60m';
                } else {
                    alert('Invalid package type selected.');
                }
            }, 5000);
        } else {
            alert(response.data?.message || 'Submission failed. Please try again.');
        }
    })
    .catch(() => {
        alert('An error occurred while submitting the form.');
    });
});


// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('aiSubmissionModal');
    if (event.target === modal) {
        closeModal();
    }
}
</script>
