
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import VueTouch from 'vue-touch';
import Vue2Filters from 'vue2-filters';
import PortalVue from 'portal-vue';

Vue.use(Vue2Filters)
Vue.use(VueRouter);
Vue.use(VueTouch, {name: 'v-touch'})
Vue.use(PortalVue);

import App from './components/App.vue';
import Standings from './components/Standings.vue';
import Scores from './components/Scores.vue';

let year = moment().format('YYYY');

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    routes: [
        {
            path: '/standings/:year?',
            component: Standings,
            name: 'standings'
        },
        {
            path: '/scores/:year?/:week?',
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
