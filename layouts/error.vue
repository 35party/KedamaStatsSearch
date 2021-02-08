<template>
  <v-app>
    <h1 v-if="error.statusCode === 404">
      {{ $t('error.notfound') }}
    </h1>
    <h1 v-else>
      {{ $t('error.other') }}
    </h1>
    <NuxtLink to="/"> Home page </NuxtLink>
  </v-app>
</template>

<script>
export default {
  layout: 'empty',
  props: {
    error: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      pageNotFound: '404 Not Found',
      otherError: 'An error occurred',
    }
  },
  head() {
    const title =
      this.error.statusCode === 404 ? this.pageNotFound : this.otherError
    return {
      title,
    }
  },
}
</script>

<style>
h1 {
  font-size: 20px;
}
</style>
