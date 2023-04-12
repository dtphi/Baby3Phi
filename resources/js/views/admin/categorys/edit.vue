<template>
  <div id="content">
    <transition v-if="_errors">
      <div class="alert alert-danger">
        <b3p-emoji emoji="exclamation-circle" />
        <button type="button" class="close" data-dismiss="alert">
          <b3p-emoji emoji="times" />
        </button>
        <p v-for="(err, idx) in _errorToArrs()" :key="idx">{{ err }}</p>
      </div>
    </transition>
    <transition v-if="loading">
      <loading-over-lay :active.sync="loading" :is-full-page="fullPage"></loading-over-lay>
    </transition>
    <transition v-if="newsGroup">
      <validation-observer ref="observerNewsGroup" @submit.prevent="_submitInfo">
        <div class="page-header">
          <div class="container-fluid">
            <div class="pull-right">
              <b3p-button @click="_submitInfo" custom-color="primary" :original-title="$options.setting.btn_save_txt">
                <b3p-emoji emoji="save" />
              </b3p-button>
              <b3p-button @click="_submitInfoBack" custom-color="info"
                :original-title="$options.setting.btn_save_back_txt">
                <b3p-emoji emoji="save" />
              </b3p-button>
              <the-btn-back-list-page></the-btn-back-list-page>
            </div>
            <h1>Danh mục</h1>
            <b3p-breadcrumb />
          </div>
        </div>
        <div class="container-fluid">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">
                <b3p-emoji emoji="edit" />Sửa danh mục
              </h3>
            </div>
            <div class="panel-body">
              <form class="form-horizontal">
                <ul class="nav nav-tabs">
                  <li class="active">
                    <a href="#tab-general" data-toggle="tab">Tổng quan</a>
                  </li>
                  <li>
                    <a href="#tab-data" data-toggle="tab">Dữ liệu</a>
                  </li>
                  <li>
                    <a href="#tab-design" data-toggle="tab">Màn hình</a>
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab-general">
                    <div class="tab-content">
                      <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-name">Tên</label>
                        <div class="col-sm-10">
                          <input type="text" v-model="newsGroup.category_name" placeholder="Tên nhóm tin"
                            id="input-name" class="form-control" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-description">Mô tả</label>
                        <div class="col-sm-10">
                          <b3p-tinymce id="input-category-description" name="category_description"
                            :other_options="options" v-model="newsGroup.description" />
                        </div>
                      </div>
                      <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-meta-title">Meta title</label>
                        <div class="col-sm-10">
                          <input type="text" v-model="newsGroup.meta_title" placeholder="Meta title"
                            id="input-meta-title" class="form-control" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="input-meta-description" class="col-sm-2 control-label">{{
                            $options.setting.tab_general_meta_description_txt
                        }}</label>
                        <div class="col-sm-10">
                          <validation-provider name="meta_description" rules="max:191" v-slot="{ errors }">
                            <textarea id="input-meta-description" v-model="newsGroup.meta_description"
                              class="form-control" :placeholder="
                                $options.setting
                                  .tab_general_meta_description_txt
                              "></textarea>
                            <span class="cms-text-red">{{ errors[0] }}</span>
                          </validation-provider>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="input-meta-keyword" class="col-sm-2 control-label">{{
                            $options.setting.tab_general_key_word_txt
                        }}</label>
                        <div class="col-sm-10">
                          <validation-provider name="meta_keyword" rules="max:191" v-slot="{ errors }">
                            <textarea id="input-meta-keyword" v-model="newsGroup.meta_keyword" class="form-control"
                              :placeholder="
                                $options.setting.tab_general_key_word_txt
                              "></textarea>
                            <span class="cms-text-red">{{ errors[0] }}</span>
                          </validation-provider>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="input-tag" class="col-sm-2 control-label">
                          <span data-toggle="tooltip" :data-original-title="
                            $options.setting.tab_general_tag_tooltip_txt
                          ">{{ $options.setting.tab_general_tag_txt }}</span>
                        </label>
                        <div class="col-sm-10">
                          <validation-provider name="tag" rules="max:191" v-slot="{ errors }">
                            <input id="input-tag" v-model="newsGroup.tag" class="form-control" :placeholder="
                              $options.setting.tab_general_tag_txt
                            " />
                            <span class="cms-text-red">{{ errors[0] }}</span>
                          </validation-provider>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="tab-data">
                    <category-autocomplete :category-id="newsGroup.parent_id"></category-autocomplete>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="input-sort-order">Thứ tự</label>
                      <div class="col-sm-10">
                        <validation-provider name="sort_order" rules="numeric|max:191" v-slot="{ errors }">
                          <input type="text" v-model="newsGroup.sort_order" name="sort_order"
                            placeholder="Thứ tự hiển thị" id="input-sort-order" class="form-control" />
                          <span class="cms-text-red">{{ errors[0] }}</span>
                        </validation-provider>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="input-status">Trạng thái</label>
                      <div class="col-sm-10">
                        <select v-model="newsGroup.status" id="input-status" class="form-control">
                          <option value="1" selected="selected">Xảy ra</option>
                          <option value="0">Ẩn</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="tab-design">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <td class="text-left">Màn hình hiển thị</td>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="text-left">
                              <select v-model="newsGroup.layout_id" class="form-control">
                                <option value="1">Trang chủ</option>
                                <option value="2">Trang Tin tức</option>
                                <option value="3">Trang Video</option>
                              </select>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </validation-observer>
    </transition>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import TheBtnBackListPage from './components/TheBtnBackListPage'
