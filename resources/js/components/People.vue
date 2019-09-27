<template>
    <div>
        <div class="bg-black p-4">
            <input type="search" name="search" v-model="query" placeholder="Find by name" autofocus
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <person v-for="person in results" :key="person.name" :person="person"></person>
    </div>
</template>

<script>
import Person from './Person.vue';

export default {
    props: ['people'],
    components: { Person },

    data() {
        return {
            query: null,
        };
    },

    computed: {
        results() {
            const { query, people } = this;
            if (!query) {
                return people;
            }
            return people.filter(person => {
                return person.name.toLowerCase().includes(query.toLowerCase());
            });
        },
    },
};
</script>
