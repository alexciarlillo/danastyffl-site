const state = {
    loading: false,
    all: {}
}

const getters = {

}

const actions = {
    fetchPlayers({ commit }) {
        commit('LOADING_PLAYERS');

        axios.get('/api/players')
            .then(response => {
                commit('LOADED_PLAYERS', response.data);
            })
            .catch(e => {
                console.log(e);
            });
    }
}

const mutations = {
    ['LOADING_PLAYERS'](state) {
        state.loading = true;
    },
    ['LOADED_PLAYERS'](state, players) {
        state.all = players;
        state.loading = false;
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}