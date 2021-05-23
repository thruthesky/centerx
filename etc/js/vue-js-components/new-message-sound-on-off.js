/**
 * @see readme
 */
Vue.component('new-message-sound-on-off', {
    props: ['option'],
    data: function() {
        return {
            re: false,
            soundOnIcon: '/etc/svg/volume-on.svg',
            soundOffIcon: '/etc/svg/volume-off.svg',
        };
    },
    template: '' +
        '<div class="pointer" @click="toggleMessageSound">' +
        '   <img :src=" re ? soundOnIcon : soundOffIcon " width="18">' +
        '</div>',
    mounted() {
        this.re = this.option !== 'N';
    },
    methods: {
        toggleMessageSound: function() {
            const self = this;
            request('user.update', {'playNewMessageSound': this.re ? 'N' : ''}, function(user) {
                self.re = user.playNewMessageSound !== 'N';
            }, alert );
        }
    }
});