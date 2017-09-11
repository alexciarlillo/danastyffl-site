<template>
    <div class="player d-flex justify-content-end" v-bind:class="{changed: didChange}">
        <div class="position left" v-if="!home">{{ player.position }}</div>
        <div class="info w-100">
            <span class="name">{{ getShortPlayerName(player.name) }}</span>
            <span class="team">{{ player.team }}</span>
        </div>
        <div class="score">{{ player.score }}</div>
        <div class="position right" v-if="home">{{ player.position }}</div>
    </div>
</template>

<script>
import player from '../mixins/player.js';

export default {
    name: 'PlayerScore',
    mixins: [player],
    props: ['player', 'home'],
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
