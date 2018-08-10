const state = {
    loading: false,
    matchups: []
}

const getters = {

}

const actions = {
    fetchScores({ commit, state, getters, rootState }) {
        let url = '/api/scores/' + getters.selectedYear + '?week=' + getters.selectedWeek;

        commit('LOADING_SCORES');
        axios.get(url).then(response => {
            let matchups = response.data;
            matchups = injectFranchiseNames(matchups, rootState.league.franchises);
            matchups = injectPlayerData(matchups, rootState.players.all);
            commit('LOADED_SCORES', matchups);
        }).catch(e => {
            console.log(e);
        });
    }
}

const mutations = {
    ['LOADING_SCORES'](state) {
        state.loading = true;
    },
    ['LOADED_SCORES'](state, matchups) {
        state.matchups = matchups;
        state.loading = false;
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}

function injectPlayerData(matchups, players) {
    _.each(matchups, function (matchup) {
        _.each(matchup.franchises, function (franchise) {
            franchise.starters = [];
            franchise.bench = [];
            _.each(franchise.players, function (franchisePlayer) {
                let playerData = players[franchisePlayer.id];
                franchisePlayer.name = playerData.name;
                franchisePlayer.team = playerData.team;
                franchisePlayer.position = playerData.position.toUpperCase();

                if (franchisePlayer.status == 'starter') {
                    franchise.starters.push(franchisePlayer);
                } else {
                    franchise.bench.push(franchisePlayer);
                }
            });
        });
    });

    return matchups;
}

function injectFranchiseNames(matchups, franchises) {
    _.each(matchups, function (matchup) {
        _.each(matchup.franchises, function (franchise) {
            let team = franchises.find(function (f) {
                return f.id == franchise.id;
            });

            franchise.name = team.name;
        });
    });

    return matchups;
}