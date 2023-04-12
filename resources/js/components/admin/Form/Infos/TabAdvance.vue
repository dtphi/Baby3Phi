<template>
  <div class="tab-content">
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-date-available">Ngày hoạt động</label>
      <b3p-date-picker id="input-info-date-available" class="col-sm-10" :group-data="groupData"
        v-model="groupData.date_available" />
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-sort-order">Thứ tự</label>
      <div class="col-sm-10">
        <b3p-input id="input-info-sort-order" name="sort_order" rules="numeric|max:191" v-model="sort_order"
          :options="{ placeholder: 'Thứ tự hiển thị' }" />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-type">Loại Tin</label>
      <div class="col-sm-10">
        <select v-model="information_type" id="input-info-type" class="form-control">
          <option value="1" selected="selected">Tin tức</option>
          <option value="2">Video</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-status">Trạng thái</label>
      <div class="col-sm-10">
        <select v-model="status" id="input-info-status" class="form-control">
          <option value="1" selected="selected">Xảy ra</option>
          <option value="0">Ẩn</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-album">Album hình ảnh</label>
      <div class="col-sm-10">
        <select v-model="album" id="input-info-album" class="form-control">
          <option value="0" selected="selected">-- Chọn Album --</option>
          <option v-for="album in albumDropdowns" :key="album.album_id" :value="album.album_id">
            {{ album.name }}
          </option>
        </select>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import {
  MODULE_NEWS_CATEGORY,
  MODULE_NEWS_CATEGORY_ADD,
  MODULE_INFO_ADD,
} from 'store@admin/types/module-types'
import B3pDatePicker from 'com@admin/widgets/B3pDatePicker'
import { createHelpers, } from 'vuex-map-fields'
import { MAP_PC_INFORMATIONS, } from 'store@admin/types/model-map-fields'
const { mapFields, } = createHelpers({
  getterType: `${MODULE_INFO_ADD}/getInfoField`,
  mutationType: `${MODULE_INFO_ADD}/updateInfoField`,
})

export default {
  name: 'TabAdvanceForm',
  components: {
    B3pDatePicker,
  },
  props: {
    groupData: {
      type: Object,
    },
  },
  computed: {
    ...mapFields(MAP_PC_INFORMATIONS),
    ...mapState(MODULE_NEWS_CATEGORY, ['newsGroups']),
    ...mapState(MODULE_INFO_ADD, ['albumDropdowns']),
    ...mapGetters(MODULE_NEWS_CATEGORY, ['loading']),
    ...mapGetters(MODULE_NEWS_CATEGORY_ADD, ['isOpen']),
  },
  methods: {
    ...mapActions(MODULE_INFO_ADD, ['ACTION_GET_DROPDOWN_ALBUM_LIST']),
  },
  mounted() {
    this.ACTION_GET_DROPDOWN_ALBUM_LIST({
      action: 'info.album.dropdown',
    })
  },
}
</script>
