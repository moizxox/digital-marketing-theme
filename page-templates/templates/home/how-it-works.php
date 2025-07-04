<?php
$steps = [
  [
    'icon' => get_template_directory_uri() . '/images/home/discover-icon.svg',
    'title' => 'Discover The Best Tools and Courses',
    'description' => 'Browse through our growing database of 7000+ Digital Marketing Tools, 4000+ Digital Marketing Service providers and over 950 Digital Marketing Courses collected in a wide range of categories.',
  ],
  [
    'icon' => get_template_directory_uri() . '/images/home/compae-icon.svg',
    'title' => 'Compare Your Options',
    'description' => 'Browse through our growing database of 7000+ Digital Marketing Tools, 4000+ Digital Marketing Service providers and over 950 Digital Marketing Courses collected in a wide range of categories.',
  ],
  [
    'icon' => get_template_directory_uri() . '/images/home/grow-icon.svg',
    'title' => 'Grow Your Business',
    'description' => 'Browse through our growing database of 7000+ Digital Marketing Tools, 4000+ Digital Marketing Service providers and over 950 Digital Marketing Courses collected in a wide range of categories.',
  ],
];
?>

<section class="px-3 sm:px-5 py-[80px] bg-white" data-aos-delay="100">
  <div class="max-w-[1440px] mx-auto">
    <h3 class="text-center mb-6 text-[40px] font-bold">
      How it <span class="text-[var(--primary)]">Works</span>
    </h3>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 justify-between gap-6">
      <?php foreach ($steps as $index => $step): ?>
        <div class="border border-gray-200 shadow-sm rounded-lg p-4 flex flex-col justify-between hover:shadow-xl hover:border-[var(--primary)] hover:scale-[1.03] hover:bg-gray-50 transition duration-500" data-aos="zoom-in" data-aos-delay="<?php echo $index * 100 ?>">
          <div>
            <img class="mb-2" src="<?php echo $step['icon']; ?>" alt="<?php echo $step['title']; ?>">
            <h1 class="text-primary mb-2 text-lg font-bold">
              <?php echo $step['title']; ?>
            </h1>
            <p class="text-gray-600 text-sm mb-1">
              <?php echo $step['description']; ?>
            </p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
