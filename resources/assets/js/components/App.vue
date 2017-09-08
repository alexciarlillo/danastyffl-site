<template>
  <div class="container">
    <NavBar/>
    <div v-if="league && players">
      <router-view :league="league" :players="players"></router-view>
    </div>
  </div>
</template>

<script>
  import NavBar from './NavBar.vue';

  export default {
    name: 'App',
    data: () => ({
      league: false,
      players: false
    }),
    components: {NavBar},
    created() {
      axios.get('/api/league')
        .then(response => {
          this.league = response.data.league;
        })
        .catch(e => {
          console.log(e);
        });

      axios.get('/api/players')
        .then(response => {
          this.players = response.data.players;
        })
        .catch(e => {
          console.log(e);
        });
    }
  }
</script>
