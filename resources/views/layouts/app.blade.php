<div class="tw-relative tw-flex tw-flex-col tw-justify-between tw-min-h-screen" id="content-app">

  @include('partials.header')

  <main id="main" class="main-content">

    @yield('pre-content')

    @hasSection('content')
    <div class="tw-container tw-flex-grow lg:tw-flex tw-py-12 {{ !empty($classes) ? $classes : null }}">
      @hasSection('sidebar')
        <aside class="tw-hidden lg:tw-block lg:tw-w-1/4 lg:tw-pr-6">
          @yield('sidebar')
        </aside>
      @endif

      @hasSection('sidebar')
        <div class="lg:tw-w-3/4 prose">
          @yield('content')
        </div>
      @else
        <div class="prose">
          @yield('content')
        </div>
      @endif
    </div>
    @endif

    @hasSection('main')
      <div class="tw-bg-offwhite">
        <div class="tw-container tw-flex-grow lg:tw-flex">
          @yield('main')
        </div>
      </div>
    @endif

    <back-to-top></back-to-top>

    @yield('pre-footer')

  </main>

  @if ($is_safespaces)
    @include('partials.safe-spaces')
  @endif

  @include('partials.footer')

</div>
