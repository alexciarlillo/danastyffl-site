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
      
      <portal class="flex-grow bg-grey-lightest w-full hidden md:bg-transparent md:flex md:items-center md:w-auto" to="nav-menu" :disabled="portalDisabled">
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

    <div class="off-canvas w-full absolute pin z-10 md:hidden" :class="{hidden: collapsed}">
      <div class="flex h-full">
        <portal-target name="nav-menu" class="w-3/5 bg-white pt-12 shadow-lg"/>
        <div class="overlay w-2/5 pt-12" @click="toggle"></div>
      </div>
    </div>
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
            this.$emit('toggle-collapse', this.collapsed);
          },
          handleWindowResize: function(event) {
            this.windowWidth = event.currentTarget.innerWidth;
          },
        },
        watch: {
          '$route' (to, from) {
            if (!this.collapsed) {
              this.collapsed = true;
              this.$emit('toggle-collapse', this.collapsed);
              next();
            }
          }
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
  .overlay {
    background-color: rgba(0,0,0,.2);
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
</style>
