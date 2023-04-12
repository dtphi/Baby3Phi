<template>
  <div>
    <div id="media-info-manager_"></div>
    <input
      type="hidden"
      class="form-control"
      id="file-media-info-input"
      disabled
    />
  </div>
</template>

<script>
import { EmitOnSelectInfoMediaImg, } from '@app/api/utils/event-bus'
import { fnCheckImgPath, } from '@app/common/util'

export default {
  name: 'TheMediaManage',
  props: {
    selectedImage: {
      type: Function,
      default: function(fi) {
        fnCheckImgPath(fi)?EmitOnSelectInfoMediaImg({ filePath: fi.selected.path, }): ''
      },
    },
  },
  data() {
    return {
      mediaMM: null,
    }
  },
  mounted() {
    this.$data.mediaMM = new this.$MM({
      el: '#media-info-manager_',
      api: this.$cmsCfg.mm.api,
      input: {
        el: '#file-media-info-input',
        multiple: false,
      },
      onSelect: (event) => {
        this._changeImage(event)
      },
    })
  },
  methods: {
    _changeImage(fi) {
      this.selectedImage(fi)
    },
  },
  setting: {
    image_title: 'Banner',
    image_url_title: 'Url hình',
  },
}
</script>
