<template>
    <div>
        <div class="wrap w-full overflow-hidden">
            <div class="carousel flex" v-bind:class="carouselClass">
                <Matchup v-for="(matchup, index) in matchups" :key="index" :matchup="matchup" v-on:set="setCarousel" v-on:next="nextMatchup" v-on:previous="prevMatchup" :index="index" :selected="selected" :numMatchups="matchups.length"/>
            </div>            
        </div>

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
            transitionPrevious: false,
            transitionNext: false,
            isSet: true
        }),
        computed: {
            selectedMatchup: function () {
                return this.matchups[this.selected];
            },
            carouselClass: function () {
                return {
                    'push-previous': this.selected > 0,
                    'is-set': this.isSet,
                    'transition-previous': this.transitionPrevious,
                    'transition-next': this.transitionNext
                }
            }
        },
        methods: {
            nextMatchup: function () {                
                if(this.selected < this.matchups.length - 1) {
                    this.isSet = false;
                    this.transitionNext = true; 
                    this.selected += 1;
                }
            },

            prevMatchup: function () {
                if(this.selected > 0) {
                    this.isSet = false;
                    this.transitionPrevious = true;
                    this.selected -= 1;
                }
            },

            setCarousel: function () {
                this.transitionPrevious = this.transitionNext = false;
                this.isSet = true;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .carousel {
        position: relative;        
        

        &.push-previous {
            left: -100%;
        }

        &.is-set {
            transform: none;
        }

        &.transition-previous {
            transform: translateX(100%);
            transition: transform 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }

        &.transition-next {
            transform: translateX(-100%);
            transition: transform 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }
    }
</style>
