<template>
  <div v-if="league">
    <Standings :league="league" />
  </div>
</template>

<script>
  import Standings from './Standings';

  export default {
    name: 'App',

    components: {Standings},

    data: () => ({
      league: false
    }),

    created() {
      axios.get('/api/league')
      .then(response => {
        this.league = response.data.league;
      })
      .catch(e => {
        console.log(e);
      });
    }
  }
</script>
