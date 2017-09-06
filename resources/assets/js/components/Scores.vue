<template>
</template>

<script>
    export default {
        name: 'Scores',
        props: ['league'],

        data: () => ({
          scores: false,
        }),

        created() {
          axios.get('/api/scores')
          .then(response => {
            this.scores = response.data.scores;
          })
          .catch(e => {
            console.log(e);
          });
        },
    }
</script>
