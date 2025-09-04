<!doctype html>
<html amp>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1">

  <?php do_action( 'amp_post_template_head', $this ); ?>

  <style amp-custom>
    <?php do_action( 'amp_post_template_css', $this ); ?>
  </style>

  <script async custom-element="amp-consent" src="https://cdn.ampproject.org/v0/amp-consent-0.1.js"></script>

  <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>

  <amp-analytics 
    type="googleanalytics" 
    data-credentials="include" 
    data-block-on-consent
  >
    <script type="application/json">
    {
      "vars": {
          "account": "UA-12944685-19"
      },
      "triggers": {
          "trackPageview": {
              "on": "visible",
              "request": "pageview"
          }
      }
    }
    </script>
  </amp-analytics>

  <amp-consent id="myUserConsent" layout="nodisplay">
    <script type="application/json">
      {
        "consentInstanceId": "my-consent",
        "consentRequired": true,
        "promptUI": "consent-ui-dialog"
      }
    </script>

    <div id="consent-ui-dialog" class="tw-p-6 tw-border-2 tw-bg-white">
      <div class="tw-mb-4 tw-flex tw-justify-between tw-items-center">
        <h2 class="tw-text-xl tw-font-bold">We use cookies on AMP</h2>

        <button 
          on="tap:myUserConsent.dismiss"
          class="tw-px-6 tw-py-2 | tw-bg-secondary tw-rounded | tw-text-white tw-font-bold"
        >Close</button>         
      </div>

      <p class="tw-text-lg tw-mb-4">We use cookies to provide visitors with the best possible experience on AMP. We and our selected partners would like to use cookies or similar technologies to collect information about you for analytics, functional and marketing purposes.</p>

      <p class="tw-text-lg tw-mb-4">These settings apply to AMP only. You may be asked to set cookies preferences again when you visit non-AMP Network Rail pages.</p>

      <a class="tw-block tw-mb-4 | tw-text-secondary tw-font-bold tw-text-xl tw-underline" href="<?php echo esc_url( $this->get( 'home_url' ) ).'/footer/cookie-policy/'?>">Visit our cookie policy page</a>

      <button 
        on="tap:myUserConsent.accept"
        class="tw-w-full tw-py-3 tw-mb-4 | tw-block | tw-bg-secondary tw-rounded | tw-text-white tw-font-bold"
      >Accept</button>

      <button 
        on="tap:myUserConsent.reject"
        class="tw-w-full tw-py-3 | tw-block | tw-bg-secondary tw-rounded | tw-text-white tw-font-bold"
      >Reject</button>
    </div>
  </amp-consent>
</head>