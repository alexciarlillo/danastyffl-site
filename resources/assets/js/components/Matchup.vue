<template>
    <div class="card">
        <div class="card-block">
            <template v-for="team in teams">
                <h4>{{ team.id }}</h4>

                <ul>
                    <li v-for="player in team.players.player">
                       {{ player.id }}
                    </li>
                </ul>
            </template>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Matchup',
        props: ['teams']
    }
</script>
