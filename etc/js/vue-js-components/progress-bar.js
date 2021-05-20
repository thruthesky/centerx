/**
 * @see readme
 */
Vue.component('progress-bar', {
    props: ['progress'],
    template: '' +
        '<div class="progress-bar" style="display: none;" :style="{display: progress > 0 ? \'block\' : \'none\' }">' +
        '  <div :style="{width: progress + \'%\'}">{{ progress }}%</div>' +
        '</div>',
});