import Vue from 'vue';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./components/npm', true, /\.vue$/i);
// files.keys().map(
//   key => Vue.component(
//     key.split('/').pop().split('.')[0], files(key).default)
//   );

/**
 * third party libraries
 */
import _throttle from 'lodash/throttle';
import 'sortable-tablesort/sortable.min.js';

import iFrameResizer from 'iframe-resizer/js/iframeResizer';

/**
 * third party components
 */
// import vPagination from 'vue-plain-pagination';
// Vue.component('v-pagination', vPagination);

import VueTippy, { TippyComponent } from 'vue-tippy';
Vue.use(VueTippy);
Vue.component('tippy', TippyComponent);

/**
 * plugins
 */



/**
 * Temporary helpers as dummy data
 * Delete or comment
 */
// import items from "./dummyData/main-menu.json";

/**
 * Components direct import
 */
import InlineSvg from './components/npm/InlineSvg.vue';
import NMenuButton from './components/npm/NMenuButton.vue';
import RecursiveList from './components/npm/RecursiveList.vue';

/**
 * Root Vue instance
 */
const app = new Vue({
  name: 'app',
  el: '#app',
  data: {
    isMenuOpen: false,
    hasSideBar: false,
    isSearchPhone: false,
    hasWpAdminBar: false,
    isPageScrolled: false,
    scrollPercentage: 0,
    selectedIndex: 0,
    westernRegion: null, // this is from a western region map block, should it be here?
    modalId: '',
    activeItem: null,
  },

  components: {
    InlineSvg,
    NMenuButton,
    RecursiveList,
    AlgoliaSearch: () =>
      import(
        /* webpackChunkName: "algoliaSearch" */ './components/AlgoliaSearch.vue'
      ),
    Accordion: () =>
      import(
        /* webpackChunkName: "accordion" */ './components/npm/Accordion.vue'
      ),
    AccordionItem: () =>
      import(
        /* webpackChunkName: "accordionItem" */ './components/npm/AccordionItem.vue'
      ),
    AzureBlob: () =>
      import(
        /* webpackChunkName: "azureBlob" */ './components/npm/AzureBlob.vue'
        ),
    AlgoliaSearchPage: () =>
      import(
        /* webpackChunkName: "algoliaSearchPage" */ './components/AlgoliaSearchPage.vue'
      ),
    AngliaMap: () =>
      import(/* webpackChunkName: "angliaMap" */ './components/AngliaMap.vue'),
    ApprenticeshipSchemeLocationMap: () =>
      import(
        /* webpackChunkName: "apprenticeshipSchemeLocationMap" */ './components/ApprenticeshipSchemeLocationMap.vue'
      ),
    Careers: () =>
      import(/* webpackChunkName: "careers" */ './components/Careers.vue'),
    CardLink: () =>
      import(
        /* webpackChunkName: "cardLink" */ './components/npm/CardLink.vue'
      ),
    CardImage: () =>
      import(
        /* webpackChunkName: "cardImage" */ './components/npm/CardImage.vue'
      ),
    CtaButton: () =>
      import(
        /* webpackChunkName: "ctaButton" */ './components/npm/CtaButton.vue'
      ),
    CardXs: () =>
      import(/* webpackChunkName: "cardXs" */ './components/npm/CardXs.vue'),
    Card: () =>
      import(/* webpackChunkName: "card" */ './components/npm/Card.vue'),
    CookieDeclaration: () =>
      import(
        /* webpackChunkName: "cookieDeclaration" */ './components/CookieDeclaration.vue'
      ),
    EmergencyBanner: () =>
      import(
        /* webpackChunkName: "emergencyBanner" */ './components/npm/EmergencyBanner.vue'
      ),
    Flickity: () =>
      import(
        /* webpackChunkName: "flickity" */ './components/npm/Flickity.vue'
      ),
    KentWorksMap: () =>
      import(
        /* webpackChunkName: "kentWorksMap" */ './components/KentWorksMap.vue'
      ),
    LevelCrossing: () =>
      import(
        /* webpackChunkName: "levelCrossing" */ './components/LevelCrossing.vue'
      ),
    LivingByTheRailway: () =>
      import(
        /* webpackChunkName: "livingByTheRailway" */ './components/LivingByTheRailway.vue'
      ),
    LiftsAndEscalators: () =>
      import(
        /* webpackChunkName: "liftsAndEscalators" */ './components/LiftsAndEscalators.vue'
      ),
    MainSlider: () =>
      import(
        /* webpackChunkName: "mainSlider" */ './components/MainSlider.vue'
      ),
    NSlider: () =>
      import(/* webpackChunkName: "nSlider" */ './components/npm/NSlider.vue'),
    NImg: () =>
      import(/* webpackChunkName: "nImg" */ './components/npm/NImg.vue'),
    NDropdownMenu: () =>
      import(
        /* webpackChunkName: "nDropdownMenu" */ './components/npm/NDropdownMenu.vue'
      ),
    NLandingPageHeader: () =>
      import(
        /* webpackChunkName: "nLandingPageHeader" */ './components/npm/NLandingPageHeader.vue'
      ),
    NUkMap: () =>
      import(/* webpackChunkName: "nUkMap" */ './components/npm/NUkMap.vue'),
    NUkWesternMap: () =>
      import(
        /* webpackChunkName: "nUkWesternMap" */ './components/npm/NUkWesternMap.vue'
      ),
    SafeSpaces: () =>
      import(
        /* webpackChunkName: "safeSpaces" */ './components/npm/SafeSpaces.vue'
      ),
    StationRetailDirectory: () =>
      import(
        /* webpackChunkName: "stationRetailDirectory" */ './components/StationRetailDirectory.vue'
      ),
    ThePhoneMenu: () =>
      import(
        /* webpackChunkName: "thePhoneMenu" */ './components/npm/ThePhoneMenu.vue'
      ),
    WistiaVideo: () =>
      import(
        /* webpackChunkName: "wistiaVideo" */ './components/npm/WistiaVideo.vue'
      ),
    StoryCategory: () =>
      import(
        /* webpackChunkName: "wistiaVideo" */ './components/StoryCategory.vue'
        ),
    CopyLink: () =>
      import(
        /* webpackChunkName: "wistiaVideo" */ './components/CopyLink.vue'
        ),
    BackToTop: () =>
      import(
        /* webpackChunkName: "backToTop" */ './components/BackToTop.vue'
        ),
  },

  computed: {},

  mounted() {
    document.addEventListener("keydown", (e) => {
      if (e.key == 'Escape') {
        this.updateActiveItem(null);
      }
    });

    this.fixedHeader()

  },

  methods: {
    /**
     * Main menu
     */
    openMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },

    displaySearchPhone() {
      this.isSearchPhone = !this.isSearchPhone;
    },

    hasElement(id) {
      //Attempt to get the element using document.getElementById
      let element = document.getElementById(id);

      //If it isn't "undefined" and it isn't "null", then it exists.
      return typeof element != 'undefined' && element != null;
    },

    elementHeight(id) {
      if (this.hasElement(id)) {
        return document.getElementById(id).offsetHeight;
      }

      return 0;
    },

    handleScroll: _throttle(function() {
      this.isPageScrolled = window.scrollY > 10;
      let winScroll =
        document.body.scrollTop || document.documentElement.scrollTop;
      let height =
        document.documentElement.scrollHeight -
        document.documentElement.clientHeight;
      this.scrollPercentage = (winScroll / height) * 100;
    }, 30),

    /**
     * resize Flickity in case you are loading asynchronous content
     * @return void
     */
    resizeFlickity() {
      this.$refs.flickityComponent.resize();
    },
    updateActiveItem(key) {
      this.activeItem = key;
    },
    toggleActiveItem(key) {
      this.activeItem = this.activeItem !== key ? key : null;
    },
    clearActiveItem() {
      this.activeItem = null
    },
    onMouseLeave() {
      this.activeItem = null;
    },
    fixedHeader() {

      const siteHeader = document.querySelector('.site-header')
      const headerSpacer = document.querySelector('.site-header__spacer')

      const upThreshold = 100
      const downThreshold = siteHeader.offsetHeight

      let scrollPosition = 0
      let currentScroll = 0
      let lastY = 0

      window.addEventListener('scroll', () => {

        currentScroll = window.scrollY || document.scrollTop

        if (siteHeader.classList.contains('active')) {
          return
        }

        if (document.body.getBoundingClientRect().top > scrollPosition) {

          // Going up

          // Only display the header when user scrolls past the up threshold
          if ((lastY - currentScroll) >= upThreshold) {
            siteHeader.classList.remove('site-header__hidden')
            siteHeader.classList.add('tw-fixed', 'site-header__visible')
            headerSpacer && headerSpacer.classList.remove('tw-hidden')
          }

          // Reset the header to its original unfixed state when back at the top
          if (currentScroll === undefined || currentScroll <= 0) {
            siteHeader.classList.remove('site-header__hidden', 'tw-fixed', 'site-header__visible')
            headerSpacer && headerSpacer.classList.add('tw-hidden')
          }
        } else {

          // Going down

          if (currentScroll >= downThreshold) {
            siteHeader.classList.add('site-header__hidden')
            siteHeader.classList.remove('site-header__visible')

            headerSpacer && headerSpacer.classList.add('tw-hidden')
          }

          lastY = currentScroll
        }

        scrollPosition = document.body.getBoundingClientRect().top

        if (currentScroll === undefined || currentScroll <= 0) {
          siteHeader.classList.remove('site-header__hidden', 'tw-fixed', 'site-header__visible')
          headerSpacer && headerSpacer.classList.add('tw-hidden')
        }
      })
    },

  },
});

