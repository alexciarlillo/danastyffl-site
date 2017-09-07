export default {
    methods: {
        getPlayerName: function(players, id) {
          let player = players.player.filter( function(p) {
            return p.id == id;
          });

          return player[0].name;
        }
    }
}
