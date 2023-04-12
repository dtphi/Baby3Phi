import Vue from 'vue'
import moment from 'moment'
import isString from 'lodash/isString'
import isNumber from 'lodash/isNumber'
import isBoolean from 'lodash/isBoolean'
import isNull from 'lodash/isNull'
import isArray from 'lodash/isArray'
import isEmpty from 'lodash/isEmpty'
import isPlainObject from 'lodash/isPlainObject'
import lodashGet from 'lodash/get'
import lodashSet from 'lodash/set'
import clonedeep from 'lodash/cloneDeep'
import merge from 'deepmerge'

Vue.prototype.$get = lodashGet
Vue.prototype.$setNest = lodashSet
Vue.prototype.$deep = clonedeep

const date = (val, format) => {
  format = format ? format.toString() : 'YYYY.MM.DD'
  if (val !== null && val !== '') {
    const d = moment(val)
    return d.format(format)
  }
  return val
}

const flatten = (o, prefix = '', res = {}) => {
  if (isString(o) || isNumber(o) || isBoolean(o) || isNull(o)) {
    res[prefix] = o
    return res
  }

  if (isArray(o) || isPlainObject(o)) {
    for (const i in o) {
      let pref = prefix
      if (isArray(o[i])) {
        res[i] = o[i]
      } else {
        if (isArray(o)) {
          pref = pref + `[${i}]`
        } else if (isEmpty(prefix)) {
          pref = i
        } else {
          pref = prefix + '.' + i
        }
        flatten(o[i], pref, res)
      }
    }
    return res
  }
  return res
}

const dataUnits = ['B', 'KB', 'MB', 'GB', 'TB', 'PB']

const snakeToCamel = (snake) => {
  const camel = snake.charAt(0).toLowerCase() + snake.slice(1)
  return camel.replace(/[-_](.)/g, (match, group1) => {
    return group1.toUpperCase()
  })
}

const kebabToSnake = (kebab) => {
  return kebab.replace(/-/g, '_')
}

const snakeToKebab = (kebab) => {
  return kebab.replace(/_/g, '-')
}

const camelToSnake = (camel) => {
  return camel.replace(/[A-Z]/g, function (e) {
    return '_' + e.charAt(0).toLowerCase()
  })
}

const snakeToPascal = (snake) => {
  const camel = snakeToCamel(snake)
  return camel.charAt(0).toUpperCase() + camel.slice(1)
}

const kebabToPascal = (kebab) => {
  const camel = snakeToCamel(kebabToSnake(kebab))
  return camel.charAt(0).toUpperCase() + camel.slice(1)
}

/**
 * 日付をフォーマットで表示するフィルタ
 *
 * @param  String val
 * @param  String format
 * @return String
 */
Vue.filter('date', (val, format) => {
  return date(val, format)
})

/**
 * 日時表示
 *
 * @param  String val
 * @return String
 */
Vue.filter('datetime', (val) => {
  return date(val, 'YYYY.MM.DD H:mm')
})

/**
 * 最初大文字に
 *
 * @param  String val
 * @return String
 */
Vue.filter('capitalize', (val) => {
  if (!val) return ''
  val = val.toString()
  return val.charAt(0).toUpperCase() + val.slice(1)
})

/**
 * オブジェクトをフラットにする
 *
 * @param  Object o
 * @param  String prefix
 * @param  Object res
 * @return String
 */
Vue.filter('flatten', (o, prefix = '', res = {}) => {
  return flatten(o, prefix, res)
})

/**
 * フラットなオブジェクトをネストさせる
 * TODO 今は2次元まで対応となっている
 *
 * @param  String val
 * @return String
 */

Vue.filter('nest', (o) => {
  let res = {}
  const regex = /^(\d+)年(\d+)月(\d+)日 (\d+):(\d+):(\d+)$/

  const reducer = (pre, cur, i, arr) => {
    const tmp = {}
    tmp[cur] = pre
    return tmp
  }

  Object.keys(o).forEach((key) => {
    // datetimeのフォーマットがapi側ほしいものと異なるため合わせる
    if (key.includes('_at') && regex.test(o[key])) {
      o[key] = o[key].replace(regex, '$1-$2-$3 $4:$5:$6')
    }

    const spl = key.split('.').reverse()

    if (spl.length > 1) {
      const tmp = spl.reduce(reducer, o[key])
      res = merge(res, tmp)
    } else {
      res[spl[0]] = o[key]
    }
  })

  return res
})

/**
 * アイコンフォントの文字列を
 * nuxt-fontawesomeで使えるように分解
 *
 * @param  String str
 * @return Array
 */
Vue.filter('icon', (str) => {
  const spl = str.split('.')
  const prefix = spl[0]
  const icon = spl[1]
  return [prefix, icon]
})

/**
 * Byte → データの単位（KB・MBなど）に変換
 *
 * @param  Number val
 * @return String
 */
Vue.filter('byte', (val) => {
  let count = 0
  while (val >= 1024 && count < dataUnits.length - 1) {
    val = Math.round(val / 1024)
    count++
  }
  return val + dataUnits[count]
})

/**
 * 金額表示（3桁カンマ区切り）
 *
 * @param  Number val
 * @return String|null
 */
Vue.filter('price', (val) => {
  if (typeof val === 'number') {
    return Number(val).toLocaleString()
  }
  return null
})

/**
 * スネークケースをキャメルケースに
 *
 * @param  String val
 * @return String
 */
Vue.filter('snakeToCamel', (val) => snakeToCamel(val))

/**
 * キャメルケースをスネークケースに
 *
 * @param  String val
 * @return String
 */
Vue.filter('camelToSnake', (val) => camelToSnake(val))

/**
 * スネークケースをパスカルケースに
 *
 * @param  String val
 * @return String
 */
Vue.filter('snakeToPascal', (val) => snakeToPascal(val))

/**
 * スネークケースをケバブケースに
 *
 * @param  String val
 * @return String
 */
Vue.filter('snakeToKebab', (val) => snakeToKebab(val))

/**
 * ケバブケースをパスカルケースに
 *
 * @param  String val
 * @return String
 */
Vue.filter('kebabToPascal', (val) => kebabToPascal(val))
