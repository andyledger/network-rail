@if(is_page('blocks-reference-guide'))
  <div class="tw-text-3xl tw-font-bold tw-mb-6">Blocks</div>

  <ul class="tw-text-lg tw-mb-4">
    @foreach ($menu = wp_get_nav_menu_items('blocks-reference-guide') as $item)
      <li>
        <a class="hover:tw-text-hyperlinks hover:tw-underline" href="{{ $item->url }}">{{ $item->title }}</a>
      </li>
    @endforeach
  </ul>
@endif

@if (is_page() && !is_page('blocks-reference-guide'))
  <h2 class="h4 w-mb-6 tw-block">
    {!! $child_pages_title !!}
  </h2>

  {!! $child_pages !!}
@endif

@if(is_singular('post'))
  {!! $menu_categories_child_of_stories !!}

  @php(dynamic_sidebar('sidebar-primary'))
@endif

@if(is_singular('blog'))
  {!! $menu_blog_categories !!}

  @php(dynamic_sidebar('sidebar-primary'))
@endif

{{-- empty sidebar on root pages --}}
<div></div>
