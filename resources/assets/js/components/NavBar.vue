<template>
  <div class="nav-wrapper">
    <nav class="flex items-center justify-between flex-wrap bg-mfl-blue p-3 fixed w-full">
      <router-link to="/standings" class="font-display flex items-center flex-no-shrink mr-6 no-underline">
        <img src="images/team-logo.png" class="h-8 w-8 mr-4">
        <div class="text-mfl-orange text-lg">DaNasty FFL</div>
      </router-link>

      <div class="block md:hidden">
        <button class="flex items-center px-3 py-2 border rounded text-grey-dark border-grey-dark hover:text-white hover:border-white" @click="toggle">
          <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
        </button>
      </div>
      
      <portal class="w-full flex-grow hidden md:flex md:items-center md:w-auto" to="nav-menu" :disabled="portalDisabled">
        <div class="text-sm md:flex-grow">
            <router-link to="/standings" class="nav-link">Standings</router-link>
            <router-link to="/scores" class="nav-link">Scores</router-link>
        </div>

        <div class="text-sm">
            <a href="/mfl" class="nav-link">MFL</a>
            <a href="/login" class="nav-link">Login</a>
        </div>
      </portal>
    </nav>

    <portal-target name="nav-menu" class="w-3/5 absolute pin-t pin-l z-10 h-screen bg-grey-lighter shadow-lg md:hidden" :class="{hidden: collapsed}"/>
  </div>
</template>

<script>
    export default {
        name: 'NavBar',
        data: () => ({
            collapsed: true,
            windowWidth: window.innerWidth
        }),
        computed: {
          portalDisabled: function () {
            return this.windowWidth > 768;
          }
        },
        methods: {
          toggle: function (e) {
            e.preventDefault();
            this.collapsed = !this.collapsed;
          },
          handleWindowResize: function(event) {
            this.windowWidth = event.currentTarget.innerWidth;
          },
        },
        beforeDestroy: function () {
          window.removeEventListener('resize', this. handleWindowResize)
        },
        mounted() {
          window.addEventListener('resize', this.handleWindowResize);
        },
    }
</script>

<style lang="scss" scoped>
  .nav-link {
    @apply block mt-2 text-grey-dark no-underline px-4 py-2 font-semibold;

    &:hover {
      @apply text-grey-darkest;
    }
  }

  @screen md {
    .nav-link {
      @apply inline-block mt-0 text-grey-dark font-semibold mr-4 no-underline;

      &:hover {
        @apply text-white;
      }
    }
  }
</style>
