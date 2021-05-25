/**
 * @import before app.js initialize.
    <?php js( 'etc/js/toast.js', 0)?>
    <?php js(theme()->url . 'js/app.js', 0)?>

 * @example
 *
         toastPushNotification(content, title, url) {
            app.toast(content,
                {
                    title: title,
                    buttonAlignRight: true,
                    buttons:
                        [
                            {
                                text: "Close",
                                class: "mr-3",
                                onclick: function() {
                                    console.log('Close');
                                }
                            },
                            {
                                text: "Open",
                                onclick: () => {
                                    console.log("Okay");
                                    location.href = url;
                                }
                            }
                        ]
                })
        },

    @position
         'top-right', 'top-left', 'top-center', 'top-full',
         'bottom-right', 'bottom-left', 'bottom-center', 'bottom-full',

 */
mixins.push({
    data: function() {
        return {
            toastCount: 0
        }
    },
    methods: {
        toast: function(content, options) {
            const o = Object.assign({
                title: '',
                buttons: null,
                cancelButton: null,
                buttonAlignRight: false,
                append: false,
                position: 'bottom-right'
            },options);

            const __this = this;
            const h = this.$createElement;
            const id = "toast-" + __this.toastCount++;
            const vNodesTitle = h( 'div', { class: ['mr-2'] },
                [ h('strong', { class: 'mr-2' }, o.title), ]
            );

            const vNodesMsgButton = [];

            if(o.buttons) {
                for(let i in o.buttons) {
                    const b = o.buttons[i];
                    vNodesMsgButton.push( h(
                        'b-button',
                        {
                            class: [
                                b != null && b['class'] != null ? b['class'] : ""
                            ],
                            on: {
                                click: function() {
                                    if (b != null && b['onclick'] != null ) b['onclick']();
                                    __this.$bvToast.hide(id);
                                }
                            },
                        }, b != null && b['text'] != null ? b['text'] : "")
                    );
                }
            } else {
                vNodesMsgButton.push( h(
                    'b-button',
                    {
                        class: [
                            o.cancelButton != null && o.cancelButton['class'] != null ? o.cancelButton['class'] : ""
                        ],
                        on: {
                            click: function() {
                                if (o.cancelButton != null && o.cancelButton['onclick'] != null ) o.cancelButton['onclick']();
                                __this.$bvToast.hide(id);
                            }
                        },
                    }, o.cancelButton != null && o.cancelButton['text'] != null ? o.cancelButton['text'] : "close")
                );
            }

            const vNodesMsg = h(
                'div',
                { class: ['mb-0'] },
                [
                    content,
                    h('hr'),
                    h(
                        'div', {class: [ 'd-flex ' + (o.buttonAlignRight ? 'justify-content-end':'justify-content-start') ]},
                        vNodesMsgButton
                    )
                ]
            );

            this.$bvToast.toast([vNodesMsg], {
                id: id,
                title: [vNodesTitle],
                autoHideDelay: 10000,
                appendToast: o.append,
                solid: true,
                toaster: 'b-toaster-' + o.position
            })
        }
    }
});