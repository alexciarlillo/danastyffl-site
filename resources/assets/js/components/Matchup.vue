<template>
    <div class="matchup">
        <div class="d-flex flex-row header">
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
        <div class="d-flex flex-row scores" v-bind:style="{ paddingTop: topPadding + 'px' }">
            <div class="franchise-scores">
                <template v-for="player in getPlayerStarters(awayFranchise.players.player)">
                    <PlayerScore :player="player"></PlayerScore>
                </template>
            </div>

            <div class="franchise-scores">
                <template v-for="player in getPlayerStarters(homeFranchise.players.player)">
                    <PlayerScore :player="player"></PlayerScore>
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
        name: 'Matchup',
        props: ['teams', 'league', 'players'],
        mixins: [league, player],
        components: {PlayerScore},
        data: () => ({
            topPadding: 50
        }),
        mounted() {
            this.topPadding = $('.header').height();
        },
        computed: {
            homeFranchise: function() {
                let franchise = this.teams.find(function(team) {
                    return team.isHome == "1";
                });
                return franchise;
            },

            awayFranchise: function() {
                let franchise = this.teams.find(function(team) {
                    return team.isHome == "0";
                });

                return franchise;
            },
        },
        methods: {
        }
    }
</script>
