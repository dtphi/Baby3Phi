import ApiConfig from './api-config'
const noGrType = {
  comSuccess: 'common-success',
  comUpdate: 'common-update',
}
const AppConfig = {
  apiUrl: ApiConfig.baseURL,
  perPageValues: [
    { value: 15, label: '15' },
    { value: 25, label: '25' },
    { value: 50, label: '50' },
    { value: 100, label: '100' },
  ],
  formatDateString: 'DD-MM-YYYY',
  newsUploadDir: '/Image',
  newsFileConnectUrlPath: '/admin/filemanagers/news/connector',
  elFinderSoundPath: '/packages/barryvdh/elfinder/sounds',
  tinymceLangPath: '/langs',
  noGroupType: noGrType,
  comSuccessNo: {
    group: noGrType.comSuccess,
    text: 'Thành công',
    type: 'success',
  },
  comUpdateNoSuccess: {
    group: noGrType.comUpdate,
    text: 'Thực hiện cập nhật thành công',
    type: 'success',
  },
  comUpdateNoFail: {
    group: noGrType.comUpdate,
    text: 'Thực hiện cập nhật thất bại',
    type: 'error',
  },
  comInsertNoSuccess: {
    group: noGrType.comUpdate,
    text: 'Thực hiện thêm thành công',
    type: 'success',
  },
  comInsertNoFail: {
    group: noGrType.comUpdate,
    text: 'Thực hiện thêm thất bại',
    type: 'error',
  },
  comDeleteNoSuccess: {
    group: noGrType.comUpdate,
    text: 'Thực hiện xóa thành công',
    type: 'success',
  },
  comDeleteNoFail: {
    group: noGrType.comUpdate,
    text: 'Thực hiện xóa thất bại',
    type: 'error',
  },
  updateOrInsertNoFail: {
    group: noGrType.comUpdate,
    text: 'IP đã tồn tại',
    type: 'error',
  },
}

export default AppConfig
