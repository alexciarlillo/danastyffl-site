<template>
    <div class="col-12">
        <div class="card">
            <div class="card-block">
                <template v-for="team in teams">
                    <h4>{{ getLeagueTeamName(league, team.id) }}</h4>

                    <ul>
                        <li v-for="player in team.players.player">
                           {{ getPlayerName(players, player.id) }}
                        </li>
                    </ul>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    import league from '../mixins/league.js';
    import player from '../mixins/player.js';

    export default {
        name: 'Matchup',
        props: ['teams', 'league', 'players'],
        mixins: [league, player]
    }
</script>
