require('./bootstrap');



window.Vue = require('vue');


Vue.component('video-upload', require('./components/VideoUpload.vue').default);


Vue.component('example-component', require('./components/ExampleComponent.vue').default);


const app = new Vue({
    el: '#app',
});
