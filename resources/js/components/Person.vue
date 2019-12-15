<template>
    <div class="max-w-sm rounded overflow-hidden shadow-lg m-4 bg-white">
        <div class="px-6 py-4 flex">
            <div class="flex-none mr-4">
                <img :src="person.avatar" class="rounded-full w-12" width="64" height="64">
            </div>
            <div class="flex-grow">
                <div class="font-bold text-xl mb-2">{{ person.name }}</div>
                <component :is="statusComponent" :data="person.status.data"></component>
            </div>
        </div>
    </div>
</template>

<script>
import AtOffice from './status/AtOffice';
import InMeeting from './status/InMeeting';

export default {
    props: ['person'],
    components: { AtOffice, InMeeting },

    computed: {
        statusComponent() {
            return {
                at_office: 'at-office',
                in_meeting: 'in-meeting',
            }[this.person.status.state];
        },
    },
};
</script>
