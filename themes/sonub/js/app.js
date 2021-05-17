
const app = new Vue({
    el: '#app',
    data: data,
    mixins: mixins,
    methods: {
        saveToken(token, topic = "") {
            request(
                "notification.updateToken",
                { token: token, topic: topic },
                function (re) {
                    // console.log(re);
                },
                this.error
            );
        },
    }
});

