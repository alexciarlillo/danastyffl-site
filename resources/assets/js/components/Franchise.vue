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

      data: () => ({
        loading: false,
      }),
      
      computed: {
        franchise: function() {
          return this.league.franchises.find(franchise => franchise.id == this.id);
        },
        ...mapState(['league'])
      },
  }
</script>
