require('./bootstrap');
require('masonry-layout');
//import createApp from 'vue'
window.Vue = require('vue');
window.bootstrap = require('bootstrap');;
window.PostComponent =              require('./components/PostComponent.vue').default;
window.CrearPublicacionComponent =  require('./components/CrearPublicacionComponent.vue').default;
window.SeccionPosts =               require('./components/SeccionPosts.vue').default;
window.UserHeaderComponent =        require('./components/UserHeaderComponent.vue').default;
window.NotificationsComponent =     require('./components/NotificationsComponent.vue').default;
window.GuideComponent =             require('./components/GuideComponent.vue').default;
window.Lang = require('laravel-vue-lang').default;

window.VWave = require('v-wave').default;

window.Masonry = require('masonry-layout');

