const state = {
    year: null,
    week: null,
    currentWeek: 1,
    test: 1
}

const getters = {
    selectedYear: (state, getters, rootState) => {
        if (!!rootState.route.params.year) {
            return rootState.route.params.year;
        }
        return moment().format('YYYY');
    },
    selectedWeek: (state, getters, rootState) => {
        if (!!rootState.route.params.week) {
            return rootState.route.params.week;
        }

        if (state.currentWeek) {
            return state.currentWeek;
        }

        return 1;
    }
}

const actions = {
    
}

const mutations = {
    setSelectedYear(state, year) {
        state.year = year;
    },
    setCurrentWeek(state, week) {
        state.currentWeek = week;
    },
}

export default {
    state,
    getters,
    actions,
    mutations
}