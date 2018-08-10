<template>
    <div class="matchups">
        <Matchup v-for="(matchup, index) in matchups" :key="index" :matchup="matchup" v-on:next="nextMatchup" v-on:previous="prevMatchup" />

        <portal to="matchup-select">
            <div class="relative">
                <select v-model="selected" class="text-sm appearance-none w-full bg-white border border-grey-light text-grey-darker hover:text-mfl-blue hover:border-grey px-4 py-1 pr-8 rounded leading-tight md:w-64">
                    <option v-for="(matchup, index) in matchups" :key="index" v-bind:value="index">
                        {{ matchup.franchises.away.name }} @ {{ matchup.franchises.home.name }}
                    </option>
                </select>
                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-4 text-grey hover:text-grey-darkest">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>
        </portal>
    </div>
</template>

<script>
    import PlayerScore from './PlayerScore.vue';
    import Matchup from './Matchup';

    export default {
        name: 'Matchups',
        props: ['matchups', 'league', 'players'],
        components: {PlayerScore, Matchup},
        data: () => ({
            selected: 0,
        }),
        computed: {
            selectedMatchup: function () {
                return this.matchups[this.selected];
            }            
        },
        methods: {
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
        }
    }
</script>

<style lang="scss" scoped>

</style>
