Vue.component('vote-buttons', {
    props: ['parentIdx', 'y', 'n', 'textLike', 'textDislike'],
    data: function() {
        return {
            Y: this.y,
            N: this.n,
        }
    },
    template: '<div class="d-flex">' +
        '<a class="btn btn-sm mr-2" @click="onVote(\'Y\')" style="color: green">' +
        '{{ textLike }} <span class="badge badge-success badge-pill" v-if="Y != \'0\'">{{ Y }}</span></a>' +
        '<a class="btn btn-sm mr-2" @click="onVote(\'N\')" style="color: red">' +
        '{{ textDislike }} <span  class="badge badge-danger badge-pill" v-if="N != \'0\'">{{ N }}</span></a>' +
        '</div>',
    methods: {
        onVote: function(choice) {
            const self = this;
            request('post.vote', {
                idx: this.parentIdx,
                choice: choice
            }, function(res) {
                self.N = res['N'];
                self.Y = res['Y'];
            }, alert);
        },
    }
});