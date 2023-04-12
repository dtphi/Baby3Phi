import BaseCRUD from '../BaseCRUD'
import addModal from './adds'
import editModal from './edits'
import { defaultState } from '../../../models/admins/users';
import { ACTIONS } from './actions';
import { GETTERS, MUTATIONS } from './mutations';

const bcrud = new BaseCRUD('users', { table: 'users' })

export default {
  namespaced: true,
  state: { ...defaultState, ...bcrud.state },
  getters: GETTERS,
  mutations: { ...MUTATIONS, ...bcrud.mutations },
  actions: { ...ACTIONS, ...bcrud.actions },
  modules: {
    modal: addModal,
    editModal: editModal,
  },
}
