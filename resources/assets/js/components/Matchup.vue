<template>
    <div class="matchup">
        <v-touch class="header container bg-mfl-blue-light text-grey-light flex flex-col fixed md:relative " v-on:swipeleft="nextMatchup" v-on:swiperight="prevMatchup">
            <transition name="fade">
                <MatchupHeader :home="matchup.franchises.home" :away="matchup.franchises.away" />
            </transition>
        </v-touch>

        <div class="flex scores bg-grey-lightest">
            <div class="franchise-scores flex-1 flex-no-shrink min-w-0">
                <template v-for="player in awayStarters">
                    <PlayerScore :player="player" :home="true"  :key="player.id"></PlayerScore>
                </template>
            </div>

            <div class="positions flex-shrink w-6">
                <div v-for="(position, index) in positions" class="bg-grey-light h-12 flex justify-center items-center border-b-2 border-grey-lighter md:h-16" :key="index">
                    <span class="text-grey-darker text-2xs">{{position}}</span>
                </div>
            </div>

            <div class="franchise-scores flex-1 flex-no-shrink min-w-0">
                <template v-for="player in homeStarters">
                    <PlayerScore :player="player" :home="false" :key="player.id"></PlayerScore>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    import player from '../mixins/player.js';
    import PlayerScore from './PlayerScore.vue';
    import MatchupHeader from './MatchupHeader';

    export default {
        name: 'Matchups',
        props: ['matchup'],
        mixins: [player],
        components: {PlayerScore, MatchupHeader},
        data: () => ({
            positions: ['QB', 'RB', 'RB', 'FLX', 'WR', 'WR', 'WR', 'TE', 'DST']
        }),
        methods: {
            nextMatchup: function () {
                this.$emit('next');
            },

            prevMatchup: function () {
                this.$emit('previous');
            },
        },
        computed: {
            awayStarters() {
                return this.matchup.franchises.away.starters.sort(this.sortPlayers);
            },
            homeStarters() {
                return this.matchup.franchises.home.starters.sort(this.sortPlayers)
            }
        }
    }
</script>

<style lang="scss" scoped>
    .scores { 
        padding-top: 5.25rem;
    }

    .player:last-child {
        border: 0;
    }

    .franchise-name {
        overflow-wrap: break-word;
        width: 100%;
    }

    @screen md {
        .scores {
            padding-top: 0;
        }
    }

    .fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
    }
</style>
