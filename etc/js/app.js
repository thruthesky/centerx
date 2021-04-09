


var app = new Vue({
    el: '#app',
    data: {
        theme: '<?=theme()->folderName?>'
    },
    mixins: mixins
});
