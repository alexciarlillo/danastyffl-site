<template>
    <div class="scores">
        <h3 class="text-center">Weekly Scores</h3>
        <template v-for="matchup in scores.matchup">
            <Matchup :teams="matchup.franchise"></Matchup>
        </template>
    </div>
</template>

<script>
    import Matchup from './Matchup.vue';

    export default {
        name: 'Scores',
        props: ['league'],
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
