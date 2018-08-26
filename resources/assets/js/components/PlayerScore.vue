<template>
<div class="player flex flex-1 border-b-2 border-grey-lighter items-stretch" :class="{updated: updated, 'flex-row-reverse': !home}">
    <div class="info flex-1 py-2 px-1 md:px-2 flex flex-col justify-center min-w-0" :class="{'items-start': home, 'items-end': !home}">
        <span class="name mb-1 text-xs lg:text-sm text-grey-darkest truncated font-semibold" :class="{'text-left': home, 'text-right': !home}">{{ getShortPlayerName(player.name) }}</span>
        <span class="team text-2xs text-grey-dark font-semibold">{{ player.team }}</span>
    </div>
    <div class="score text-xs py-2 px-1 text-mfl-blue font-semibold w-12 flex flex-no-shrink items-center justify-center md:text-lg md:w-16 md:px-4">
        <span>{{ getScore(player) }}</span>
    </div>
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
    methods: {
        getScore: function (player) {
            return parseFloat(player.score).toFixed(1);
        }
    },
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

<style lang="scss" scoped>
    .player {
        min-height: 3rem;
        max-height: 4rem;
        height: auto;

        @screen md {
            min-height: 4rem;
        }
    }
</style>
