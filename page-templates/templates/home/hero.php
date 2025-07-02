<style>
    
    .hero-sec{
        background: url('<?php echo get_template_directory_uri(); ?>/images/home/hero-bg.gif') no-repeat center center;
        background-size: cover;
        position: relative;
        div{
            z-index: 4;
        }
        &:before{
            content:'';
            position:absolute;
            inset:0;
            background:#0F44F34D;
    z-index: 0;
        }
        
    }
    
</style>
<section class="hero-sec px-3 sm:px-5 pt-[120px] pb-[160px]  bg-[var(--dark-primary)] text-white"  >
    <section class="flex flex-col gap-[60px] max-w-[1440px] mx-auto">
        <div class="flex flex-col gap-5 items-center">
            <h1 class="text-[40px] font-extrabold text-white text-center">
            One Stop Shop For All Your <span class="text-[var(--secondary)]">AI Marketing</span> Needs
            </h1>
            <p class="text-[20px] text-center">Discover cutting-edge AI marketing tools and intelligent agent to transform your marketing strategy and drive unprecedented growth</p>
            <div class="flex gap-5">
                <a href="#" class="bg-[var(--secondary)] border border-[var(--secondary)] text-[var(--primary)] py-3 px-4 rounded-md flex items-center gap-2 font-semibold"> <img src="<?php echo get_template_directory_uri(); ?>/images/icon/ai-tool-btn.svg" alt="">Explore AI Tools</a>
                <a href="#" class="bg-[#FFFFFF1A] border border-white text-white backdrop-blur-sm py-3 px-4 rounded-md flex items-center gap-2 font-semibold"> <img src="<?php echo get_template_directory_uri(); ?>/images/icon/ai-agent-btn.svg" alt="">Explore AI Tools</a>
                
            </div>
        </div>
        <div class="flex flex-col gap-5 py-[24px] px-4 rounded-lg bg-[var(--dark-primary)] items-center max-w-[900px] mx-auto">
            <h3 class="text-white uppercase text-[22px] font-bold">Whats the difference?</h3>
            <div class="flex flex-col md:flex-row gap-5">
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
</section>