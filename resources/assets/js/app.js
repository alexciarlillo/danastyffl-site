
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

import { sync } from 'vuex-router-sync';

Vue.use(VueRouter);
Vue.use(VueTouch, {name: 'v-touch'})
Vue.use(Vue2Filters)
Vue.use(PortalVue);

import App from './components/App.vue';
import Standings from './components/Standings.vue';
import Scores from './components/Scores.vue';
import Franchise from './components/Franchise.vue';

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    routes: [
        {
            path: '/standings/:year?',
            component: Standings,
            props: true,
            name: 'standings'
        },
        {
            path: '/scores/:year/:week?',
            component: Scores,
            props: true,
            name: 'scoped-scores'
        },
        {
            path: '/scores',
            component: Scores,
            name: 'current-scores'
        },
        {
            path: '/franchise/:id',
            component: Franchise,
            props: true,
            name: 'franchise'
        }
    ]
});

import store from './store';

const unsync = sync(store, router);

const app = new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
});
