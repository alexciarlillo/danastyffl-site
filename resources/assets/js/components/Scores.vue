<template>
    <div class="scores">
        <h3 class="text-center">Weekly Scores</h3>
        <div class="row" v-for="matchup in scores.matchup">
            <Matchup :teams="matchup.franchise" :league="league" :players="players"></Matchup>
        </div>
    </div>
</template>

<script>
    import Matchup from './Matchup.vue';

    export default {
        name: 'Scores',
        props: ['league', 'players'],
        components: {Matchup},

        data: () => ({
          scores: false,
        }),

        created() {
          axios.get('/api/scores')
          .then(response => {
            this.scores = response.data.liveScoring;
          })
          .catch(e => {
            console.log(e);
          });
        },
    }
</script>
