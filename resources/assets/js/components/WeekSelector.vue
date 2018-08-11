<template>
    <div class="select-wrapper inline-block relative w-full px-2 md:px-2 md:inline-block">
        <select v-model="selected" v-on:change="updateRoute()" class="appearance-none w-full bg-white border border-grey-light text-grey-darker font-semibold hover:text-mfl-blue hover:border-grey px-2 py-1 pr-6 rounded leading-tight">
            <option v-for="week in 16" v-bind:value="week" :key="week">
                <span v-if="week == currentWeek">Current Week</span>
                <span v-else>Week {{week}}</span>
            </option>
        </select>
        <div class="pointer-events-none absolute pin-y pin-r flex items-center px-4 text-grey hover:text-grey-darkest">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex';

export default {
    
    name: 'WeekSelector',
    data: () => ({
        selected: null
    }),
    created() {
        this.selected = this.selectedWeek();
    },
    methods: {
        updateRoute: function () {
            let currentRoute = this.$route.path;
            let newRoute = '';

            if (!!this.$route.params.year) {
                if (!!this.$route.params.week) {
                    newRoute = currentRoute.replace(/\/\d+$/i, '/' + this.selected);
                } else {
                    newRoute = currentRoute + '/' + this.selected;
                }
            } else {
                newRoute = currentRoute + '/' + this.selectedYear() + '/' + this.selected;
            }
            
            
            this.$router.push(newRoute);
        },
        setSelectedWeek: function () {
            this.selected = this.selectedWeek();
        },
        ...mapGetters(['selectedWeek', 'selectedYear']),
    },
    computed: {
        ...mapState({
            currentWeek: state => state.app.currentWeek
        })
    },
    watch: {
        '$route': 'setSelectedYear',
    }
}
</script>

<style lang="scss" scoped>
    .select-wrapper {
        @screen md {
            width: 10.5rem;
        }
    }
</style>
