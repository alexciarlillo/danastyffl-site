<template>
  <div>
    <Loader v-if="loading" text="Loading Scoring Data"></Loader>
    <div class="scoring w-full lg:mt-4 lg:rounded lg:shadow-md overflow-hidden lg:max-w-lg lg:mx-auto" v-if="matchups">
        <Matchups :matchups="matchups" :league="league" :players="players"></Matchups>
    </div>
  </div>
</template>

<script>
    import Matchups from './Matchups.vue';
    import Loader from './Loader.vue';
    import league from '../mixins/league.js';
    import player from '../mixins/player.js';

    export default {
        name: 'Scores',
        props: ['league', 'players'],
        components: {Matchups, Loader},
        mixins: [league, player],

        data: () => ({
          matchups: null,
          selected: 0,
          error: null,
          loading: false,
          year: null,
          week: null
        }),

        created() {
          if (this.$route.params.week) {
            this.week = this.$route.params.week;
          }
          this.year = this.$route.params.year;
          this.loadInitialData();

          setInterval(function () {
            this.fetchScoreData();
          }.bind(this), 30000);
        },

        methods: {
          loadInitialData: function() {
            this.error = this.matchups = null;
            this.loading = true;
            let weekString = '';
            if(this.week) {
              weekString = `?week=${this.week}`;
            }

            axios.get('/api/scores/' + this.year + weekString)
              .then(response => {
                this.loading = false;
                this.matchups = this.injectPlayerData(response.data, this.players);
              })
              .catch(e => {
                console.log(e);
              });
          },

          fetchScoreData: function() {
            let weekString = '';
            if(this.week) {
              weekString = `?week=${this.week}`;
            }

            axios.get('/api/scores/' + this.year + weekString)
              .then(response => {
                this.matchups = this.injectPlayerData(response.data, this.players);
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
