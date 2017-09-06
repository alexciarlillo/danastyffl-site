
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('jquery');
require('tether');
require('bootstrap');

import VueRouter from 'vue-router';

window.Vue = require('vue');

Vue.use(VueRouter);

import App from './components/App.vue';
import Standings from './components/Standings.vue';
import Scores from './components/Scores.vue';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: App,
            children: [
                {
                    path: 'standings',
                    component: Standings
                },
                {
                    path: 'scores',
                    component: Scores
                }
            ]
        }
    ]
});

const app = new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
});
