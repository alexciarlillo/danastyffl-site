<template>
  <div>
    <div v-if="loading">
      <div class="d-flex justify-content-center mt-4">
        <!-- <vue-loading spinner="wave"></vue-loading> -->
      </div>
      <h5 class="text-center">Loading Scoring Data</h5>
    </div>
    <div class="scoring" v-if="scores">
        <Matchups :matchups="scores.matchup" :league="league" :players="players"></Matchups>
    </div>
  </div>
</template>

<script>
    import Matchups from './Matchups.vue';
    import league from '../mixins/league.js';
    import player from '../mixins/player.js';


    export default {
        name: 'Scores',
        props: ['league', 'players'],
        components: {Matchups},
        mixins: [league, player],

        data: () => ({
          scores: null,
          selected: 0,
          error: null,
          loading: false,
          week: null
        }),

        created() {
          if (this.$route.params.week) {
            this.week = this.$route.params.week;
          }
          this.loadInitialData();

          setInterval(function () {
            console.log('updating');
            this.fetchScoreData();
          }.bind(this), 30000);
        },

        methods: {
          loadInitialData: function() {
            this.error = this.scores = null;
            this.loading = true;
            let weekString = '';
            if(this.week) {
              weekString = `/${this.week}`;
            }

            axios.get('/api/scores' + weekString)
              .then(response => {
                this.loading = false;
                if(response.data.success) {
                  this.scores = this.injectPlayerData(response.data.payload.liveScoring, this.players);
                  console.log(this.scores.matchup);
                  this.week = this.scores.week;
                } else {
                  this.error = response.data.error;
                }
              })
              .catch(e => {
                console.log(e);
              });
          },

          fetchScoreData: function() {
            let weekString = '';
            if(this.week) {
              weekString = `/${this.week}`;
            }

            axios.get('/api/scores' + weekString)
              .then(response => {
                if(response.data.success) {
                  this.scores = this.injectPlayerData(response.data.payload.liveScoring, this.players);
                  this.week = this.scores.week;
                } else {
                  this.error = response.data.error;
                }
              })
              .catch(e => {
                console.log(e);
              });
          },

          changeWeek: function() {
            this.$router.push({ path: `/scores/${this.week}`});
          },


        },

        computed: {
          weeks: function() {
            return _.range(this.league.nflPoolStartWeek, this.league.nflPoolEndWeek);
          }
        },

        watch: {
          '$route': 'loadInitialData',

        },
    }
</script>
