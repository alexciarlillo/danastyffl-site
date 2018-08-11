<template>
  <div>
    <Loader v-if="scores.loading" text="Loading Scoring Data"></Loader>
    <Matchups v-if="!scores.loading" :matchups="scores.matchups" :league="league" :players="players"></Matchups>
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

        created() {
          this.loadInitialData();
        },

        methods: {
          loadInitialData: function() {
            this.fetchScores();
          },
          ...mapGetters(['selectedYear']),
          ...mapActions(['fetchScores'])
        },

        computed: {
          weeks: function() {
            return _.range(this.league.nflPoolStartWeek, this.league.nflPoolEndWeek);
          },
          ...mapState({
            scores: state => state.scores
          })
        },

        watch: {
          '$route': 'loadInitialData',
        },
    }
</script>
