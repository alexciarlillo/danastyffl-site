
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import VueTouch from 'vue-touch';

Vue.use(VueRouter);
Vue.use(VueTouch, {name: 'v-touch'})

import App from './components/App.vue';
import Standings from './components/Standings.vue';
import Scores from './components/Scores.vue';

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    routes: [
        {
            path: '/standings',
            component: Standings,
            name: 'standings'
        },
        {
            path: '/scores/:week?',
            component: Scores,
            name: 'scores'
        }
    ]
});

const app = new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
});
