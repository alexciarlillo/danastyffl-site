<template>
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
</template>

<script>
    export default {
        name: 'MatchupHeader',
        props: ['home', 'away'],
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