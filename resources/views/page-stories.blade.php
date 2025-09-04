@extends('layouts.app')

@section('pre-content')

  <div class="tw-bg-efedeb">
    @include('partials.breadcrumbs', ['noBorder' => true])
  </div>

  <div class="tw-bg-brand-orange stories-header">
    <div class="tw-container">
      <h1 class="tw-text-3xl md:tw-text-5xl lg:tw-text-6xl tw-font-bold tw-text-white"><?php the_title();?></h1>
    </div>
  </div>

@endsection

@section('main')
  <section>
    <div class="container">

      @if ($featuredStories->have_posts() && empty($_GET['cat']))
        <div class="tw-my-40px">

          @while($featuredStories->have_posts())
            @php
              $featuredStories->the_post();
            @endphp
            <div class="tw-grid tw-grid-cols-12 featured-story">
              <div class="tw-col-span-12 md:tw-col-span-6 tw-bg-black story-featured-image">
                <?php the_post_thumbnail('story_large'); ?>
              </div>

              <div
                class="tw-col-span-12 md:tw-col-span-6 tw-bg-secondary tw-pl-48px tw-pt-64px tw-pr-40px tw-pb-24 tw-text-white">
                <div class="tw-hidden md:tw-inline-flex tw-text-2xl tw-mb-16px">Featured</div>
                <h2 class="tw-text-3xl lg:tw-text-48px md:tw-leading-56px tw-font-bold tw-mb-16px">
                  <a href="{{ the_permalink() }}" class="featured-story__link">
                  {{ the_title() }}
                  </a>
                </h2>
                <div><span class="tw-hidden md:tw-inline">Published</span> <span class="md:tw-font-bold">{{ get_the_date('j F Y') }}</span>
                  <span class="tw-hidden md:tw-inline">|</span> <span
                    class="tw-hidden md:tw-inline">Average read time</span> <span
                    class="md:tw-font-bold">{{ get_post_meta(get_the_ID(), '_yoast_wpseo_estimated-reading-time-minutes', true) }} min read</span></div>
              </div>
            </div>
          @endwhile

        </div>
      @endif

        @include('components.feedback-banner', ['centered' => true])

      <story-category
        :categories="{{ json_encode($categories) }}"
        story-category="{{ !empty($_GET['cat']) ? $_GET['cat'] : '' }}"
        site-url="{{ get_home_url() }}"
      >
      </story-category>

      <div class="tw-grid tw-grid-cols-12 md:tw-gap-x-28px tw-gap-y-40px md:tw-gap-y-64px">

        @if ($stories->have_posts())
          @while ($stories->have_posts())
            @php
              $stories->the_post();

              $categories = wp_get_post_terms(get_the_ID(), 'category', [
                  'exclude' => 1
              ]);

              $primaryCategory = null;

              if (!empty($categories)) {
                  foreach ($categories as $key => $category) {
                    if (get_post_meta(get_the_ID(), '_yoast_wpseo_primary_category',true) == $category->term_id) {
                      $primaryCategory = $category;
                      unset($categories[$key]);
                      break;
                    }

                  $primaryCategory = $category;
                }
              }

              $categories = array_slice($categories, 0, 2);
            @endphp


            <div
               class="tw-block tw-bg-white tw-col-span-12 md:tw-col-span-6 {{ $stories->current_post >= 2 ? 'lg:tw-col-span-3' :  null }} story-card">
              <div class="tw-bg-black story-card__image">
                <?php the_post_thumbnail('story_small', ['class' => 'tw-aspect-video']); ?>
              </div>

              <div class="tw-py-6 tw-px-6 {{ $stories->current_post >= 2 ? 'md:tw-pt-24px md:tw-pb-40px md:tw-px-24px' : 'md:tw-pt-24px md:tw-pb-48px md:tw-px-32px' }}">
                @if ($stories->current_post < 2 && !empty($primaryCategory))
                  <div class="tw-border tw-border-brand-orange tw-px-2 tw-rounded tw-inline-flex tw-mb-3">
                    {{ html_entity_decode($primaryCategory->name) }}
                  </div>
                @endif

                @if ($stories->current_post < 2 && !empty($categories))
                  @foreach ($categories as $category)
                    <div class="tw-border tw-border-brand-orange tw-px-2 tw-rounded tw-inline-flex tw-mb-3">
                      {{ html_entity_decode($category->name) }}
                    </div>
                  @endforeach
                @endif

                <h3
                  class="{{ $stories->current_post < 2 ? 'tw-text-xl lg:tw-text-2xl tw-font-bold' : 'tw-text-lg tw-font-bold tw-mb-2' }} h5 tw-mb-2">
                  <a href="{{ the_permalink() }}" class="story-card__link">{{ the_title() }}</a>
                </h3>
                <div class="tw-opacity-60 tw-font-bold story-time">{{ get_the_date('j F Y') }} | {{ get_post_meta(get_the_ID(), '_yoast_wpseo_estimated-reading-time-minutes', true) }} min read</div>

                @if ($stories->current_post < 2)
                  <div class="tw-mt-12px">
                    <?php the_excerpt();?>
                  </div>
                @endif

              </div>
            </div>
          @endwhile
        @endif

      </div>

      <div class="tw-flex tw-justify-end tw-my-20">
        {!! $customPagination !!}
      </div>

    </div>
  </section>
@endsection
