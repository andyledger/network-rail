<?php if (!empty(get_field('display_feedback_banner', 'options')) && get_field('display_feedback_banner', 'options') === 'yes') : ?>

<div class="feedback-banner-container <?php echo !empty($centered)? 'banner-centered' : null;?>">
  <div class="feedback-banner <?php echo !empty($centered)? 'banner-centered' : null;?>">
    <h2 class="h5"><?php echo get_field('feedback_banner_title', 'options');?></h2>
    <?php echo get_field('feedback_banner_content', 'options');?>
  </div>
</div>

<?php endif;?>
