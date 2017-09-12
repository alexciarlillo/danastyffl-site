<template>
    <div class="matchup">

        <v-touch class="header" v-on:swipeleft="nextMatchup" v-on:swiperight="prevMatchup">
            <div class="d-flex flex-row">
                <div class="franchise-header">
                    <h1>{{ getFranchiseName(league, awayFranchise.id) }}</h1>
                    <h2 class="mb-0">{{ awayFranchise.score }}</h2>
                </div>
                <div class="franchise-seperator">@</div>
                <div class="franchise-header">
                    <h1>{{ getFranchiseName(league, homeFranchise.id) }}</h1>
                    <h2 class="mb-0">{{ homeFranchise.score }}</h2>
                </div>
            </div>

            <div class="indicator">
                <div class="circles d-flex flex-row justify-content-between w-50 mr-auto ml-auto">
                    <div v-for="(matchup, index) in matchups">
                        <i class="fa" v-bind:class="{ 'fa-circle': index == selected, 'fa-circle-o': index != selected }"></i>
                    </div>
                </div>
            </div>
        </v-touch>

        <div class="d-flex flex-row scores" v-bind:style="{ paddingTop: topPadding + 'px' }">
            <div class="franchise-scores">
                <template v-for="player in getPlayerStarters(awayFranchise.players.player)">
                    <PlayerScore :player="player" :home="true"></PlayerScore>
                </template>
            </div>

            <div class="franchise-scores">
                <template v-for="player in getPlayerStarters(homeFranchise.players.player)">
                    <PlayerScore :player="player" :home="false"></PlayerScore>
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
            selected: 0
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
            updateScorePadding: function() {
                this.topPadding = $('.header').height();
            },
            nextMatchup: function() {
                if(this.selected < this.matchups.length - 1) {
                  this.selected += 1;
                }
              },

              prevMatchup: function() {
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
