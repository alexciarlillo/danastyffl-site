const state = {
    loading: false,
    info: {},
    franchises: [],
}

const getters = {
    getFranchise: (state) => (id) => {
        let f = state.franchises.find(franchise => franchise.id === id);
        console.log(f);
        return f;
    }
}

const actions = {
    fetchLeague({ commit }) {
        commit('LOADING_LEAGUE');
        axios.get('/api/league').then(response => {
            commit('LOADED_LEAGUE', response.data);
        }).catch(e => {
            console.log(e);
        });
    }
}

const mutations = {
    ['LOADING_LEAGUE'](state) {
        state.loading = true;
    },
    ['LOADED_LEAGUE'](state, league) {
        let { franchises, ...info} = league;
        state.franchises = franchises;
        state.info = info;
        state.loading = false;
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}