const Actions = require('./actions');
const Mutations = require('./mutations');

const infoAlbumsImage = {
  value: [],
}

const defaultState = () => {
  return {
    isOpen: false,
    action: null,
    classShow: 'modal fade',
    styleCss: '',
    info: {
      albums_name: '',
      group_albums_id: null,
      status: 1,
      sort_id: 1,
      albums_images: [],
      image: {
        basename: '',
        dirname: '',
        extension: '',
        filename: '',
        path: '',
        size: 0,
        thumb: '', //url thumb
        timestamp: null,
        type: null,
      },
    },
    list_group_albums: [],
    isImgChange: true,
    loading: false,
    insertSuccess: false,
    errors: [],
    infoAlbumsImage: infoAlbumsImage,
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    isOpen(state) {
      return state.isOpen
    },
    info(state) {
      return state.info
    },
    loading(state) {
      return state.loading
    },
    insertSuccess(state) {
      return state.insertSuccess
    },
    errors(state) {
      return state.errors
    },
    isError(state) {
      return state.errors.length
    },
    isGroupAlbums(state) {
      return state.list_group_albums
    },
    infoAlbumsImage(state) {
      return state.infoAlbumsImage
    },
  },
  mutations: Mutations.MUTATIONS,
  actions: Actions.ACTIONS,
}
