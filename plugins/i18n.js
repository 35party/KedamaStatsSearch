import Vue from 'vue'
import VueI18n from 'vue-i18n'

Vue.use(VueI18n)

export default ({ app, store }) => {
  app.i18n = new VueI18n({
    locale: store.state.locale,
    fallbackLocale: 'zh_CN',
    messages: {
      en_US: require('~/assets/locales/en_US.json'),
      zh_CN: require('~/assets/locales/zh_CN.json'),
    },
  })
}
