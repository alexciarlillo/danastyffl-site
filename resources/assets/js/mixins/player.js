export default {
    methods: {
        getPlayerName: function(players, id) {
          let player = players.player.filter( function(p) {
            return p.id == id;
          });

          return player[0].name;
        },

        getShortPlayerName: function(players, id) {
          let player = players.player.filter( function(p) {
            return p.id == id;
          });

          let name = player[0].name.split(', ');
          let last = name[0];
          let first = name[1].charAt(0);

          return `${first}. ${last}`;
        },

        getPlayerStarters: function(players) {
            return players.filter( function(p) {
                return p.status == "starter"
            });
        },

        getPlayersBench: function(players) {
            return players.filter( function(p) {
                return p.status == "nonstarter";
            })
        },

        getPlayerTeam: function(players, id) {
            let player = players.player.filter( function(p) {
                return p.id == id;
            });

            return player[0].team;
        },

        getPlayerPos: function(players, id) {
            let player = players.player.filter( function(p) {
                return p.id == id;
            });

            return player[0].position;
        },

        getScoringTotal: function(players) {
            let score = _.reduce(this.getPlayerStarters(players), function(sum, player) {
                return parseFloat(sum) + parseFloat(player.score);
            }, 0);

            return score.toFixed(2);
        }
    }
}
