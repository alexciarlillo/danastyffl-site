<template>
  <div>
    <Loader v-if="loading" text="Loading Franchise Data"></Loader>

    <h1>{{ franchise.name }}</h1>
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
        roster: null
      }),
      
      computed: {
        franchise: function() {
          return this.league.franchises.find(franchise => franchise.id == this.id);
        },
        ...mapState(['league'])
      },

      methods: {
        loadRoster: function() {
          this.loading = true;
          axios.get('/api/rosters/' + this.id)
            .then(response => {
                this.roster = response.data;
                this.loading = false;

                console.log(this.roster);
            })
            .catch(e => {
                console.log(e);
            });
        }
      }
  }
</script>
