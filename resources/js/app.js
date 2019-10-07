import Vue from 'vue';
import People from './components/People';
import Search from './components/Search';

Vue.component('people', People);
Vue.component('search', Search);

new Vue({
    el: '#app',
    data: {
        query: null,
    },
});
