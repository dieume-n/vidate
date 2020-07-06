require('./bootstrap');



window.Vue = require('vue');


Vue.component('video-upload', require('./components/VideoUpload.vue').default);
Vue.component('video-player', require('./components/VideoPlayer.vue').default);
Vue.component('video-voting', require('./components/VideoVoting.vue').default);


const app = new Vue({
    el: '#app',
    // data: window.vidate ? window.vidate : null
});
