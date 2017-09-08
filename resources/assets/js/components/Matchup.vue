<template>
    <div class="d-flex flex-row matchups">
        <div class="matchup" v-for="team in teams">
            <h4>{{ getFranchiseName(league, team.id) }}</h4>
            <div class="scores">
              <template v-for="player in getPlayerStarters(team.players.player)">
                <PlayerScore :player="player" :players="players"/>
              </template>
              <div>
                <span><strong>Total</strong></span>
                <span><strong>{{ getScoringTotal(team.players.player) }}</strong></span>
              </div>
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
