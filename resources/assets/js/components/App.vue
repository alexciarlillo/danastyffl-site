<template>
  <div class="app">
    <NavBar @toggle-collapse="setOverflow"></NavBar>
    <div class="container mx-auto pt-12">
      <div v-if="loading">
        <div class="d-flex justify-content-center mt-">
          <!-- <vue-loading spinner="wave"></vue-loading> -->
        </div>
        <h5 class="text-center">Loading League & Player Data</h5>
      </div>
      <div v-if="league && players">
        <router-view :league="league" :players="players"></router-view>
      </div>
    </div>
  </div>
</template>

<script>
  import NavBar from './NavBar.vue';

  export default {
    name: 'App',

    data: () => ({
      loading: false,
      error: null,
      league: null,
      players: null,
    }),

    components: {NavBar},

    created() {
      this.fetchLeagueData();
      this.fetchPlayerData();
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
            if(response.data.success) {
              this.league = response.data.payload.league;
            } else {
              this.error = response.data.error;
            }
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
            if(response.data.success) {
              this.players = response.data.payload.players;
            } else {
              this.error = response.data.error;
            }
          })
          .catch(e => {
            console.log(e);
          });
      }
    }
  }
</script>

