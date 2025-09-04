<?php include(__DIR__.'/head.php'); ?>

<body class="">
  <?php include(__DIR__.'/header.php'); ?>

  <article class="prose tw-container tw-max-w-screen-lg ">
    <header class="tw-relative tw-text-black tw-py-4">
      <h1 class="tw-text-2xl tw-font-bold tw-mb-4">
        <?php echo esc_html($this->get('post_title')); ?>
      </h1>

      <div class="tw-text-base">
        <time 
          class="updated" 
          datetime="<?php echo get_post_time('c', true) ?>"
        ><?php echo get_the_date()?></time>
      </div>
    </header>

    <div class="tw-mb-4">
      <?php $this->load_parts(['featured-image']); ?>
    </div>

    <div>
      <?php echo $this->get('post_amp_content'); ?>
    </div>
  </article>

  <?php include(__DIR__.'/footer.php'); ?>

  <?php do_action('amp_post_template_footer', $this); ?>
</body>
</html>
