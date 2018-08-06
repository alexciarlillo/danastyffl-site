<template>
  <div class="app">
    <NavBar @toggle-collapse="setOverflow" :league="league"></NavBar>
    <div class="container mx-auto pt-12">
      <Loader v-if="loading" text="Loading League & Player Data"></Loader>
      <div v-if="league && players">
        <router-view :league="league" :players="players"></router-view>
      </div>
    </div>
  </div>
</template>

<script>
  import NavBar from './NavBar.vue';
  import Loader from './Loader.vue';

  import { mapMutations } from 'vuex';

  export default {
    name: 'App',

    data: () => ({
      loading: false,
      error: null,
      league: null,
      players: null
    }),

    components: {NavBar, Loader},

    created() {
      this.fetchLeagueData();
      this.fetchPlayerData();
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

      fetchLeagueData: function() {
        this.error = this.league = null;
        this.loading = true;

        axios.get('/api/league')
          .then(response => {
            this.loading = false;
            this.league = response.data;
          })
          .catch(e => {
            console.log(e);
          });
      },

      fetchPlayerData: function() {
        this.error = this.players = null;
        this.loading = true;

        axios.get('/api/players')
          .then(response => {
            this.loading = false;
            this.players = response.data;
          })
          .catch(e => {
            console.log(e);
          });
      },

      fetchCurrentWeek: function() {
        this.loading = true;

        axios.get('/api/currentweek')
          .then(response => {
            this.loading = false;
            this.setCurrentWeek(parseInt(response.data));
          })
          .catch(e => {
            console.log(e);
          });
      },

      ...mapMutations(['setCurrentWeek'])
    }
  }
</script>

