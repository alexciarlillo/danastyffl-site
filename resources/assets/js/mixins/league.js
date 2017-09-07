export default {
    methods: {
        getLeagueTeamName: function(league, id) {
          let team = league.franchises.franchise.filter( function(f) {
            return f.id == id;
          });

          return team[0].name;
        }
    }
}
