import { ACTIONS } from './actions';
import { GETTERS, MUTATIONS } from './mutations';
import { defaultState } from '../../../../models/admins/users';

export default {
  namespaced: true,
  state: {...defaultState, ...{action: 'closeModal', classShow: 'modal', styleCss: 'display:none'}},
  getters: GETTERS,
  mutations: MUTATIONS,
  actions: ACTIONS,
}
