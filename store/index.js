export const state = () => ({
  locales: ['zh_CN', 'en_US'],
  locale: 'zh_CN',
  dark: false,
})

export const mutations = {
  SET_LANG(state, locale) {
    if (state.locales.includes(locale)) {
      state.locale = locale
      localStorage.setItem('locale', state.locale)
    }
  },
  SET_DARK(state, dark) {
    state.dark = dark
    localStorage.setItem('dark', state.dark)
  },
}
