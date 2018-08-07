<template>
    <div class="matchup">
        <v-touch class="header container bg-mfl-blue-light text-grey-light flex flex-col fixed md:relative " v-on:swipeleft="nextMatchup" v-on:swiperight="prevMatchup">
            <transition name="fade">
                <MatchupHeader :home="homeFranchise(selectedMatchup)" :away="awayFranchise(selectedMatchup)" />
            </transition>
        </v-touch>

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

        <portal to="matchup-select">
            <div class="relative">
                <select v-model="selected" class="text-sm appearance-none w-full bg-white border border-grey-light text-grey-darker hover:text-mfl-blue hover:border-grey px-4 py-1 pr-8 rounded leading-tight md:w-64">
                    <option v-for="(matchup, index) in matchups" :key="index" v-bind:value="index">{{ getFranchiseName(league, awayFranchise(matchups[index]).id) }} @ {{ getFranchiseName(league, homeFranchise(matchups[index]).id) }}</option>
                </select>
                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-4 text-grey hover:text-grey-darkest">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>
        </portal>
    </div>
</template>

<script>
    import league from '../mixins/league.js';
    import player from '../mixins/player.js';
    import PlayerScore from './PlayerScore.vue';
    import MatchupHeader from './MatchupHeader';

    export default {
        name: 'Matchups',
        props: ['matchups', 'league', 'players'],
        mixins: [league, player],
        components: {PlayerScore, MatchupHeader},
        data: () => ({
            topPadding: 0,
            selected: 0,
            positions: ['QB', 'RB', 'RB', 'FLX', 'WR', 'WR', 'WR', 'TE', 'DST']
        }),
        mounted() {
        },
        updated() {
            this.updateScorePadding();
        },
        computed: {
            selectedMatchup: function () {
                return this.matchups[this.selected];
            },
            homeStarters: function () {
                let matchup = this.matchups[this.selected];
                let home = this.homeFranchise(matchup);
                return this.getPlayerStarters(home.players);
            },
            awayStarters: function() {
                let matchup = this.matchups[this.selected];
                let away = this.awayFranchise(matchup);
                return this.getPlayerStarters(away.players);
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
            },

            homeFranchise: function(matchup) {
                let franchise = matchup.franchises.find(function(team) {
                    return team.isHome == "1";
                });
                franchise.name = this.getFranchiseName(this.league, franchise.id);
                return franchise;
            },

            awayFranchise: function(matchup) {
                let franchise = matchup.franchises.find(function(team) {
                    return team.isHome == "0";
                });
                franchise.name = this.getFranchiseName(this.league, franchise.id);
                return franchise;
            },

            
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
