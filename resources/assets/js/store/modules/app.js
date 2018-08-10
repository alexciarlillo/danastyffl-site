const state = {
    year: null,
    week: null,
    currentWeek: 1,
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
    fetchCurrentWeek({ commit }) {
        axios.get('/api/currentweek')
            .then(response => {
                commit('setCurrentWeek', parseInt(response.data));
            })
            .catch(e => {
                console.log(e);
            });
    },
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