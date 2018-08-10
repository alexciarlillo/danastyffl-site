<template>
  <div class="app">
    <NavBar @toggle-collapse="setOverflow"></NavBar>
    <div class="container mx-auto pt-12">
      <Loader v-if="loading" text="Loading League & Player Data"></Loader>
      <div v-if="!league.loading && !players.loading">
        <router-view :league="league" :players="players"></router-view>
      </div>
    </div>
  </div>
</template>

<script>
  import NavBar from './NavBar.vue';
  import Loader from './Loader.vue';

  import  { mapState, mapActions } from 'vuex';

  export default {
    name: 'App',

    data: () => ({
      loading: false,
      error: null
    }),

    components: {NavBar, Loader},

    created() {
      this.fetchLeague();
      this.fetchPlayers();
      this.fetchCurrentWeek();
    },

    methods: {
      setOverflow: function(collapsed) {
        if (collapsed) {
          document.body.classList.remove('overflow-hidden');
        } else {
          document.body.classList.add('overflow-hidden');
        }
      },
      ...mapActions(['fetchLeague', 'fetchPlayers', 'fetchCurrentWeek'])
    },

    computed: mapState({
      league: state => state.league,
      players: state => state.players
    }),
  }
</script>

