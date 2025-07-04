<style>
    .hero-sec {
        background: url('<?php echo get_template_directory_uri(); ?>/images/home/hero-bg.gif') no-repeat center center;
        background-size: cover;
        position: relative;

        div {
            z-index: 4;
        }

        &:before {
            content: '';
            position: absolute;
            inset: 0;
            background: #0F44F34D;
            z-index: 0;
        }

    }
</style>
<section class="hero-sec px-3 sm:px-5 pt-[120px] lg:pb-[200px] pb-[120px] bg-[var(--dark-primary)] text-white mb-[180px]">
    <section class="flex flex-col gap-[60px] max-w-[1440px] mx-auto">
        <div class="flex flex-col gap-5 items-center">
            <h1 class="text-[28px] md:text-[40px] font-extrabold text-white text-center" >
                One Stop Shop For All Your <span class="text-[var(--secondary)]">AI Marketing</span> Needs
            </h1>
            <p class="text-[20px] text-center">Discover cutting-edge AI marketing tools and intelligent agent to transform your marketing strategy and drive unprecedented growth</p>
            <div class="flex flex-col sm:flex-row gap-5">
                <a href="#" class="bg-[var(--secondary)] border border-[var(--secondary)] text-[var(--primary)] py-3 px-4 rounded-md flex items-center gap-2 font-semibold"> <img src="<?php echo get_template_directory_uri(); ?>/images/icon/ai-tool-btn.svg" alt="">Explore AI Tools</a>
                <a href="#" class="bg-[#FFFFFF1A] border border-white text-white backdrop-blur-sm py-3 px-4 rounded-md flex items-center gap-2 font-semibold"> <img src="<?php echo get_template_directory_uri(); ?>/images/icon/ai-agent-btn.svg" alt="">Explore AI Tools</a>

            </div>
        </div>
        <div class="flex flex-col gap-5 py-[24px] px-4 rounded-lg bg-[var(--dark-primary)] items-center max-w-[900px] mx-auto">
            <h3 class="text-white uppercase text-[22px] font-bold">Whats the difference?</h3>
            <div class="flex flex-col sm:flex-row gap-5">
                <div class="flex flex-col gap-5 p-3 rounded-lg bg-[var(--primary)]">
                    <div class="flex items-center gap-3 justify-between">
                        <h4 class="text-[var(--secondary)] text-[20px] font-semibold">AI Marketing Tools</h4>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icon/ai-tools-yl.svg" alt="">
                    </div>
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution</p>
                </div>
                <div class="flex flex-col gap-5 p-3 rounded-lg bg-[var(--primary)]">
                    <div class="flex items-center gap-3 justify-between">
                        <h4 class="text-[var(--secondary)] text-[20px] font-semibold">AI Marketing Agents</h4>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icon/ai-agents-yl.svg" alt="">
                    </div>
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution</p>
                </div>
            </div>
        </div>
    </section>
    <section class="max-w-[1440px] mx-auto px-4 md:px-6 py-8 bg-[var(--primary)] rounded-xl flex flex-col gap-6 max-lg:mt-[55px] lg:absolute lg:bottom-[-120px] lg:left-1/2 lg:-translate-x-1/2 lg:w-full  ">
    <!-- Form -->
    <form class="flex flex-col gap-5 bg-[#A3F8FF1A] p-6 rounded-lg" id="searchForm">
        <!-- Search Input & Button -->
        <div class="flex flex-col sm:flex-row gap-3">
            <input  type="text" placeholder="e.g. AI Marketing Tools or Agents"
                class="w-full p-3 border border-gray-200 rounded-md focus:outline-none text-[var(--primary)]" />
            <button type="submit"
                class="bg-[var(--secondary)] text-[var(--primary)] py-3 px-4 rounded-md flex items-center justify-center gap-2">
                Search
                <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.578 13.964C6.51 13.964 5.52 13.694 4.608 13.154C3.72 12.638 3.018 11.936 2.502 11.048C1.962 10.136 1.692 9.146 1.692 8.078C1.692 7.01 1.962 6.02 2.502 5.108C3.018 4.22 3.72 3.518 4.608 3.002C5.52 2.462 6.51 2.192 7.578 2.192C8.646 2.192 9.636 2.462 10.548 3.002C11.436 3.518 12.138 4.22 12.654 5.108C13.194 6.02 13.464 7.01 13.464 8.078C13.464 9.146 13.194 10.136 12.654 11.048C12.138 11.936 11.436 12.638 10.548 13.154C9.636 13.694 8.646 13.964 7.578 13.964ZM17.784 17.222L13.446 12.902C14.058 12.158 14.508 11.327 14.796 10.409C15.084 9.491 15.198 8.555 15.138 7.601C15.078 6.647 14.841 5.732 14.427 4.856C14.013 3.98 13.458 3.215 12.762 2.561C12.066 1.907 11.274 1.4 10.386 1.04C9.498 0.679996 8.568 0.499996 7.596 0.499996C6.24 0.499996 4.974 0.838997 3.798 1.517C2.622 2.195 1.695 3.122 1.017 4.298C0.339 5.474 0 6.737 0 8.087C0 9.437 0.339 10.7 1.017 11.876C1.695 13.052 2.622 13.979 3.798 14.657C4.974 15.335 6.24 15.674 7.596 15.674C8.472 15.674 9.321 15.527 10.143 15.233C10.965 14.939 11.712 14.516 12.384 13.964L16.722 18.284C16.878 18.404 17.049 18.458 17.235 18.446C17.421 18.434 17.583 18.359 17.721 18.221C17.859 18.083 17.934 17.921 17.946 17.735C17.958 17.549 17.904 17.378 17.784 17.222Z" fill="#076AFE" />
                    </svg>
            </button>
        </div>

        <!-- Radio Filters -->
        <div class="flex flex-wrap gap-4 justify-center text-white radio-div">
            <label class="flex items-center gap-2 cursor-pointer" for="tools">
                <input type="radio" name="type" id="tools" value="tool" class="accent-[#FFCC00]" checked>
                <span>Tools</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer" for="ai-tools">
                <input type="radio" name="type" id="ai-tools" value="ai-tool" class="accent-[#FFCC00]">
                <span>AI Tools</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer" for="ai-agents">
                <input type="radio" name="type" id="ai-agents" value="ai-agent" class="accent-[#FFCC00]">
                <span>AI Agents</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer" for="courses">
                <input type="radio" name="type" id="courses" value="course" class="accent-[#FFCC00]">
                <span>Courses</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer" for="services">
                <input type="radio" name="type" id="services" value="service" class="accent-[#FFCC00]">
                <span>Services</span>
            </label>
        </div>
    </form>

    <!-- Category Links -->
    <div class="flex flex-wrap justify-center gap-3">
        <?php
        $categories = [
            ['label' => 'Digital Marketing Tools', 'url' => '#digital-marketing'],
            ['label' => 'AI Tools', 'url' => '#ai-tools'],
            ['label' => 'AI Agents', 'url' => '#ai-agents'],
            ['label' => 'Web Design', 'url' => '#web-design'],
            ['label' => 'Web Dev', 'url' => '#web-dev'],
            ['label' => 'SEO Services', 'url' => '#seo-services'],
        ];
        foreach ($categories as $cat):
            ?>
           <a href="<?= esc_url($cat['url']) ?>"
           class="no-d-hover bg-white flex items-center justify-between gap-2 p-3 rounded-md text-[var(--primary)] border-[3px] border-transparent hover:border-[var(--secondary)] transition-all">
            <?= esc_html($cat['label']) ?>
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/home/arrow-btn.png" alt="">
        </a>

        <?php endforeach; ?>
    </div>
</section>

</section>
