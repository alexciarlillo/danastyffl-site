<template>
    <div>
        <div class="flex justify-between items-stretch h-16 py-1">
            <div class="franchise-header flex-1 flex-no-shrink min-w-0 text-center flex flex-col justify-between px-2">
                <div class="flex items-center justify-center h-full">
                    <span class="text-sm lg:text-lg w-full font-header franchise-name">{{ away.name }}</span>
                </div>
                <div class="text-base lg:text-xl mt-1 font-header font-semibold">{{ away.score }}</div>
            </div>
            <div class="franchise-seperator flex items-center text-center px-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current h-4 w-4"><path d="M13.6 13.47A4.99 4.99 0 0 1 5 10a5 5 0 0 1 8-4V5h2v6.5a1.5 1.5 0 0 0 3 0V10a8 8 0 1 0-4.42 7.16l.9 1.79A10 10 0 1 1 20 10h-.18.17v1.5a3.5 3.5 0 0 1-6.4 1.97zM10 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>
            </div>
            <div class="franchise-header flex-1 flex-no-shrink min-w-0 text-center flex flex-col justify-between px-2">
                <div class="flex items-center justify-center h-full">
                    <span class="text-sm lg:text-lg font-header franchise-name">{{ home.name }}</span>
                </div>
                <div class="text-base lg:text-xl mt-1 font-header font-semibold">{{ home.score }}</div>
            </div>
        </div>

        <div class="indicator bg-grey-light h-5">
            <div class="circles flex justify-between w-1/2 mx-auto text-xs py-1 items-center text-mfl-blue">
                <div v-for="count in numMatchups" :key="count" class="flex items-center text-grey-darkest">
                    <svg v-if="count-1 == selected" class="h-3 w-3" viewBox="0 0 24 24">
                        <path class="fill-current" d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                    </svg>
                    <svg v-if="count-1 != selected" class="h-3 w-3" viewBox="0 0 24 24">
                        <path class="fill-current" d="M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                    </svg>
                </div>
            </div>
        </div> 
    </div>
</template>

<script>
    export default {
        name: 'MatchupHeader',
        props: ['home', 'away', 'numMatchups', 'selected'],
        created() {
        }
    }
</script>

<style lang="scss" scoped>
    .franchise-name {
        overflow-wrap: break-word;
        word-wrap: break-word;
    }
</style>