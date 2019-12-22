<template>
    <div class="w-full">
        <label for="search" class="sr-only">Search</label>
        <input type="search"
               name="search"
               id="search"
               v-model="query"
               placeholder="Find by name"
               autofocus
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>
</template>

<script>
export default {
    data() {
        return {
            query: null,
        };
    },

    watch: {
        query() {
            this.$emit('update:query', this.query);
        }
    },
};
</script>
