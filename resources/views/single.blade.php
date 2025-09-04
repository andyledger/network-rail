@extends('layouts.app')

@section('pre-content')

  @php
    $categories = wp_get_post_terms(get_the_ID(), 'category', [
        'exclude' => 1
    ]);

    $primaryCategory = null;

    if (!empty($categories)) {
      foreach ($categories as $key => $category) {
        if (get_post_meta(get_the_ID(), '_yoast_wpseo_primary_category',true) == $category->term_id ) {
          $primaryCategory = $category;
          unset($categories[$key]);
          break;
        }
        $primaryCategory = $category;
      }

      $categories = array_slice($categories, 0, 2);
    }
  @endphp

  <div class="tw-bg-efedeb">
    @include('partials.breadcrumbs', ['noBorder' => true])
  </div>

  <div class="tw-bg-brand-blue">
    <div class="stories-wrapper">
      <div class="tw-flex tw-flex-col-reverse md:tw-grid tw-grid-cols-2">
        <div class="tw-col-span-2 md:tw-col-span-1 story-image tw-px-16px md:tw-px-0 tw-bg-brand-blue tw-relative tw-overflow-hidden min-h-[400px]">
          {{ the_post_thumbnail('story_large', ['alt' => get_the_title(), 'class' => 'tw-w-full', 'loading' => 'lazy']) }}
        </div>
        <div class="tw-col-span-2 md:tw-col-span-1 tw-grid tw-grid-cols-1 ">

          <div class="tw-bg-brand-blue md:tw-bg-brand-orange tw-px-16px md:tw-px-48px md:tw-pb-32px tw-pt-6 lg:tw-pt-52px tw-col-span-1">
            <h1 class="tw-text-3xl lg:tw-text-48px lg:tw-leading-56px tw-font-bold tw-text-white">{{ the_title() }}</h1>

            <div class="tw-mt-12px md:tw-mt-24px tw-space-y-2">
              @if (!empty($primaryCategory))
                <a href="/stories?cat={{ $primaryCategory->slug }}" class="tw-hidden md:tw-inline-flex tw-bg-brand-orange-medium tw-px-2 tw-py-0.5 tw-inline-flex tw-rounded tw-mt-12px md:tw-mt-24px">
                  {{ html_entity_decode($primaryCategory->name) }}
                </a>
              @endif

              @if (!empty($categories))
                @foreach ($categories as $category)
                  <a href="/stories?cat={{ $category->slug }}" class="tw-hidden md:tw-inline-flex tw-bg-brand-orange-medium tw-px-2 tw-py-0.5 tw-inline-flex tw-rounded">
                    {{ html_entity_decode($category->name) }}
                  </a>
                @endforeach
              @endif
            </div>
          </div>

          <div class="tw-bg-brand-blue tw-px-16px md:tw-px-48px tw-pb-24px md:tw-pb-8 md:tw-pt-6 lg:tw-pt-32px tw-col-span-1 tw-text-white tw-flex md:tw-block tw-justify-between tw-items-end">

            <div class="tw-mr-3 md:tw-mr-0">
              <div class="tw-text-lg tw-mb-5 tw-opacity-90 md:tw-opacity-100"><span class="tw-hidden md:tw-inline">Published</span> <span class="md:tw-font-bold">{{ get_the_date('j F Y') }}</span>
                <span class="tw-hidden md:tw-inline">|</span>
                <span class="tw-hidden md:tw-inline">Average read time</span><br class="md:tw-hidden">
                <span class="md:tw-font-bold">{{ get_post_meta(get_the_ID(), '_yoast_wpseo_estimated-reading-time-minutes', true) }} min read</span>
              </div>

              @if (!empty($primaryCategory))
                <a href="/stories?cat={{ $primaryCategory->slug }}" class="md:tw-hidden tw-text-black tw-bg-brand-orange-medium tw-px-2 tw-py-0.5 tw-inline-flex tw-rounded tw-mb-1 md:tw-mb-0">
                  {{ $primaryCategory->name }}
                </a>
              @endif

              @if (!empty($categories))
                @foreach ($categories as $category)
                  <a href="/stories?cat={{ $category->slug }}" class="md:tw-hidden tw-text-black tw-bg-brand-orange-medium tw-px-2 tw-py-0.5 tw-inline-flex tw-rounded tw-mb-1 md:tw-mb-0">
                    {{ $category->name }}
                  </a>
                @endforeach
              @endif
            </div>

            <a href="#share" class="tw-inline-flex md:tw-hidden tw-border tw-border-white tw-rounded-4px tw-px-24px tw-h-48px tw-items-center tw-text-center tw-text-lg">Share</a>

            <div class="tw-hidden md:tw-flex tw-items-center">
              <div class="tw-font-bold tw-text-lg tw-mr-5">Share</div>
              <ul class="tw-flex tw-space-x-16px">
                <li class="tw-h-32px">
                  <a href="https://www.facebook.com/sharer/sharer.php?u={{ the_permalink() }}" target="_blank" rel="noopener noreferrer" class="tw-block tw-w-32px tw-h-32px">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Share on Facebook">
                      <path d="M32 16.0401C32 7.18596 24.832 0 16 0C7.168 0 0 7.18596 0 16.0401C0 23.8035 5.504 30.2677 12.8 31.7594V20.8521H9.6V16.0401H12.8V12.0301C12.8 8.93434 15.312 6.41604 18.4 6.41604H22.4V11.2281H19.2C18.32 11.2281 17.6 11.9499 17.6 12.8321V16.0401H22.4V20.8521H17.6V32C25.68 31.198 32 24.3649 32 16.0401Z" fill="currentColor"/>
                    </svg>
                  </a>
                </li>
                <li class="tw-h-32px">
                  <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ the_permalink() }}" target="_blank" rel="noopener noreferrer" class="tw-block w-32px h-32px">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <g clip-path="url(#clip0_828_61)">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16 32C24.8366 32 32 24.8366 32 16C32 7.16344 24.8366 0 16 0C7.16344 0 0 7.16344 0 16C0 24.8366 7.16344 32 16 32ZM16.9144 13.5752H13.9432V24H17.1432V18.9496C17.1432 17.2576 17.7712 16.1816 19.2824 16.1816C20.372 16.1816 20.8 17.18 20.8 18.9504V24H24V18.2424C24 15.1336 23.2496 13.4392 20.0888 13.4392C18.44 13.4392 17.3424 14.204 16.9144 15.0552V13.5752ZM11.656 13.4392V23.864H8.456V13.4392H11.656ZM11.9579 10.8213C12.0614 10.5738 12.1145 10.3082 12.1144 10.04C12.1144 9.4984 11.8976 8.98 11.512 8.5976C11.1256 8.2152 10.6024 8 10.0568 8C9.51216 7.99976 8.98952 8.21456 8.6024 8.5976C8.216 8.98 8 9.4984 8 10.04C8.00048 10.3082 8.05384 10.5736 8.15704 10.8211C8.26032 11.0686 8.41136 11.2934 8.6016 11.4824C8.98904 11.865 9.51152 12.0796 10.056 12.08C10.6014 12.0814 11.1251 11.8661 11.512 11.4816C11.703 11.2932 11.8545 11.0687 11.9579 10.8213Z" fill="currentColor"/>
                      </g>
                      <defs>
                        <clipPath id="clip0_828_61">
                          <rect width="32" height="32" fill="currentColor"/>
                        </clipPath>
                      </defs>
                    </svg>
                  </a>
                </li>
                <li class="tw-h-32px">
                  <a href="https://twitter.com/intent/tweet?text={{ the_permalink() }}" target="_blank" rel="noopener noreferrer" class="tw-block w-32px h-32px">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <g clip-path="url(#clip0_828_63)">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16 32C24.8375 32 32 24.8366 32 16C32 7.16348 24.8375 0 16 0C7.1625 0 0 7.16348 0 16C0 24.8366 7.1625 32 16 32ZM23.7875 8L17.7125 14.7748L24.3218 24H19.4625L15.0094 17.7875L9.44064 24H8L14.3718 16.8961L8 8H12.8594L17.075 13.8822L22.3469 8H23.7875ZM15.0969 16.0881L15.7406 16.9736L20.1375 23.008H22.35L16.9594 15.6137L16.3156 14.7279L12.1687 9.04H9.95936L15.0969 16.0881Z" fill="currentColor"/>
                      </g>
                      <defs>
                        <clipPath id="clip0_828_63">
                          <rect width="32" height="32" fill="currentColor"/>
                        </clipPath>
                      </defs>
                    </svg>
                  </a>
                </li>
                <li class="tw-h-32px">
                  <copy-link url="{{ the_permalink() }}" colour="#ffffff"></copy-link>
                </li>
              </ul>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('main')
  <section class="tw-w-full">
    <article class="container-small tw-mt-24px md:tw-mt-48px tw-mb-37px md:tw-mb-32 tw-mx-auto">

      <div class="story-content">
        @php the_content() @endphp
      </div>

      <div class="tw-flex tw-items-center tw-mt-14" id="share">
        <div class="share tw-font-bold tw-text-lg tw-mr-5 tw-bg-brand-green-blue tw-text-white tw-rounded tw-px-16px tw-py-3">Share</div>
        <ul class="tw-flex tw-space-x-16px tw-text-green-blue">
          <li class="tw-h-32px">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ the_permalink() }}" target="_blank" rel="noopener noreferrer" class="tw-block tw-w-32px tw-h-32px">
              <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Share on Facebook">
                <path d="M32 16.0401C32 7.18596 24.832 0 16 0C7.168 0 0 7.18596 0 16.0401C0 23.8035 5.504 30.2677 12.8 31.7594V20.8521H9.6V16.0401H12.8V12.0301C12.8 8.93434 15.312 6.41604 18.4 6.41604H22.4V11.2281H19.2C18.32 11.2281 17.6 11.9499 17.6 12.8321V16.0401H22.4V20.8521H17.6V32C25.68 31.198 32 24.3649 32 16.0401Z" fill="#003F59"/>
              </svg>
            </a>
          </li>
          <li class="tw-h-32px">
            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ the_permalink() }}" target="_blank" rel="noopener noreferrer" class="tw-block w-32px h-32px">
              <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_828_61)">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M16 32C24.8366 32 32 24.8366 32 16C32 7.16344 24.8366 0 16 0C7.16344 0 0 7.16344 0 16C0 24.8366 7.16344 32 16 32ZM16.9144 13.5752H13.9432V24H17.1432V18.9496C17.1432 17.2576 17.7712 16.1816 19.2824 16.1816C20.372 16.1816 20.8 17.18 20.8 18.9504V24H24V18.2424C24 15.1336 23.2496 13.4392 20.0888 13.4392C18.44 13.4392 17.3424 14.204 16.9144 15.0552V13.5752ZM11.656 13.4392V23.864H8.456V13.4392H11.656ZM11.9579 10.8213C12.0614 10.5738 12.1145 10.3082 12.1144 10.04C12.1144 9.4984 11.8976 8.98 11.512 8.5976C11.1256 8.2152 10.6024 8 10.0568 8C9.51216 7.99976 8.98952 8.21456 8.6024 8.5976C8.216 8.98 8 9.4984 8 10.04C8.00048 10.3082 8.05384 10.5736 8.15704 10.8211C8.26032 11.0686 8.41136 11.2934 8.6016 11.4824C8.98904 11.865 9.51152 12.0796 10.056 12.08C10.6014 12.0814 11.1251 11.8661 11.512 11.4816C11.703 11.2932 11.8545 11.0687 11.9579 10.8213Z" fill="#003F59"/>
                </g>
                <defs>
                  <clipPath id="clip0_828_61">
                    <rect width="32" height="32" fill="#003F59"/>
                  </clipPath>
                </defs>
              </svg>
            </a>
          </li>
          <li class="tw-h-32px">
            <a href="https://twitter.com/intent/tweet?text={{ the_permalink() }}" target="_blank" rel="noopener noreferrer" class="tw-block w-32px h-32px">
              <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_828_63)">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M16 32C24.8375 32 32 24.8366 32 16C32 7.16348 24.8375 0 16 0C7.1625 0 0 7.16348 0 16C0 24.8366 7.1625 32 16 32ZM23.7875 8L17.7125 14.7748L24.3218 24H19.4625L15.0094 17.7875L9.44064 24H8L14.3718 16.8961L8 8H12.8594L17.075 13.8822L22.3469 8H23.7875ZM15.0969 16.0881L15.7406 16.9736L20.1375 23.008H22.35L16.9594 15.6137L16.3156 14.7279L12.1687 9.04H9.95936L15.0969 16.0881Z" fill="#003F59"/>
                </g>
                <defs>
                  <clipPath id="clip0_828_63">
                    <rect width="32" height="32" fill="#003F59"/>
                  </clipPath>
                </defs>
              </svg>
            </a>
          </li>
          <li class="tw-h-32px">
            <copy-link url="{{ the_permalink() }}" colour="#003F59"></copy-link>
          </li>
        </ul>
      </div>

      @include('components.feedback-banner', ['centered' => false])
    </article>

    @if ($stories->have_posts())
      <div class="tw-border-t tw-border-gray-border tw-pt-48px md:tw-pt-64px tw-pb-28">
        <h2 class="tw-text-3xl lg:tw-text-5xl md:tw-leading-tight tw-font-bold tw-mb-48px md:tw-mb-64px">You might also like</h2>

        <div class="tw-grid tw-grid-cols-12 md:tw-gap-x-28px tw-gap-y-40px md:tw-gap-y-64px">
            @while ($stories->have_posts())
              @php
                $stories->the_post();
              @endphp
              <div
                 class="tw-block tw-bg-white tw-col-span-12 md:tw-col-span-6 lg:tw-col-span-3 story-card">
                <div class="tw-bg-black story-card__image">
                  <?php the_post_thumbnail('story_small', ['class' => 'tw-aspect-video', 'alt' => get_the_title(), 'loading' => 'lazy']); ?>
                </div>
                <div class="tw-py-6 tw-px-6 md:tw-px-8">
                  <h3
                    class="tw-text-lg tw-font-bold tw-mb-2 tw-mb-2 h5">
                    <a href="{{ the_permalink() }}" class="story-card__link">{{ the_title() }}</a></h3>
                  <div class="tw-opacity-60 tw-font-bold tw-mb-3 story-time">{{ get_the_date('j F Y') }} | {{ get_post_meta(get_the_ID(), '_yoast_wpseo_estimated-reading-time-minutes', true) }} min read</div>
                </div>
              </div>
            @endwhile
        </div>
      </div>
    @endif

  </section>
@endsection
