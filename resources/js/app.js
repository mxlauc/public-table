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

window.mixin = {
    methods: {
        timeAgo(date){

            var ahora = Date.now();
            var diferencia = (ahora/ 1000) - date;
            if(diferencia < 60){
                return this.__('A moment ago');
            }else if(diferencia < 60 * 60){
                var m = Math.trunc(diferencia / 60);
                return m == 1
                    ? this.__('A minute ago')
                    : this.__('minutes ago', {minutes: m});
            }else if(diferencia < 60 * 60 * 24){
                var h = Math.trunc(diferencia / 60 / 60);
                return h == 1
                    ? this.__('A hour ago')
                    : this.__('hours ago', {hours: h});
            }else if (diferencia < 60 * 60 * 24 * 4){
                var d = Math.trunc(diferencia / 60 / 60 / 24);
                return d == 1
                    ? this.__('A day ago')
                    : this.__('days ago', {days: d});
            }else{
                var meses = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                var fecha = new Date(date * 1000);
                var d = fecha.getDate();
                var m = meses[fecha.getMonth()];
                var h = fecha.getHours();
                var y = fecha.getFullYear();
                var mm = fecha.getMinutes();
                return this.__('date', {year: y, month: this.__(m), day:d, hours: h, minutes: mm < 10 ? '0' + mm : mm});
            }
        },
        mostrarLoginModal(){
            var modal = bootstrap.Modal.getOrCreateInstance(document.querySelector('#loginModal'));
            modal.show();
        }
    }
};
