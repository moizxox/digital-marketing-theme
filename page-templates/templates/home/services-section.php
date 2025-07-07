<?php

$services = [
  [
    'img' => 'https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Frame-40.png',
    'title' => 'Digital Marketing Tools',
    'desc' => 'Discover Essential Digital Marketing Tools to Help You Achieve Your Goals',
    'delay' => 100,
  ],
  [
    'img' => 'https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Group.png',
    'title' => 'Digital Marketing Courses',
    'desc' => 'Explore a Wide Range of Digital Marketing Courses and Learn From The Experts',
    'delay' => 200,
  ],
  [
    'img' => 'https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/Layer_1-1.png',
    'title' => 'Digital Marketing Services',
    'desc' => 'Find and Compare The Best Digital Marketing Service Providers to Help Your Business Grow',
    'delay' => 300,
  ],
  [
    'img' => 'https://digitalmarketingsupermarket.com/wp-content/uploads/2025/05/layer1.png',
    'title' => 'Content',
    'desc' => 'Find and Compare The Best Digital Marketing Service Providers to help Your Business Grow',
    'delay' => 400,
  ],
];

?>

<section class="px-3 sm:px-5 py-[80px] flex flex-col gap-5 max-w-[1440px] mx-auto"  data-aos-delay="100">
  <div class="services-boxes grid sm:grid-cols-2 xl:grid-cols-4 justify-between gap-5">
    <?php foreach ($services as $service): ?>
    <div class="bg-[#EAEFFF70]   basis-[25%] text-white h-[300px] flex flex-col justify-between rounded-xl p-4" data-aos="zoom-in" data-aos-delay="<?php echo $service['delay']; ?>">
      <div>
        <img class="mb-3" src="<?php echo $service['img']; ?>" alt="Digital Marketing" />
        <h2 class="text-[#1B2134] mb-1 text-[19px] font-semibold"><?php echo $service['title']; ?></h2>
        <p class="text-[#737373] mb-1">
          <?php echo $service['desc']; ?>
        </p>
      </div>

      <a href="#" class="py-3 px-3 rounded-sm flex items-center gap-2 w-fit bg-[#0F44F31A] text-[var(--primary)]">
        Explore
        <i class="fa-solid fa-chevron-right"></i>
      </a>
    </div>
    <?php endforeach; ?>
  </div>
</section>
