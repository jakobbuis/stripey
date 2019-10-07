<template>
    <div>
        <person v-for="person in results" :key="person.name" :person="person"></person>
    </div>
</template>

<script>
import Person from './Person.vue';

export default {
    props: ['people', 'query'],
    components: { Person },

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
