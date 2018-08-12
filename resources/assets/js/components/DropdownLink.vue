<template>
    <div class="relative w-full md:w-auto">
        <div role="button" class="block md:inline-block select-none md:border-none" v-bind:class="{'border-b': open}" @click="open = !open">
            <slot name="link"></slot>
        </div>
        <div class="dropdown-list md:absolute mt:pin-l md:mt-px" v-show="open">
            <slot name="dropdown"></slot>
        </div>
    </div>
</template>

<script>
export default {    
    name: 'DropdownLink',
    data: () => ({
        open: false
    }),
    watch: {
    $route(to, from) {
        this.open = false;
    }
  },
}
</script>

<style lang="scss" scoped>

</style>

