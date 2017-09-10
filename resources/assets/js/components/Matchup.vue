<template>
    <div class="matchup">
        <div class="d-flex flex-row header">
            <div class="franchise-header" v-for="team in teams">
                <h1>{{ getFranchiseName(league, team.id) }}</h1>
                <h2>{{ team.score }}</h2>
            </div>
        </div>

        <div class="d-flex flex-row scores">
            <div class="franchise-scores" v-for="team in teams">
                <template v-for="player in getPlayerStarters(team.players.player)">
                    <PlayerScore :player="player" :players="players"></PlayerScore>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    import league from '../mixins/league.js';
    import player from '../mixins/player.js';
    import PlayerScore from './PlayerScore.vue';

    export default {
        name: 'Matchup',
        props: ['teams', 'league', 'players'],
        mixins: [league, player],
        components: {PlayerScore}
    }
</script>
