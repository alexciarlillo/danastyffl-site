<template>
  <div>
    <Loader v-if="standings.loading" text="Loading Standings Data"></Loader>

    <div class="standings bg-grey-lightest w-full lg:mt-4 lg:rounded lg:shadow-md overflow-hidden lg:max-w-lg lg:mx-auto"  v-if="!standings.loading">
      <div class="header text-center p-5 container bg-mfl-blue-light text-grey-light ">
        <span class="font-header text-2xl color-mfl-blue">{{selectedYear()}} STANDINGS</span>
      </div>
      <table class="w-full text-center border-collapse">
        <thead>
          <tr>
            <th class="text-sm font-header text-grey-darkest bg-grey-light py-2 text-left pl-2">Team</th>

            <th class="text-sm font-header text-grey-darkest bg-grey-light py-2 hidden md:table-cell">W-L-T</th>
            <th class="text-sm font-header text-grey-darkest bg-grey-light py-2 md:hidden">W/L/T</th>

            <th class="text-sm font-header text-grey-darkest bg-grey-light py-2 hidden md:table-cell">PCT</th>
            <th class="text-sm font-header text-grey-darkest bg-grey-light py-2 md:hidden">%</th>

            <th class="text-sm font-header text-grey-darkest bg-grey-light py-2">PF</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(team, index) in standings.franchises" :key="index" class="h-12">
            <td class="text-xs md:text-sm border-t border-grey-light p-2 text-left">{{ team.name }}</td>
            <td class="text-xs md:text-sm border-t border-grey-light p-2">{{ team.h2hw }}-{{ team.h2hl }}-{{ team.h2ht }}</td>
            <td class="text-xs md:text-sm border-t border-grey-light p-2">{{ winPercentage(team) }}</td>
            <td class="text-xs border-t border-grey-light p-2">{{ team.pf }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  import Loader from './Loader.vue';

  import { mapState, mapGetters, mapActions } from 'vuex';

  export default {
      name: 'Standings',

      props: [],
      components: {Loader},

      created() {
        this.fetchStandings();
      },

      methods: {
        winPercentage: function(team) {
          let wins = parseInt(team.h2hw);
          let losses = parseInt(team.h2hl);

          if (wins + losses == 0) {
            return '-';
          }

          let percentage = wins / (wins + losses);

          return percentage.toFixed(3).replace('0.', '.');
        },

        ...mapActions(['fetchStandings']),
        ...mapGetters(['selectedYear']),
      },

      computed: {
        ...mapState({
            standings: state => state.standings
        })
      },

      watch: {
        '$route': 'fetchStandings',
      },
  }
</script>
