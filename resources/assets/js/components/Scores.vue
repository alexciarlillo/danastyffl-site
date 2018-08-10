<template>
  <div>
    <Loader v-if="scores.loading" text="Loading Scoring Data"></Loader>
    <div class="scoring w-full lg:mt-4 lg:rounded lg:shadow-md overflow-hidden lg:max-w-lg lg:mx-auto" v-if="!scores.loading">
        <Matchups :matchups="scores.matchups" :league="league" :players="players"></Matchups>
    </div>
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
