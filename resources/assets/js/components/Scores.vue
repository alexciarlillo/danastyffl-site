<template>
  <div>
    <Loader v-if="scores.matchups.length === 0" text="Loading Scoring Data"></Loader>
    <Matchups v-if="scores.matchups.length > 0" :matchups="scores.matchups" :league="league" :players="players"></Matchups>
  </div>
</template>

<script>
    import Matchups from './Matchups.vue';
    import Loader from './Loader.vue';

    import { mapMutations, mapGetters, mapActions, mapState } from 'vuex';

    export default {
        name: 'Scores',
        props: ['league', 'players', 'week'],
        components: {Matchups, Loader},

        data() {
          return {
            intervalId: null
          }
        },

        created() {
          this.setupScoringUpdates();
          this.fetchScores();
        },

        methods: {
          routeChanged: function() {
            this.setupScoringUpdates();
            this.fetchScores();
          },
          setupScoringUpdates: function() {
            if (this.intervalId) {
              clearInterval(this.intervalId);
              this.intervalId = null;
            }

            if (this.viewingCurrent) {
              this.intervalId = setInterval(() => {
                this.fetchScores(); 
              }, 10000);
            }            
          },
          ...mapGetters(['selectedYear']),
          ...mapActions(['fetchScores'])
        },

        computed: {
          weeks: function() {
            return _.range(this.league.nflPoolStartWeek, this.league.nflPoolEndWeek);
          },
          viewingCurrent: function() {
            return true;
            return this.route.path === '/scores'
                  || this.route.path === '/scores/' + moment().format('YYYY')
                  || this.route.path === '/scores/' + moment().format('YYYY') + '/' + this.currentWeek;
          },
          ...mapState({
            scores: state => state.scores,
            route: state => state.route,
            currentWeek: state => state.app.currentWeek,
          })
        },

        beforeDestroy() {
          if (this.intervalId) {
            clearInterval(this.intervalId);
          }
        },

        watch: {
          '$route': 'routeChanged',
        },
    }
</script>