if (document.getElementById('oracle-form')) {

  const mainContainer = document.getElementById('main')

  window.addEventListener('message', (event) => {

    if (event.data === 'PageLoaded') {
      iFrameResizer({
        checkOrigin: false,
        log: true,
        heightCalculationMethod: 'lowestElement',
      }, '#oracle-form');
    }

    if (event.data === 'RegistrationFinished') {
      window.scroll({
        top: mainContainer.offsetTop,
        left: 0,
        behavior: 'smooth',
      });
    }
  })
}

if (document.querySelector('.story-card')) {
  const storyCards = document.querySelectorAll('.story-card');

  storyCards.forEach(card => {
    const link = card.querySelector('.story-card__link');

    card.addEventListener('click', (e) => {
      location.href = link.href;
      e.preventDefault();
    })
  });
}

if (document.querySelector('.featured-story')) {
  const storyCards = document.querySelectorAll('.featured-story');

  storyCards.forEach(card => {
    const link = card.querySelector('.featured-story__link');

    card.addEventListener('click', (e) => {
      location.href = link.href;
      e.preventDefault();
    })
  });
}

if (window.Cookiebot && window.Cookiebot.hasConsented) {
  modifyCookiebotButtons();
} else {
  window.addEventListener('CookiebotLoaded', modifyCookiebotButtons);
}

function modifyCookiebotButtons() {
  const allowButton = document.getElementById('CybotCookiebotDialogBodyLevelButtonLevelOptinAllowAll');
  if (allowButton) {
    allowButton.setAttribute('aria-label', 'Allow all cookies');
  }

  const rejectButton = document.getElementById('CybotCookiebotDialogBodyButtonDecline');
  if (rejectButton) {
    rejectButton.setAttribute('aria-label', 'Reject all cookies');
  }
}
