Vue.component('forum-popup-menu', {
  props: ['id', 'isMine', 'userId'],
  template: `
  <b-popover ref="popover" :target="id" triggers="click blur" placement="bottomright">
    <div class="d-block text-left" style="max-width: 200px">
      <a class="w-100 btn text-left" href='/?p=user.profile'>view profile</a>
      <a class="w-100 btn text-left" :href="'?p=forum.post.edit&categoryId=message&otherUserIdx=' + userId">send message</a>
      <a class="w-100 btn text-left" :href="'/?p=forum.post.list&userIdx=' + userId">list posts of this user</a>
      <a class="w-100 btn text-left">list comments of this user</a>
      <a class="w-100 btn text-left">list photos of this user</a>
    </div>
  </b-popover>`,
});

mixins.push({
  methods: {
    openPopover: function(id) {
      // console.log(this.$root);
      this.popupId = id;
      this.$root.$emit('bv::show::popover', id)
    },
  }
})
