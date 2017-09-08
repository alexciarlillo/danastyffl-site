<template>
    <div class="score-box d-flex justify-content-between">
        <div class="player-info">
            <div class="name"><strong>{{ getPlayerName(players, player.id) }}</strong></div>
            <div class="team">{{ getPlayerTeam(players, player.id) }}</div>
        </div>
        <div class="score">{{ player.score }}</div>
    </div>
</template>

<script>
import player from '../mixins/player.js';

export default {
    name: 'PlayerScore',
    mixins: [player],
    props: ['player', 'players']

}
</script>
