<template>
    <div class="card">
        <div class="card-block">
            <template v-for="team in teams">
                <h4>{{ getFranchiseName(league, team.id) }}</h4>

                <table class="table table-sm scores-table">
                    <thead>
                      <tr>
                        <th>Player</th>
                        <th>Team</th>
                        <th>Pos</th>
                        <th>Pts</th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr v-for="player in getPlayerStarters(team.players.player)">
                        <td>{{ getPlayerName(players, player.id) }}</td>
                        <td>{{ getPlayerTeam(players, player.id) }}</td>
                        <td>{{ getPlayerPos(players, player.id) }}</td>
                        <td>{{ player.score }}</td>
                      </tr>
                      <tr>
                        <td><strong>Total</strong></td>
                        <td colspan="3"><strong>{{ getScoringTotal(team.players.player) }}</strong></td>
                      </tr>
                    </tbody>
                </table>
            </template>
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
