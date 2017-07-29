<template>
  <div class="standings">
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
            <td>{{ getTeamName(team.id) }}</td>
            <td>{{ team.h2hw }}-{{ team.h2hl }}-{{ team.h2ht }}</td>
            <td>{{ team.h2hw / (team.h2hw + team.h2hl) }}
            <td>{{ team.pf }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
    export default {
        name: 'Standings',

        props: ['league'],

        data: () => ({
          standings: false,
        }),

        created() {
          axios.get('/api/standings')
          .then(response => {
            this.standings = response.data.leagueStandings;
          })
          .catch(e => {
            console.log(e);
          });
        },

        methods: {
          getTeamName: function(id) {
            let team = this.league.franchises.franchise.filter( function(f) {
              return f.id == id;
            });

            return team[0].name;
          }
        }
    }
</script>
