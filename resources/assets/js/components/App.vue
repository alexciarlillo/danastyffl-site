<template>
  <div class="app">
    <NavBar @toggle-collapse="setOverflow"></NavBar>
    <div class="container mx-auto pt-12">
      <div v-if="loading" class="mt-8">
        <div class="flex justify-center my-4">
          <looping-rhombuses-spinner
            :animation-duration="2000"
            :rhombus-size="20"
            :color="'#ff6d24'"
          />
        </div>
        <div class="text-center mt-2">Loading League & Player Data</div>
      </div>
      <div v-if="league && players">
        <router-view :league="league" :players="players"></router-view>
      </div>
    </div>
  </div>
</template>

<script>
  import NavBar from './NavBar.vue';

  import { LoopingRhombusesSpinner } from 'epic-spinners';

  export default {
    name: 'App',

    data: () => ({
      loading: false,
      error: null,
      league: null,
      players: null,
    }),

    components: {NavBar, LoopingRhombusesSpinner},

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

