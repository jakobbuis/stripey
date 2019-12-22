<template>
    <div class="max-w-sm rounded overflow-hidden shadow-lg m-4 bg-white border-l-8" :class="statusColor">
        <div class="px-6 py-4 flex">
            <div class="flex-none mr-4">
                <img :src="person.avatar" class="rounded-full w-12" width="48" height="48" :alt="person.name">
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
import OutSick from './status/OutSick';
import DayOff from './status/DayOff';
import OnVacation from './status/OnVacation';

export default {
    props: ['person'],
    components: { AtOffice, InMeeting, OutSick, DayOff, OnVacation },

    computed: {
        statusComponent() {
            return {
                at_office: 'at-office',
                in_meeting: 'in-meeting',
                out_sick: 'out-sick',
                day_off: 'day-off',
                on_vacation: 'on-vacation',
            }[this.person.status.state];
        },

        statusColor() {
            return {
                at_office: 'border-green-400',
                in_meeting: 'border-yellow-400',
                out_sick: 'border-red-400',
                day_off: 'border-red-400',
                on_vacation: 'border-red-400',
            }[this.person.status.state];
        },
    },
};
</script>
