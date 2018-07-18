<template>
<div class="player flex border-b-2 border-grey-lighter items-stretch h-12" :class="{updated: updated, 'flex-row-reverse': !home}">
        <div class="info flex-1 py-2 px-1 flex flex-col justify-center min-w-0" :class="{'items-start': home, 'items-end': !home}">
            <span class="name mb-1 text-2xs lg:text-sm text-grey-darker text-center truncated font-semibold">{{ getShortPlayerName(player.name) }}</span>
            <span class="team text-2xs text-grey font-semibold">{{ player.team }}</span>
        </div>
        <div class="score text-xs py-2 px-1 text-grey-darkest font-semibold w-12 flex flex-no-shrink items-center justify-center">
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
