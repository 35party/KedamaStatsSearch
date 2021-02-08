<template>
  <v-app>
    <v-app-bar app color="white" flat dense class="overflow">
      <v-avatar tile size="32">
        <img src="~/static/kedamalogo.png" alt="Kedama Logo" />
      </v-avatar>

      <v-tabs :key="refreshkey" centered class="ml-n9" color="grey darken-1">
        <v-tab
          v-for="link in links"
          :key="link.title"
          :to="link.to"
          router
          exact
        >
          {{ $t(link.title) }}
        </v-tab>
      </v-tabs>
    </v-app-bar>

    <v-main class="grey lighten-3">
      <v-btn color="blue" dark @click="switch_lang('en_US')">English</v-btn>
      <v-btn color="blue" dark @click="switch_lang('zh_CN')">简体中文</v-btn>
      <v-container class="pa-6">
        <v-row>
          <v-col cols="12" sm="4">
            <v-sheet rounded="lg" min-height="60vh" class="px-4">
              <Form></Form>
            </v-sheet>
          </v-col>

          <v-col cols="12" sm="8">
            <v-sheet rounded="lg" min-height="70vh">
              <v-container><nuxt /></v-container>
            </v-sheet>
          </v-col>
        </v-row>
      </v-container>
    </v-main>

    <v-footer>
      <span>
        &copy; {{ new Date().getFullYear() }} {{ $t('footer.kedama') }}
      </span>
      <v-spacer></v-spacer>
      <span>{{ $t('footer.update') }}2021/1/1 12:00</span>
    </v-footer>
  </v-app>
</template>

<script>
import Form from '~/components/form'
export default {
  data: () => ({
    components: {
      Form,
    },
    links: [
      { title: 'dashboard', to: '/' },
      { title: 'advancement', to: '/advancement' },
      { title: 'statistic', to: '/statistic' },
      { title: 'oredata', to: '/oredata' },
    ],
    refreshkey: 0,
  }),
  methods: {
    switch_lang(lang) {
      console.log('switching to ' + lang)
      this.$store.commit('SET_LANG', lang)
      this.$i18n.locale = lang
      this.refreshkey += 1
    },
  },
}
</script>

<style>
html {
  overflow-y: auto;
}
::-webkit-scrollbar {
  width: 6px;
}
::-webkit-scrollbar-thumb {
  border-radius: 10px;
  background: rgba(0, 0, 0, 0.2);
}
::-webkit-scrollbar-track {
  background: rgba(0, 0, 0, 0.1);
}
</style>
