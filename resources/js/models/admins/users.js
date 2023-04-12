
export const defaultState = {
    users: [],
    userDelete: null,
    isDelete: false,
    isList: false,
    loading: false,
    errors: [],
    isOpen: false,
    action: null,
    classShow: 'modal',
    styleCss: '',
    user: {
      name: '',
      email: '',
      password: '',
    },
    userId: 0,
    insertSuccess: '',
    updateSuccess: false,
}

export const MAP_USERS = [
  'name',
  'email',
  'password'
]

