<template>
  <div class="app">
    <NavBar @toggle-collapse="setOverflow"></NavBar>
    <div class="pt-12">
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
  import Echo from 'laravel-echo';
  import Pusher from 'pusher-js';



  import  { mapState, mapActions } from 'vuex';

  export default {
    name: 'App',

    data: () => ({
      loading: false,
      error: null,
      echo: null
    }),

    components: {NavBar, Loader},

    created() {
      this.fetchLeague();
      this.fetchPlayers();
      this.fetchCurrentWeek();
    },

    mounted() {
      // this.connect();
      this.bind();
    },

    methods: {
      setOverflow: function(collapsed) {
        if (collapsed) {
          document.body.classList.remove('overflow-hidden');
        } else {
          document.body.classList.add('overflow-hidden');
        }
      },
      connect: function() {
        // if(!this.echo) {
        //   this.echo = new Echo({
        //       broadcaster: 'pusher',
        //       key: '81f8d1a71375125eb735',
        //       cluster: 'us2',
        //       encrypted: true
        //   });
        // }
      },
      disconnect: function() {
        // if (!this.echo) return;
        // this.echo.disconnect();
      },
      bind: function() {
        // this.echo.channel('scores')test/standings
        //   .listen('ScoresUpdate', (e) => {
        //     console.log(e.scores);
        //   });
      },
      ...mapActions(['fetchLeague', 'fetchPlayers', 'fetchCurrentWeek'])
    },

    beforeDestroy() {
      // this.disconnect();
    },

    computed: mapState({
      league: state => state.league,
      players: state => state.players
    }),
  }
</script>

