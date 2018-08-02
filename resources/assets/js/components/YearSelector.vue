<template>
    <div class="inline-block relative w-full px-2 md:px-2 md:inline-block md:w-32">
        <select v-model="selected" v-on:change="updateRoute()" class="appearance-none w-full bg-white border border-grey-light text-grey-darker font-semibold hover:text-mfl-blue hover:border-grey px-4 py-1 pr-8 rounded leading-tight">
            <option v-for="entry in history" v-bind:value="entry.year">{{entry.year}}</option>
        </select>
        <div class="pointer-events-none absolute pin-y pin-r flex items-center px-6 text-grey hover:text-grey-darkest">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    
    name: 'YearSelector',
    props: ['history'],
    data: () => ({
        selected: null
    }),
    created() {
        this.selected = this.selectedYear();
    },
    methods: {
        updateRoute: function () {
            let currentRoute = this.$route.path;
            let newRoute = '';

            if (!!this.$route.params.year) {
                newRoute = currentRoute.replace(/\d\d\d\d/i, this.selected);
            } else {
                newRoute = currentRoute + '/' + this.selected;
            }
            
            this.$router.push(newRoute);
        },
        setSelectedYear: function () {
            this.selected = this.selectedYear();
        },
        ...mapGetters(['selectedYear']),
    },
    watch: {
        '$route': 'setSelectedYear',
    }
}
</script>
