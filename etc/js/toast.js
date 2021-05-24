/**
 * @import before app.js initialize.
    <?php js( 'etc/js/toast.js', 0)?>
    <?php js(theme()->url . 'js/app.js', 0)?>

 * @example
 *
         toastPushNotification(content, title = "Notification", url) {
            app.toast(content,
                {
                    title: title,
                    buttonAlignRight: true,
                    buttons:
                        [
                            {
                                text: "Close",
                                class: "mr-3",
                                onclick: () => console.log('Close')
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

    @position 'top-right', 'top-left', 'top-center', 'top-full', 'bottom-right', 'bottom-left', 'bottom-center', 'bottom-full',

 */
mixins.push({
    data() {
        return {
            toastCount: 0
        }
    },
    methods: {
        toast(content,
              {
                  title,
                  buttons = null,
                  cancelButton = null,
                  buttonAlignRight = false,
                  append = false,
                  position= 'top-right',
                  // position= 0,
              }) {

            const h = this.$createElement;
            const id = `toast-${app.toastCount++}`;
            const vNodesTitle = h( 'div', { class: ['mr-2'] },
                [ h('strong', { class: 'mr-2' }, title ?? ""), ]
            );

            const vNodesMsgButton = [];

            if(buttons) {
                for(let i in buttons) {
                    const b = buttons[i];
                    vNodesMsgButton.push( h(
                        'b-button',
                        {
                            class: [
                                b != null && b['class'] != null ? b['class'] : ""
                            ],
                            on: {
                                click: () => {
                                    if (b != null && b['onclick'] != null ) b['onclick']();
                                    app.$bvToast.hide(id);
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
                            cancelButton != null && cancelButton['class'] != null ? cancelButton['class'] : ""
                        ],
                        on: {
                            click: () => {
                                if (cancelButton != null && cancelButton['onclick'] != null ) cancelButton['onclick']();
                                app.$bvToast.hide(id);
                            }
                        },
                    }, cancelButton != null && cancelButton['text'] != null ? cancelButton['text'] : "close")
                );
            }

            const vNodesMsg = h(
                'div',
                { class: ['mb-0'] },
                [
                    `${content}`,
                    h('hr'),
                    h(
                        'div', {class: [ 'd-flex ' + (buttonAlignRight ? 'justify-content-end':'justify-content-start') ]},
                        vNodesMsgButton
                    )
                ]
            );

            const toaster = [
                'b-toaster-top-right',
                'b-toaster-top-left',
                'b-toaster-top-center',
                'b-toaster-top-full',
                'b-toaster-bottom-right',
                'b-toaster-bottom-left',
                'b-toaster-bottom-center',
                'b-toaster-bottom-full',
            ];
            this.$bvToast.toast([vNodesMsg], {
                id: id,
                title: [vNodesTitle],
                autoHideDelay: 10000,
                appendToast: append,
                solid: true,
                toaster: 'b-toaster-' + position
                // toaster: toaster[position],
            })
        }
    }
});