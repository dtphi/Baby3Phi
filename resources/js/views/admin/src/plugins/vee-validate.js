import Vue from 'vue'
import {
  ValidationProvider,
  ValidationObserver,
  extend,
  localize,
} from 'vee-validate'
import * as originalRules from 'vee-validate/dist/rules'
import ja from 'vee-validate/dist/locale/ja.json'

// 全てのルールをインポート
let rule
for (rule in originalRules) {
  extend(rule, {
    ...originalRules[rule], // eslint-disable-line
  })
}

extend('kana', {
  message: '{_field_}は全角カタカナで入力してください',
  validate(value) {
    // eslint-disable-next-line
    if (value.match(/^([ァ-ヶ]|[ ]|[ー・。、　])+$/)) {
      return true
    }
  },
})

extend('post', {
  message: '{_field_}は郵便番号の形式で入力してください。　例：123-4567',
  validate(value) {
    if (value.match(/^(\d{3}-?\d{4})+$/)) {
      return true
    }
  },
})

extend('decimal', {
  params: ['max'],
  message: '{_field_}は小数点第{max}位までの数値を入力してください',

  validate(value, { max }) {
    if (value === null || value === '' || value === undefined) return true
    const regex = new RegExp('^(?:[0-9]*?\\.?[0-9]{1,' + max + '}?)$')
    return regex.test(value)
  },
  computesRequired: true,
})

extend('tel', {
  message: '{_field_}は電話番号のフォーマットで入力してください',

  validate(value) {
    if (value === null || value === '' || value === undefined) return true
    const rule = /^0[0-9]{1,4}-?[0-9]{1,4}-?[0-9]{1,4}$/
    const regex = new RegExp(rule)
    return regex.test(value)
  },
  computesRequired: true,
})

// メッセージを設定
localize('ja', ja)

Vue.component('ValidationProvider', ValidationProvider)
Vue.component('ValidationObserver', ValidationObserver)
