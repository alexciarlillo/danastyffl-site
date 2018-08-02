const state = {
    year: null
}

const getters = {
    selectedYear: (state, getters, rootState) => {
        if (rootState.route.params.year) {
            return rootState.route.params.year;
        }

        return moment().format('YYYY');
    }
}

const actions = {
    
}

const mutations = {
    setSelectedYear(state, year) {
        state.year = year;
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}