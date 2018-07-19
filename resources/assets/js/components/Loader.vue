<template>
    <div class="mt-8">
        <div class="flex justify-center my-4">
            <looping-rhombuses-spinner
            :animation-duration="2000"
            :rhombus-size="20"
            :color="'#ff6d24'"
            />
        </div>
        <div class="text-center mt-2">{{text}}</div>
    </div>
</template>

<script>
    import { LoopingRhombusesSpinner } from 'epic-spinners';

    export default {
        name: 'Loader',
        props: ['text'],
        components: {LoopingRhombusesSpinner}
    }
</script>