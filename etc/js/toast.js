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
                  append = false
              }) {
            const h = app.$createElement;
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
            app.$bvToast.toast([vNodesMsg], {
                id: id,
                title: [vNodesTitle],
                autoHideDelay: 10000,
                appendToast: append,
                solid: true,
            })
        }
    }
});