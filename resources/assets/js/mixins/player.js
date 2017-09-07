export default {
    methods: {
        getPlayerName: function(players, id) {
          let player = players.player.filter( function(p) {
            return p.id == id;
          });

          return player[0].name;
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
            let score = _.reduce(players, function(sum, player) {
                return parseFloat(sum) + parseFloat(player.score);
            }, 0);

            return score.toFixed(2);
        }
    }
}
