<template>
    <div class="player d-flex" v-bind:class="{updated: updated, 'justify-content-end': home, 'justify-content-start': !home}">
        <div class="position right" v-if="!home">{{ player.position }}</div>

        <div class="info w-100">
            <span class="name">{{ getShortPlayerName(player.name) }}</span>
            <span class="team">{{ player.team }}</span>
        </div>
        <div class="score">{{ player.score }}</div>

        <div class="position left" v-if="home">{{ player.position }}</div>
    </div>
</template>

<script>
import player from '../mixins/player.js';

export default {
    name: 'PlayerScore',
    mixins: [player],
    props: ['player', 'home'],
    data: () => ({
        updated: false
    }),
    watch: {
        'player': {
            handler(newValue, oldValue) {
                if(oldValue.score != newValue.score && oldValue.name == newValue.name) {
                    this.updated = true;
                    setTimeout(() => { this.updated = false; }, 500);
                }
            }
        }
    }

}
</script>
