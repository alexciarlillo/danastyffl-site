import Vuex from 'vuex';

import app from './modules/app';
import league from './modules/league';
import players from './modules/players';
import scores from './modules/scores';
import standings from './modules/standings';

export default new Vuex.Store({
    modules: {
        app,
        league,
        players,
        scores,
        standings
    }
});