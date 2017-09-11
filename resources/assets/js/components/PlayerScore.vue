<template>
    <div class="player d-flex justify-content-between" v-bind:class="{changed: didChange}">
        <div class="info">
            <span class="name">{{ getShortPlayerName(player.name) }}</span>
            <span class="team">{{ player.team }}</span>
        </div>
        <div class="score">{{ player.score }}</div>
    </div>
</template>

<script>
import player from '../mixins/player.js';

export default {
    name: 'PlayerScore',
    mixins: [player],
    props: ['player'],
    data: () => ({
        didChange: false
    }),
    watch: {
        'player': {
            handler(newValue, oldValue) {
                if(oldValue.score != newValue.score) {
                    this.didChange = true;
                    setTimeout(() => { this.didChange = false; }, 500);
                }
            }
        }
    }

}
</script>
