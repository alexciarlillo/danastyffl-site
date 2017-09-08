<template>
  <div>
    <div v-if="loading">
      <div class="d-flex justify-content-center mt-4">
        <vue-loading spinner="wave"></vue-loading>
      </div>
      <h5 class="text-center">Loading Standings Data</h5>
    </div>

    <div class="standings" v-if="standings">
      <h3 class="text-center">2017 Standings</h3>
      <div class="table-responsive">
        <table class="table table-sm" v-if="standings">
          <thead>
            <tr>
              <th>Team</th>
              <th>W-L-T</th>
              <th>PCT</th>
              <th>PF</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="team in standings.franchise">
              <td>{{ getFranchiseName(league, team.id) }}</td>
              <td>{{ team.h2hw }}-{{ team.h2hl }}-{{ team.h2ht }}</td>
              <td>{{ team.h2hw / (team.h2hw + team.h2hl) }}</td>
              <td>{{ team.pf }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
    import league from '../mixins/league.js';
    import VueLoading from 'vue-simple-loading';

    export default {
        name: 'Standings',

        props: ['league'],
        components: {VueLoading},
        mixins: [league],

        data: () => ({
          standings: null,
          error: null,
          loading: false
        }),

        created() {
          this.fetchStandingsData();
        },

        methods: {
          fetchStandingsData: function() {
            this.error = this.standings = null;
            this.loading = true;

            axios.get('/api/standings')
              .then(response => {
                this.loading = false;
                if(response.data.success) {
                  this.standings = response.data.payload.leagueStandings;
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
