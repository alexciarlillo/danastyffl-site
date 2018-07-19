<template>
  <div>
    <div v-if="loading" class="mt-8">
      <div class="flex justify-center my-4">
        <looping-rhombuses-spinner
          :animation-duration="2000"
          :rhombus-size="20"
          :color="'#ff6d24'"
        />
      </div>
      <div class="text-center mt-2">Loading Scoring Data</div>
    </div>
    <div class="scoring w-full lg:mt-4 lg:rounded lg:shadow-md overflow-hidden lg:max-w-lg lg:mx-auto" v-if="scores">
        <Matchups :matchups="scores.matchup" :league="league" :players="players"></Matchups>
    </div>
  </div>
</template>

<script>
    import Matchups from './Matchups.vue';
    import league from '../mixins/league.js';
    import player from '../mixins/player.js';

    import { LoopingRhombusesSpinner } from 'epic-spinners';

    export default {
        name: 'Scores',
        props: ['league', 'players'],
        components: {Matchups, LoopingRhombusesSpinner},
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
