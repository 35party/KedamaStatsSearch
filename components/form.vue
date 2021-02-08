<template>
  <v-container>
    <v-form ref="form" v-model="valid" lazy-validation>
      <v-text-field
        v-model="name"
        :counter="16"
        :rules="nameRules"
        :label="$t('form.playerid')"
        required
      ></v-text-field>

      <v-select
        v-model="select"
        :items="items"
        :rules="[(v) => !!v || 'Server is required']"
        :label="$t('form.server')"
        required
      ></v-select>

      <v-btn
        color="blue darken-2 mt-4"
        dark
        class="mr-4"
        @click.stop="dialog = true"
        @click="validate"
      >
        {{ $t('form.submit') }}
      </v-btn>
    </v-form>
    <v-row justify="center">
      <v-dialog v-model="dialog" max-width="290">
        <v-card>
          <v-card-title class="headline">
            {{ $t('form.notice.1') }}
          </v-card-title>

          <v-card-text>
            {{ $t('form.notice.2') }}
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="blue darken-1" text @click="dialog = false">
              {{ $t('form.notice.disagree') }}
            </v-btn>

            <v-btn color="blue darken-1" text @click="dialog = false">
              {{ $t('form.notice.agree') }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    name: '',
    valid: true,
    dialog: false,
    nameRules: [
      (v) => !!v || 'ID is required',
      (v) => (v && v.length <= 16) || 'ID must be less than 16 characters',
      (v) => (v && v.length >= 3) || 'ID must be more than 3 characters',
    ],
    select: null,
    items: ['Kedama', 'Nyaacat'],
    checkbox: false,
  }),

  methods: {
    validate() {
      this.$refs.form.validate()
    },
  },
}
</script>
