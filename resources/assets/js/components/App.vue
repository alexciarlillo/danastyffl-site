<template>
  <div v-if="league">
    <router-view :league="league"></router-view>
  </div>
</template>

<script>
  export default {
    name: 'App',
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
