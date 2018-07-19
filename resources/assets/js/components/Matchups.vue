<template>
    <div class="matchup">
        <v-touch class="header container bg-mfl-blue-light text-grey-light flex flex-col fixed md:relative " v-on:swipeleft="nextMatchup" v-on:swiperight="prevMatchup">
            <div class="flex justify-between items-stretch h-16 py-1">
                <div class="franchise-header flex-1 text-center flex flex-col justify-between px-2">
                    <div class="h-full flex items-center justify-center">
                        <span class="text-sm lg:text-lg font-header">{{ getFranchiseName(league, awayFranchise.id) }}</span>
                    </div>
                    <div class="text-base lg:text-xl mt-1 font-header font-semibold">{{ awayFranchise.score }}</div>
                </div>
                <div class="franchise-seperator flex items-center text-center px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current h-4 w-4"><path d="M13.6 13.47A4.99 4.99 0 0 1 5 10a5 5 0 0 1 8-4V5h2v6.5a1.5 1.5 0 0 0 3 0V10a8 8 0 1 0-4.42 7.16l.9 1.79A10 10 0 1 1 20 10h-.18.17v1.5a3.5 3.5 0 0 1-6.4 1.97zM10 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>
                </div>
                <div class="franchise-header flex-1 text-center flex flex-col justify-between px-2">
                    <div class="h-full flex items-center justify-center">
                        <span class="text-sm lg:text-lg font-header">{{ getFranchiseName(league, homeFranchise.id) }}</span>
                    </div>
                    <div class="text-base lg:text-xl mt-1 font-header font-semibold">{{ homeFranchise.score }}</div>
                </div>
            </div>

            <div class="indicator bg-grey-light h-5 shadow">
                <div class="circles flex justify-between w-1/2 mx-auto text-xs py-1 items-center text-mfl-blue">
                    <div v-for="(matchup, index) in matchups" :key="index" class="flex items-center text-grey-darkest">
                        <svg v-if="index == selected" class="h-3 w-3" viewBox="0 0 24 24">
                            <path class="fill-current" d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                        </svg>
                        <svg v-if="index != selected" class="h-3 w-3" viewBox="0 0 24 24">
                            <path class="fill-current" d="M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                        </svg>
                    </div>
                </div>
            </div>
        </v-touch>

        <div class="flex scores bg-grey-lightest">
            <div class="franchise-scores flex-1 flex-no-shrink min-w-0">
                <template v-for="player in getPlayerStarters(awayFranchise.players.player)">
                    <PlayerScore :player="player" :home="true"  :key="player.id"></PlayerScore>
                </template>
            </div>

            <div class="positions flex-shrink w-6">
                <div v-for="(position, index) in positions" class="bg-grey-light h-12 flex justify-center items-center border-b-2 border-grey-lighter md:h-16" :key="index">
                    <span class="text-grey-darker text-2xs">{{position}}</span>
                </div>
            </div>

            <div class="franchise-scores flex-1 flex-no-shrink min-w-0">
                <template v-for="player in getPlayerStarters(homeFranchise.players.player)">
                    <PlayerScore :player="player" :home="false" :key="player.id"></PlayerScore>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    import league from '../mixins/league.js';
    import player from '../mixins/player.js';
    import PlayerScore from './PlayerScore.vue';

    export default {
        name: 'Matchups',
        props: ['matchups', 'league', 'players'],
        mixins: [league, player],
        components: {PlayerScore},
        data: () => ({
            topPadding: 0,
            selected: 0,
            positions: ['QB', 'RB', 'RB', 'FLX', 'WR', 'WR', 'WR', 'TE', 'DST']
        }),
        mounted() {
            this.updateScorePadding();
        },
        updated() {
            this.updateScorePadding();
        },
        computed: {
            homeFranchise: function() {
                let franchise = this.matchups[this.selected].franchise.find(function(team) {
                    return team.isHome == "1";
                });
                return franchise;
            },

            awayFranchise: function() {
                let franchise = this.matchups[this.selected].franchise.find(function(team) {
                    return team.isHome == "0";
                });

                return franchise;
            }
        },
        methods: {
            updateScorePadding: function () {
                this.topPadding = $('.header').height();
            },

            nextMatchup: function () {
                if(this.selected < this.matchups.length - 1) {
                    this.selected += 1;
                }
            },

            prevMatchup: function () {
                if(this.selected > 0) {
                    this.selected -= 1;
                }
            }
        },
        watcher: {
            'teams': 'updateScorePadding',
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

    @screen md {
        .scores {
            padding-top: 0;
        }
    }
</style>
