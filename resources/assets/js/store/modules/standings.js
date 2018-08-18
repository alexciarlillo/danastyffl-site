const state = {
    loading: false,
    franchises: []
}

const getters = {

}

const actions = {
    fetchStandings({ commit, state, getters, rootState }) {
        let url = '/api/standings/' + getters.selectedYear;

        commit('LOADING_STANDINGS');
        axios.get(url).then(response => {
            let franchises = response.data;
            franchises = injectFranchiseNames(franchises, rootState.league.franchises);
            commit('LOADED_STANDINGS', franchises);
        }).catch(e => {
            console.log(e);
        });
    }
}

const mutations = {
    ['LOADING_STANDINGS'](state) {
        state.loading = true;
    },
    ['LOADED_STANDINGS'](state, franchises) {
        state.franchises = franchises;
        state.loading = false;
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}

function injectFranchiseNames(franchises, rootFranchises) {
    _.each(franchises, function (franchise) {
        let team = rootFranchises.find(function (f) {
            return f.id == franchise.id;
        });

        franchise.name = team.name;
    });

    return franchises;
}