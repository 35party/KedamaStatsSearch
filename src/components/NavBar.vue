<template>
  <div id="nav">
    <nav class="navbar is-light" role="navigation" aria-label="main navigation">
      <div class="navbar-brand">
        <a class="navbar-item pl-5 pr-5" href="#">
          <span class="is-size-5">毛玉线圈物语数据查询</span>
          <img src="/static/logo.png" height="40" class="ml-2" />
        </a>
        <a
          role="button"
          class="navbar-burger burger"
          aria-label="menu"
          aria-expanded="false"
          @click="active = !active"
          :class="{ 'is-active': active }"
        >
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
      </div>

      <div class="navbar-menu" :class="{ 'is-active': active }">
        <div class="navbar-start"></div>
        <div class="navbar-end">
          <div class="navbar-item">
            <p class="control has-icons-right">
              <input class="input" type="text" placeholder="搜索玩家..." />
              <span class="icon is-small is-right">
                <v-icon name="search" />
              </span>
            </p>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
import "vue-awesome/icons";
import Icon from "vue-awesome/components/Icon";

export default {
  components: {
    "v-icon": Icon
  },
  data() {
    return {
      active: false
    };
  }
};
</script>
