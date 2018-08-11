<template>
    <div class="matchup lg:w-lg lg:shadow-md" v-bind:class="classObject">
        <v-touch class="header w-full overflow-hidden bg-mfl-blue-light text-grey-light flex flex-col fixed md:relative lg:rounded lg:rounded-b-none shadow" v-on:swipeleft="nextMatchup" v-on:swiperight="prevMatchup">
            <MatchupHeader :home="matchup.franchises.home" :away="matchup.franchises.away" :numMatchups="numMatchups" :selected="selected" />
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
        props: ['matchup', 'index', 'selected', 'numMatchups'],
        mixins: [player],
        components: {PlayerScore, MatchupHeader},
        data: () => ({
            positions: ['QB', 'RB', 'RB', 'FLX', 'WR', 'WR', 'WR', 'TE', 'DST']
        }),
        methods: {
            nextMatchup: function () {
                this.$emit('next');
                setTimeout(() => {
                    this.$emit('set');
                }, 100);
            },

            prevMatchup: function () {
                this.$emit('previous');
                setTimeout(() => {
                    this.$emit('set');
                }, 100);
            },
        },
        computed: {
            awayStarters () {
                return this.matchup.franchises.away.starters.sort(this.sortPlayers);
            },
            homeStarters () {
                return this.matchup.franchises.home.starters.sort(this.sortPlayers)
            },
            classObject: function () {
                return {
                    previous: this.selected > 0 && this.index == this.selected-1,
                    next: this.selected < this.numMatchups && this.index == this.selected+1,
                    selected: this.index == this.selected
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .matchup {
        flex: 1 0 100%;
        order: 4;
    }

    .previous {
        order: 1;
    }

    .selected {
        order: 2;
    }

    .next {
        order: 3;
    }

    .scores { 
        padding-top: 5.25rem;
    }
</style>
