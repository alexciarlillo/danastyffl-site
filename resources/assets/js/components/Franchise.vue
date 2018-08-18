<template>
  <div>
    <Loader v-if="loading" text="Loading Franchise Data"></Loader>

    <div v-if="!loading" class="standings bg-grey-lightest w-full lg:mt-4 lg:rounded lg:shadow-md overflow-hidden lg:max-w-md lg:mx-auto">
      <div class="header text-center p-4 container bg-mfl-blue-light text-grey-light">
        <span class="font-header text-3xl color-mfl-blue">{{ franchise.name }}</span>
      </div>

      <table class="w-full text-center border-collapse" v-for="(position, index) in positions" :key="index">
        <thead>
          <tr>
            <th class="text-sm text-center font-header text-grey-darkest bg-grey-light py-2 text-left pl-2" colspan="2">{{position}}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(player, pindex) in positionPlayers(position)" :key="pindex">
            <td class="text-sm md:text-base text-grey-darkest md:text-sm border-t border-grey-light p-2 text-left">{{player.name}}</td>
            <td class="text-sm text-grey-darkest text-center md:text-base border-t border-grey-light p-2 text-left">{{player.team}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  import Loader from './Loader.vue';

  import { mapState } from 'vuex';

  export default {
      name: 'Franchise',
      props: ['id'],

      components: {Loader},

      created() {
        this.loadRoster();
      },

      data: () => ({
        loading: false,
        roster: null,
        positions: ['QB', 'RB', 'RB', 'WR', 'WR', 'WR', 'TE', 'DEF']
      }),
      
      computed: {
        franchise: function() {
          return this.league.franchises.find(franchise => franchise.id == this.id);
        },
        rosterPlayers: function() {
          if (this.roster) {
            this.roster.players.forEach((player) => {
              let playerData = this.players.all[player.id];
              if (typeof playerData == 'undefined') { // MFL does not have this player - custom league addition?
                  player.name = 'Unknown Player'
                  player.team = 'NONE';
                  player.position = 'QB';
                  player.roto_id = null;
              } else {
                  player.name = playerData.name;
                  player.team = playerData.team;
                  player.position = playerData.position.toUpperCase();
                  player.roto_id = playerData.rotoworld_id;
              }
            });

            return this.roster.players;
          }

          return [];
        },
        ...mapState(['league','players'])
      },

      methods: {
        loadRoster: function() {
          this.loading = true;
          axios.get('/api/rosters/' + this.id)
            .then(response => {
                this.roster = response.data;
                this.loading = false;
            })
            .catch(e => {
                console.log(e);
            });
        },
        positionPlayers: function(pos) {
          return this.rosterPlayers.filter(function (player) {
            return player.position === pos;
          });
        }
      },
      watch: {
        '$route' (to, from) {
          this.loadRoster();
        }
      }
  }
</script>

<style lang="scss">
</style>
