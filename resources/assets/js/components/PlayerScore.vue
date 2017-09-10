<template>
    <div class="player d-flex justify-content-between">
        <div class="info">
            <span class="name">{{ getShortPlayerName(players, player.id) }}</span>
            <span class="team">{{ getPlayerTeam(players, player.id) }}</span>
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
