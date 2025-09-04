<?php
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$canonical_link = str_replace('/amp/', '/', $actual_link);
?>

<!doctype html>
<html amp>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1">
  <link rel="canonical" href="<?php echo $canonical_link ?>">
  <?php do_action( 'amp_post_template_head', $this ); ?>
  <style amp-custom>
    <?php $this->load_parts( [ 'style' ] ); ?>
    <?php do_action( 'amp_post_template_css', $this ); ?>
  </style>

  <style type="text/css">
    .consentPopup {
      background: white;
      padding: 1rem;
      border: 1px solid black;
    }
  </style>

  <script async custom-element="amp-consent" src="https://cdn.ampproject.org/v0/amp-consent-0.1.js"></script>

  <amp-consent 
    id="myUserConsent"
    layout="nodisplay"
  >
    <script type="application/json">
      {
        "consents": {
          "consent1": {
            "checkConsentHref": "https://amp.dev/documentation/examples/api/get-consent-server-side",
            "promptUI": "consentDialog"
          }
        },
        "postPromptUI": "post-consent-ui"
      }
    </script>

    <div id="consentDialog" class="popupOverlay">
      <div class="consentPopup">
        <button 
          on="tap:myUserConsent.dismiss"
          class="ampstart-btn ampstart-btn-secondary"
        >Close</button>

        <h2>Headline</h2>

        <p>If the server says you have not made a consent decision, we require you to make a choice.</p>

        <button 
          on="tap:myUserConsent.accept"
          class="ampstart-btn ampstart-btn-secondary caps mx1"
        >Accept</button>

        <button 
          on="tap:myUserConsent.reject"
          class="ampstart-btn ampstart-btn-secondary caps"
        >Reject</button>
      </div>
    </div>
  </amp-consent>
</head>

<body class="<?php echo esc_attr( $this->get( 'body_class' ) ); ?>">
<?php do_action( 'amp_post_template_body_open', $this ); ?>

<?php $this->load_parts( array( 'header' ) ); ?>

<article class="amp-wp-article">
  <header class="amp-wp-article-header">
    <h1 class="amp-wp-title"><?php echo esc_html( $this->get( 'post_title' ) ); ?>(amp)</h1>

    <div class="amp-wp-meta amp-wp-posted-on">
      <time class="updated" datetime="<?php echo get_post_time('c', true) ?>"><?php echo get_the_date()?></time>
    </div>
  </header>

  <?php $this->load_parts( array( 'featured-image' ) ); ?>

  <div class="amp-wp-article-content">
    <?php echo $this->get( 'post_amp_content' ); // WPCS: XSS ok. Handled in AMP_Content::transform(). ?>
  </div>

  <footer class="amp-wp-article-footer">
    <?php $this->load_parts( apply_filters( 'amp_post_article_footer_meta', array( 'meta-taxonomy', 'meta-comments-link' ) ) ); ?>
  </footer>
</article>

<footer class="amp-wp-footer">
  <div>
    <h2><?php echo esc_html( wptexturize( $this->get( 'blog_name' ) ) ); ?></h2>

    <a href="#top" class="back-to-top"><?php esc_html_e( 'Back to top', 'amp' ); ?></a>
  </div>
</footer>

<?php
$this->load_parts( array( 'html-end' ) );
?>
