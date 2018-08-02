<template>
  <div class="nav-wrapper">
    <nav class="flex items-center justify-between flex-wrap bg-mfl-blue px-2 h-12 fixed w-full z-20">
      <router-link to="/standings" class="font-display flex items-center flex-no-shrink mr-6 no-underline">
        <img src="images/team-logo.png" class="h-8 w-8 mr-4">
        <div class="text-mfl-orange text-lg">DaNasty FFL</div>
      </router-link>

      <div class="block md:hidden">
        <button class="flex items-center px-3 py-2 border rounded text-grey-dark border-grey-dark hover:text-white hover:border-white" @click="toggle">
          <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
        </button>
      </div>
      
      <portal class="flex-grow bg-grey-lightest w-full md:bg-transparent md:flex md:items-center md:w-auto" to="nav-menu" :disabled="portalDisabled">
        <div class="text-sm md:flex-grow">
            <router-link to="/standings" class="nav-link">Standings</router-link>
            <router-link to="/scores" class="nav-link">Scores</router-link>
        </div>

        <div class="text-sm">
            <portal-target name="matchup-select" class="inline-block"/>
            <YearSelector v-if="league" :history="league.history" />
            <div class="mt-6 md:mt-0 md:inline-block">
              <a href="/mfl" class="nav-link">MFL Homepage</a>
            </div>
            <!-- <a href="/login" class="nav-link">Login</a> -->
        </div>
      </portal>
    </nav>
    
    <div class="off-canvas w-full absolute pin z-20 md:hidden overlay mt-12" :class="{hidden: collapsed && !collapsing}">
      <transition
        name="slide"
        v-on:before-enter="setCollapsing(false)"
        v-on:before-leave="setCollapsing(true)"
        v-on:after-leave="setCollapsing(false)"
      >
        <div class="flex h-full" v-if="!collapsed">
          <portal-target name="nav-menu" class="w-3/5 bg-white shadow-lg"/>
          <div class="w-2/5 pt-12" @click="toggle"></div>
        </div>
      </transition>
    </div>

  </div>
</template>

<script>
import YearSelector from "./YearSelector.vue";

import { mapState, mapGetters } from 'vuex';

export default {
  name: "NavBar",
  props: ["league"],
  components: { YearSelector },
  data: () => ({
    collapsed: true,
    collapsing: false,
    windowWidth: window.innerWidth
  }),
  computed: {
    portalDisabled: function() {
      return this.windowWidth > 768;
    },
    ...mapState(['app']),
    ...mapGetters(['selectedYear'])
  },
  methods: {
    toggle: function(e) {
      e.preventDefault();
      this.collapsed = !this.collapsed;
      this.$emit("toggle-collapse", this.collapsed);
    },
    handleWindowResize: function(event) {
      this.windowWidth = event.currentTarget.innerWidth;
    },
    setCollapsing: function(collapsing) {
      this.collapsing = collapsing;
    }
  },
  watch: {
    $route(to, from) {
      if (!this.collapsed) {
        this.collapsed = true;
        this.$emit("toggle-collapse", this.collapsed);
      }
    }
  },
  beforeDestroy: function() {
    window.removeEventListener("resize", this.handleWindowResize);
  },
  mounted() {
    window.addEventListener("resize", this.handleWindowResize);
  }
};
</script>

<style lang="scss" scoped>
.overlay {
  background-color: rgba(0, 0, 0, 0.2);
}

.nav-link {
  @apply block my-1 text-grey-darker no-underline px-4 py-3 text-base;

  &:hover {
    @apply text-grey-darkest;
  }

  &.active {
    @apply bg-grey-lighter;
  }
}

@screen md {
  .nav-link {
    @apply inline-block mt-0 text-grey-light text-base no-underline;

    &:hover {
      @apply text-white;
    }

    &.active {
      @apply bg-transparent font-bold;
    }
  }
}

.slide-enter-active {
  transition: all 0.25s ease;
}

.slide-leave-active {
  transition: all 0.25s ease;
}

.slide-enter {
  transform: translateX(-100vw);
}

.slide-leave-to {
  transform: translateX(-100vw);
}
</style>
