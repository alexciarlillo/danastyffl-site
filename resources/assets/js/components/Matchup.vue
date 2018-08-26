<template>
    <div class="matchup md:w-sm md:mt-8 md:shadow-lg md:rounded" v-bind:class="classObject">
        <v-touch class="header w-full overflow-hidden bg-mfl-blue-light text-grey-light flex flex-col fixed md:relative md:rounded md:rounded-b-none" v-on:swipeleft="nextMatchup" v-on:swiperight="prevMatchup">
            <MatchupHeader :home="matchup.franchises.home" :away="matchup.franchises.away" :numMatchups="numMatchups" :selected="selected" />
        </v-touch>

        <div class="flex scores bg-grey-lightest md:rounded md:rounded-t-none">
            <div class="franchise-scores flex-1 flex-no-shrink min-w-0 flex flex-col">
                <template v-for="player in awayStarters">
                    <PlayerScore :player="player" :home="true"  :key="player.id"></PlayerScore>
                </template>
            </div>

            <div class="positions flex-shrink w-6 flex flex-col">
                <div v-for="(position, index) in positions" class="position bg-grey-light flex flex-1 justify-center items-center border-b-2 border-grey-lighter md:h-16" :key="index">
                    <span class="text-grey-darker text-2xs">{{position}}</span>
                </div>
            </div>

            <div class="franchise-scores flex-1 flex-no-shrink min-w-0 flex flex-col">
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
        @screen md {
            flex: none;
            order: inherit;
        }

        order: 4;
    }
    
    .positions {
        .position {
            min-height: 3rem;
            max-height: 4rem;
            height: auto;

            @screen md {
                min-height: 4rem;
            }
        }
    }

    .previous {
        order: 1;

        @screen md {
            order:  inherit;
        }
    }

    .selected {
        order: 2;

        @screen md {
            order:  inherit;
        }
    }

    .next {
        order: 3;

        @screen md {
            order: inherit;
        }
    }

    .scores { 
        min-height: calc(100vh - 8.75rem);
        margin-top: 5.25rem;

        @screen md {
            margin-top: 0;
            height: auto;
            min-height: 0;
        }
    }

    .header {
        box-shadow: 0 2px 8px 2px rgba(0, 0, 0, .2)
    }

    .franchise-scores div:last-child, .positions div:last-child {
        border: none;
    }
</style>
