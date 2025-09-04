<!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="facebook-domain-verification" content="1rhd2gfv0mcu3efgmodwafa7vmksx0" />

    <?php if (get_field('cookiebot_dialog', 'options')) : ?>
        <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="96365530-2409-485b-bcc8-81ac3cb7e12e" data-blockingmode="auto" type="text/javascript"></script>

      <script>(function(c,oo,k,ie,b,o,t){b=oo.scripts[0],o=oo.createElement(k);
          o.src='https://consent.cookiebot.com/uc.js',o.id=c;o.dataset.cbid=ie;o.async=1;
          o.addEventListener('load',function(){var a=new CustomEvent('CookiebotLoaded',
            {bubbles:!0});oo.dispatchEvent(a);});
          typeof CookiebotCallback_Loaded==="function"&&CookiebotCallback_Loaded();
          b.parentNode.insertBefore(o,b);})('Cookiebot',document,'script',
          '96365530-2409-485b-bcc8-81ac3cb7e12e')</script>
    <?php endif; ?>

    <?php if ($_SERVER['HTTP_HOST'] === 'www.networkrail.co.uk') {
        echo '<meta name="google-site-verification" content="fWIlW0o7ZsWQi5QFF0YQarpNY8aOws1wZ9842zHu-oE" />';
        echo get_field('gtm_head_tag', 'options');
    }?>

    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>
    <?php if ($_SERVER['HTTP_HOST'] === 'www.networkrail.co.uk') {
        echo get_field('gtm_body_tag', 'options');
    }?>

    <?php wp_body_open(); ?>
    <?php do_action('get_header'); ?>

    <div id="ie11"></div>

    <a class="tw-sr-only focus:tw-not-sr-only active:tw-not-sr-only focus:tw-absolute focus:tw-z-60 active:tw-absolute active:tw-z-60" href="#main">
      <?php echo esc_html__('Skip to main content', 'sage'); ?>
    </a>

    <div id="app">
      <?php echo \Roots\view(\Roots\app('sage.view'), \Roots\app('sage.data'))->render(); ?>
    </div>

    <script type="text/javascript">
      /**
       * Detects browser IE
       */
      var isIE = /*@cc_on!@*/false || !!document.documentMode;

      if (isIE) {
        var ie11element = document.querySelector('#ie11');
        var appElement = document.querySelector('#app');

        // Set HTML content
        ie11element.innerHTML = '<div class="tw-p-20 tw-absolute tw-z-60 tw-bg-white tw-inset-0"><div class="tw-p-20 tw-border-2 tw-text-2xl" style="border-color: #E35100"><p class="tw-mb-8">You are using Internet Explorer. This browser is not supported.</p><p class="tw-mb-8">Change to one of these supported browsers.</p><ul class="tw-list-disc tw-pl-6"><li class="tw-pl-4 tw-underline"><a class="hover:tw-text-primary" target="_blank" href="https://www.google.com/intl/en_uk/chrome/">Chrome</a></li><li class="tw-pl-4 tw-underline"><a class="hover:tw-text-primary" target="_blank" href="https://www.mozilla.org/en-GB/firefox/new/">Firefox</a></li><li class="tw-pl-4 tw-underline"><a class="hover:tw-text-primary" target="_blank" href="https://www.microsoft.com/en-us/edge">Edge</a></li></ul></div></div>';

        appElement.style.display = 'none';
      }
    </script>

    <?php do_action('get_footer'); ?>
    <?php wp_footer(); ?>

  </body>
</html>
