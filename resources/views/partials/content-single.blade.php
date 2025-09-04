<article @php(post_class())>
  @if (has_post_thumbnail())
    <div class="tw-mb-4">
      <figure>
        <n-img
          alt="{{ App\View\Composers\App::alt_image($post) }}"
          lazy-src="{{ $on_the_fly_feature_image }}"
        ></n-img>

        @if (get_the_post_thumbnail_caption())
          <figcaption>
            {{ get_the_post_thumbnail_caption() }}
          </figcaption>
        @endif
      </figure>
    </div>
  @endif

  <div class="entry-content prose">
    @php(the_content())
  </div>
</article>
