<template>
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
                  <select class="custom-select week-select" v-model="week">
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
</template>

<script>
    import Matchup from './Matchup.vue';
    import league from '../mixins/league.js';

    export default {
        name: 'Scores',
        props: ['league', 'players'],
        components: {Matchup},
        mixins: [league],
        data: () => ({
          scores: false,
          selected: 0,
          week: 1
        }),

        created() {
          axios.get('/api/scores')
          .then(response => {
            this.scores = response.data.liveScoring;
          })
          .catch(e => {
            console.log(e);
          });
        },

        computed: {
          weeks: function() {
            return _.range(this.league.nflPoolStartWeek, this.league.nflPoolEndWeek);
          }
        }
    }
</script>
