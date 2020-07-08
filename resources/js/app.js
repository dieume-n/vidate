require('./bootstrap');

import moment from "moment";
import pluralize from "pluralize";

window.Vue = require('vue');


Vue.component('video-upload', require('./components/VideoUpload.vue').default);
Vue.component('video-player', require('./components/VideoPlayer.vue').default);
Vue.component('video-voting', require('./components/VideoVoting.vue').default);
Vue.component('video-comments', require('./components/VideoComments.vue').default);
Vue.component('subscribe-button', require('./components/SubscribeButton.vue').default);


Vue.filter('fromNow', value => moment(value).fromNow());
Vue.filter('pluralize', (value, number) => pluralize(value, number));
// Vue.filter('plural', (value, word) => value > 1 ? `${word}s` : word)

const app = new Vue({
    el: '#app',
    data: window.vidate ? window.vidate : null
});
