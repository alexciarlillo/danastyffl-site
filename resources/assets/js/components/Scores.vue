<template>
  <div>
    <div v-if="loading">
      <div class="d-flex justify-content-center mt-4">
        <vue-loading spinner="wave"></vue-loading>
      </div>
      <h5 class="text-center">Loading Scoring Data</h5>
    </div>
    <div class="scores" v-if="scores">
        <h3 class="text-center">Week {{ week }} Scores</h3>

        <div class="row mb-2">
          <div class="col-12">
            <form class="form-inline justify-content-between">
                <div class="form-group">
                  <label class="mr-2">Matchup:</label>
                  <select class="custom-select matchup-select form-control" v-model="selected">
                    <template v-for="(matchup, index) in scores.matchup">
                      <option :value="index">
                        {{ getFranchiseName(league, matchup.franchise[0].id) }} @ {{ getFranchiseName(league, matchup.franchise[1].id) }}
                      </option>
                    </template>
                  </select>
                </div>


                <div class="form-group">
                  <label class="mr-2">Week:</label>
                  <select class="custom-select week-select" v-model="week" @change="changeWeek()">
                    <template v-for="week in weeks">
                      <option :value="week">
                        {{ week }}
                      </option>
                    </template>
                  </select>
                </div>
              </form>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <Matchup :teams="scores.matchup[selected].franchise" :league="league" :players="players"></Matchup>
          </div>
        </div>
    </div>
  </div>
</template>

<script>
    import Matchup from './Matchup.vue';
    import league from '../mixins/league.js';
    import VueLoading from 'vue-simple-loading';


    export default {
        name: 'Scores',
        props: ['league', 'players'],
        components: {Matchup, VueLoading},
        mixins: [league],

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
          this.fetchScoreData();
        },

        methods: {
          fetchScoreData: function() {
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
                  this.scores = response.data.payload.liveScoring;
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
          }
        },

        computed: {
          weeks: function() {
            return _.range(this.league.nflPoolStartWeek, this.league.nflPoolEndWeek);
          }
        },

        watch: {
          '$route': 'fetchScoreData'
        },
    }
</script>