import CategoryAutocomplete from './components/TheCategoryEditAutocomplete'
import B3pTinymce from 'com@admin/widgets/B3pTinymce'
import { fn_get_tinymce_langs_url, } from '@app/api/utils/fn-helper'
import { MODULE_NEWS_CATEGORY_EDIT, } from 'store@admin/types/module-types'
import {
  ACTION_UPDATE_NEWS_GROUP,
  ACTION_GET_NEWS_GROUP_BY_ID,
  ACTION_RESET_NOTIFICATION_INFO,
} from 'store@admin/types/action-types'

export default {
  name: 'CategoryEditPage',
  beforeCreate() {
    const cateId = this.$route.params.categoryId
    if (!cateId) {
      window.location.href = `${window.origin}/${this.$cmsCfg.adminPrefix}/news-categories`
    }
  },
  components: {
    TheBtnBackListPage,
    CategoryAutocomplete,
    B3pTinymce,
  },
  data() {
    return {
      fullPage: false,
      options: {
        language_url: fn_get_tinymce_langs_url('vi_VN'),
      },
    }
  },
  watch: {
    updateSuccess(newValue) {
      if (newValue) {
        this._notificationUpdate(newValue)
      }
    },
  },
  computed: {
    ...mapState(MODULE_NEWS_CATEGORY_EDIT, {
      loading: (state) => state.loading,
      errors: (state) => state.errors,
    }),
    ...mapGetters(MODULE_NEWS_CATEGORY_EDIT, ['newsGroup', 'updateSuccess']),
    _errors() {
      return this.errors.length
    },
  },
  methods: {
    ...mapActions(MODULE_NEWS_CATEGORY_EDIT, [
      ACTION_GET_NEWS_GROUP_BY_ID,
      ACTION_RESET_NOTIFICATION_INFO,
      ACTION_UPDATE_NEWS_GROUP
    ]),
    _errorToArrs() {
      let errs = []
      if (
        this.errors.length &&
        typeof this.errors[0].messages !== 'undefined'
      ) {
        errs = Object.values(this.errors[0].messages)
      }
      if (Object.entries(errs).length === 0 && this.errors.length) {
        errs.push(this.$options.setting.error_msg_system)
      }

      return errs
    },
    async _submitInfo() {
      await this.$refs.observerNewsGroup.validate().then(isValid => {
        if (isValid) {
          this[ACTION_UPDATE_NEWS_GROUP](this.newsGroup)
        }
      })
    },
    _submitInfoBack() {
    },
    _notificationUpdate(notification) {
      this.$notify(notification)
      this[ACTION_RESET_NOTIFICATION_INFO]('')
    },
  },
  mounted() {
    const cateId = this.$route.params.categoryId
    this[ACTION_GET_NEWS_GROUP_BY_ID](cateId)
  },
  setting: {
    title: 'Cập nhật nhóm tin',
    error_msg_system: 'Lỗi hệ thống !',
    tab_general_key_word_txt: 'Từ khóa mô tả',
    tab_general_meta_title_txt: 'Thẻ meta tiêu đề',
    tab_general_meta_description_txt: 'Thẻ meta mô tả',
    tab_general_tag_txt: 'Tags',
    tab_general_tag_tooltip_txt: 'Ngăn cách bởi dấu phẩy',
    btn_save_txt: 'Cập nhật',
    btn_save_back_txt: 'Cập nhật trở về danh sách',
  },
}
</script>
