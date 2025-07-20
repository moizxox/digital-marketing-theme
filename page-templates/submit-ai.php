<?php

/** Template Name: Submit Ai */
if (!defined('ABSPATH')) {
  exit;
}

get_header();

?>
<section class="hero-sec px-3 sm:px-5 py-[60px] sm:py-[80px]">
      <section class="flex flex-col lg:px-[60px] gap-[64px] max-w-[1440px] mx-auto">
        <div class="flex flex-col gap-[24px]">
          <h1 class="text-[1.8rem] sm:text-[2.5rem] text-[#333333] font-semibold">
            Submit Your AI Tool
          </h1>
          <ul class="flex flex-col gap-[16px]">
            <li>
              <p class="text-[1.1rem] text-[#555555]">
                We’re thrilled you want to share your AI tool with us.
              </p>
            </li>
            <li>
              <p class="text-[1.1rem] text-[#555555]">
                Thousands visit our site daily. They are eager to discover the next big thing.
              </p>
            </li>
            <li>
              <p class="text-[1.1rem] text-[#555555]">
                As a founder or developer, your tool deserves its moment. Show it off and let it
                shine!
              </p>
            </li>
          </ul>
        </div>
        <div class="flex flex-col gap-[32px]">
          <div class="flex flex-col gap-1">
            <h2 class="text-[1.75rem] sm:text-[2rem] text-[#333333] font-semibold">
              Choose Your Package
            </h2>
            <p class="border-b-[4px] border-[var(--primary)] w-[60px]"></p>
          </div>
          <div class="grid lg:grid-cols-2 gap-[32px]">
            <div
              class="border border-[#e0e0e0] flex flex-col gap-2 rounded-lg h-[305px] bg-white shadow-md p-[32px] transition-all duration-300 transform hover:-translate-y-2 hover:shadow-lg"
            >
              <h3 class="text-[var(--primary)] text-[1.8rem] font-semibold">Basic Submission</h3>
              <p class="text-[1.4rem] text-[#333333]">$49.99 / one-time payment</p>
              <ul class="flex flex-col gap-1">
                <li class="text-[#28a745] flex items-center gap-2">
                  <i class="fa-solid fa-circle-check"></i>
                  <p class="text-[#555555]">Listed within 48 hours</p>
                </li>
                <li class="text-[#28a745] flex items-center gap-2">
                  <i class="fa-solid fa-circle-check"></i>
                  <p class="text-[#555555]">Shown as a new tool on our homepage for 24–48 hours</p>
                </li>
                <li class="text-[#28a745] flex items-center gap-2">
                  <i class="fa-solid fa-circle-check"></i>
                  <p class="text-[#555555]">Listed forever</p>
                </li>
              </ul>
              <div>
                <a
                  href="#"
                  class="bg-[var(--primary)] relative rounded-md text-base top-[20px] text-white px-[24px] py-[12px] submit-tool-btn"
                  data-package-type="basic"
                  >Submit Tool</a
                >
              </div>
            </div>
            <div
              class="border border-[#e0e0e0] flex flex-col gap-2 rounded-lg h-[305px] bg-white shadow-md p-[32px] transition-all duration-300 transform hover:-translate-y-2 hover:shadow-lg"
            >
              <h3 class="text-[var(--primary)] text-[1.8rem] font-semibold">Featured Package</h3>
              <p class="text-[1.4rem] text-[#333333]">$299.99 / one-time payment</p>
              <ul class="flex flex-col gap-1">
                <li class="text-[#28a745] flex items-center gap-2">
                  <i class="fa-solid fa-circle-check"></i>
                  <p class="text-[#555555]">Stay featured for 7 days</p>
                </li>
                <li class="text-[#28a745] flex items-center gap-2">
                  <i class="fa-solid fa-circle-check"></i>
                  <p class="text-[#555555]">Top spot on your tool’s category page</p>
                </li>
                <li class="text-[#28a745] flex items-center gap-2">
                  <i class="fa-solid fa-circle-check"></i>
                  <p class="text-[#555555]">Extra traffic from related tool pages</p>
                </li>
              </ul>
              <div>
                <a
                  href="#"
                  class="bg-[var(--primary)] relative rounded-md text-base top-[20px] text-white px-[24px] py-[12px] submit-tool-btn"
                  data-package-type="premium"
                  >Get Started</a
                >
              </div>
            </div>
          </div>
        </div>
        <div class="flex flex-col gap-[32px]">
          <div class="flex flex-col gap-1">
            <h2 class="text-[1.75rem] sm:text-[2rem] text-[#333333] font-semibold">
              Why List an AI on Our Platform?
            </h2>
            <p class="border-b-[4px] border-[var(--primary)] w-[60px]"></p>
          </div>
          <div class="grid lg:grid-cols-3 gap-[32px]">
            <div
              class="border border-[#e0e0e0] flex flex-col gap-3 rounded-lg bg-white shadow-md p-[32px] transition-all duration-300 transform hover:-translate-y-2 hover:shadow-lg"
            >
              <p class="text-[32px] text-[var(--primary)]"><i class="fa-solid fa-bullhorn"></i></p>
              <h3 class="text-[1.5rem] text-[#333333] font-semibold">Great Exposure 💯</h3>
              <p class="text-[1rem] text-[#555555]">
                Your tool gets seen by thousands. Our visitors are always looking for fresh AI
                solutions.
              </p>
            </div>
            <div
              class="border border-[#e0e0e0] flex flex-col gap-3 rounded-lg bg-white shadow-md p-[32px] transition-all duration-300 transform hover:-translate-y-2 hover:shadow-lg"
            >
              <p class="text-[var(--primary)] text-[32px]"><i class="fa-solid fa-rotate"></i></p>
              <h3 class="text-[1.5rem] text-[#333333] font-semibold">Traffic Forever 🔄</h3>
              <p class="text-[1rem] text-[#333333]">
                Once listed, your tool stays live. New users will find it day after day.
              </p>
            </div>
            <div
              class="border border-[#e0e0e0] flex flex-col gap-3 rounded-lg bg-white shadow-md p-[32px] transition-all duration-300 transform hover:-translate-y-2 hover:shadow-lg"
            >
              <p class="text-[var(--primary)] text-[32px]"><i class="fa-solid fa-handshake-angle"></i></p>
              <h3 class="text-[1.5rem] text-[#555555] font-semibold">Value for Founders 👌</h3>
              <p class="text-[1rem] text-[#333333]">
                More exposure means more signups, more feedback, and better insights. It’s an
                investment in your success.
              </p>
            </div>
          </div>
        </div>
        <div class="flex flex-col gap-[24px]">
          <div class="flex flex-col gap-1">
            <h2 class="text-[2rem] text-[#333333] font-semibold">Submission Process</h2>
            <p class="border-b-4 border-[var(--primary)] w-[60px]"></p>
          </div>
          <div>
            <p class="text-[#555555] text-[1.1rem]">
              After you submit, we review your tool to ensure it meets our guidelines.
            </p>
            <p class="text-[#555555] text-[1.1rem]">
              If all looks good, your tool will be live within 2 business days.
            </p>
          </div>
        </div>
      </section>
      
      <!-- AI Submission Modal -->
      <?php get_template_part('inc/ai-submission-modal'); ?>
      
      <!-- FAQ Section -->
      <section class="flex flex-col gap-[32px] py-10 max-w-[1440px] mx-auto">
        <div class="flex flex-col gap-1">
          <h2 class="text-[2rem] text-[#333333] font-semibold">Frequently Asked Questions</h2>
          <p class="border-b-4 border-[var(--primary)] w-[60px]"></p>
        </div>
        
        <div class="grid gap-6 md:grid-cols-2">
          <!-- FAQ Item 1 -->
          <div class="border border-[#e0e0e0] rounded-lg p-6 bg-white shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-xl font-semibold text-[#333333] mb-2">What are the package options and pricing?</h3>
            <div class="text-[#555555] space-y-2">
              <p><strong>Basic Listing – $49 (one-time):</strong> Permanent directory listing with your tool's name, logo, description, and link.</p>
              <p><strong>Premium Featured – $299 (one-time):</strong> Includes Basic features plus 30-day category featuring and a "Featured" badge.</p>
              <p><strong>Ultimate Exposure – $999 (one-time):</strong> Includes all Premium benefits plus social media shoutouts (Twitter/X & LinkedIn), blog feature post, and top-list inclusion.</p>
            </div>
          </div>

          <!-- FAQ Item 2 -->
          <div class="border border-[#e0e0e0] rounded-lg p-6 bg-white shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-xl font-semibold text-[#333333] mb-2">When will my tool go live?</h3>
            <p class="text-[#555555]">
              <strong>Basic Listing:</strong> Published within 72 hours after submission.<br>
              <strong>Premium & Ultimate:</strong> Fast-tracked to be live within 24 hours.
            </p>
          </div>

          <!-- FAQ Item 3 -->
          <div class="border border-[#e0e0e0] rounded-lg p-6 bg-white shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-xl font-semibold text-[#333333] mb-2">Does my listing expire?</h3>
            <p class="text-[#555555]">No, all listings are permanent. However, Featured status lasts 30 days and social promotions are valid only once at purchase.</p>
          </div>

          <!-- FAQ Item 4 -->
          <div class="border border-[#e0e0e0] rounded-lg p-6 bg-white shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-xl font-semibold text-[#333333] mb-2">Can I update my tool info after listing?</h3>
            <p class="text-[#555555]">
              Yes—updates are allowed depending on your package:<br>
              <strong>Basic:</strong> 1 free update<br>
              <strong>Premium:</strong> up to 3 updates<br>
              <strong>Ultimate:</strong> up to 10 updates
            </p>
          </div>

          <!-- FAQ Item 5 -->
          <div class="border border-[#e0e0e0] rounded-lg p-6 bg-white shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-xl font-semibold text-[#333333] mb-2">Can I submit multiple tools or bulk list them?</h3>
            <p class="text-[#555555]">Absolutely. You're free to submit multiple tools. We also offer bulk discounts—just contact us directly to discuss options.</p>
          </div>

          <!-- FAQ Item 6 -->
          <div class="border border-[#e0e0e0] rounded-lg p-6 bg-white shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-xl font-semibold text-[#333333] mb-2">What types of tools are accepted?</h3>
            <p class="text-[#555555]">We welcome any marketing or AI tools. Submissions with explicit or inappropriate content will not be approved. All submissions undergo manual review.</p>
          </div>

          <!-- FAQ Item 7 -->
          <div class="border border-[#e0e0e0] rounded-lg p-6 bg-white shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-xl font-semibold text-[#333333] mb-2">What if my submission isn't approved?</h3>
            <p class="text-[#555555]">You'll receive a full refund if your tool is not approved. Refunds are also available for Premium/Ultimate packages if promotions haven't yet started.</p>
          </div>

          <!-- FAQ Item 8 -->
          <div class="border border-[#e0e0e0] rounded-lg p-6 bg-white shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-xl font-semibold text-[#333333] mb-2">Do you guarantee clicks, traffic, or sales?</h3>
            <p class="text-[#555555]">While we can't guarantee results, our Featured and Ultimate packages include promotional boosts—newsletter mentions, social media shoutouts, and blog features—that historically improve visibility and engagement.</p>
          </div>

          <!-- FAQ Item 9 -->
          <div class="border border-[#e0e0e0] rounded-lg p-6 bg-white shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-xl font-semibold text-[#333333] mb-2">What is the refund policy?</h3>
            <p class="text-[#555555]">Full refunds are given if our review process rejects your tool, or if you cancel your Premium/Ultimate promotion before it goes live.</p>
          </div>

          <!-- FAQ Item 10 -->
          <div class="border border-[#e0e0e0] rounded-lg p-6 bg-white shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-xl font-semibold text-[#333333] mb-2">How do I choose the right package?</h3>
            <p class="text-[#555555] mb-2"><strong>Basic</strong> is ideal for new or budget-conscious tools seeking directory visibility.</p>
            <p class="text-[#555555] mb-2"><strong>Premium</strong> is great for fast visibility and standout placement.</p>
            <p class="text-[#555555]"><strong>Ultimate</strong> offers maximum exposure through social reach and content features—perfect for tools seeking to dominate attention.</p>
          </div>

          <!-- FAQ Item 11 -->
          <div class="border border-[#e0e0e0] rounded-lg p-6 bg-white shadow-sm hover:shadow-md transition-shadow md:col-span-2">
            <h3 class="text-xl font-semibold text-[#333333] mb-2">Need help or have more questions?</h3>
            <p class="text-[#555555]">Email us anytime at <a href="mailto:hello@digitalmarketingsupermarket.com" class="text-[var(--primary)] hover:underline">hello@digitalmarketingsupermarket.com</a>—we're happy to assist!</p>
          </div>
        </div>
      </section>
    </section>

<?php get_footer(); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all submit tool buttons
    const submitButtons = document.querySelectorAll('.submit-tool-btn');
    
    // Get the modal elements
    const modal = document.getElementById('aiSubmissionModal');
    const packageTypeInput = document.getElementById('packageType');
    const packageTypeSelect = document.getElementById('package_type_select');
    
    // Add click event listeners to all submit buttons
    submitButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const packageType = this.getAttribute('data-package-type');
            
            // Set the package type in both hidden input and select
            if (packageType) {
                packageTypeInput.value = packageType;
                packageTypeSelect.value = packageType;
                
                // Show the modal
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
            }
        });
    });
    
    // Close modal function
    window.closeModal = function() {
        modal.classList.add('hidden');
        document.body.style.overflow = ''; // Re-enable scrolling
    };
    
    // Close modal when clicking outside the modal content
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
});
</script>