<template>
  <div class="row text-center col-info">
    <p class="mb-4"></p>
    <h4 class="title mb-3">Giáo Phận Phú Cường</h4>
    <p class="mb-0">Ban Truyền Thông Giáo Phận</p>
    <p>104 Lạc Long Quân, Phường Phú Cường, Tp. Thủ Dầu Một, Tỉnh Bình Dương</p>
    <p class="mb-0">+84 274 730 7788</p>
    <p class="mb-0">baphibaby@gmail.com</p>
    <b3p-button @click="_close" original-title="Thoát">
      Đóng
    </b3p-button>
  </div>
</template>
<script>
export default {
  name: 'HelpAbout',
  methods: {
    _close() {
      this.$parent.toggle()
    },
  },
}
</script>
