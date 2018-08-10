export default {
    methods: {
        getShortPlayerName: function(name) {
          let name_arr = name.split(', ');
          let last = name_arr[0];
          let first = name_arr[1].charAt(0);

          return `${first}. ${last}`;
        },

        sortPlayers: function(a, b) {
            return this.positionCompare(a.position, b.position);
        },

        positionCompare: function(pos1, pos2) {
            if(pos1 == "QB") {
                return -1;
            }

            if(pos1 == "DEF") {
                return 1;
            }

            if(pos1 == "RB") {
                if(pos2 != "QB") {
                    return -1;
                } else if(pos2 == "RB") {
                    return 0;
                } else {
                    return 1;
                }
            }

            if(pos1 == "WR") {
                if (pos2 == "DEF" || pos2 == "TE") {
                    return -1;
                } else if(pos2 == "WR") {
                    return 0;
                } else {
                    return 1;
                }
            }

            if(pos1 == "TE") {
                if(pos2 == "DEF") {
                    return -1;
                } else if(pos2 == "TE") {
                    return 0;
                } else {
                    return 1;
                }
            }

            return 0;
        }
    }
}
