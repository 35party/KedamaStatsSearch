<template>
  <div>
    <v-btn color="blue" @click="switch_lang('en_US')" dark>English</v-btn>
    <v-btn color="blue" @click="switch_lang('zh_CN')" dark>简体中文</v-btn>
  </div>
</template>

<script>
export default {
  head() {
    return {
      title: 'Dashboard',
    }
  },
  methods: {
    switch_lang(lang) {
      console.log('switching to ' + lang)
      this.$store.commit('SET_LANG', lang)
      this.$i18n.locale = lang
    },
  },
}
</script>
