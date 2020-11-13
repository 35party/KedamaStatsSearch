<template>
  <div id="app">
    <section class="section is-small pt-4 pb-0">
      <div class="columns">
        <div class="column is-one-quarter">
          <div class="container mb-4">
            <h1 class="title mb-2">BlingWang</h1>
            <h5 class="tag is-light">喵龄：2年3个月</h5>
            &nbsp;
            <h5 class="tag is-info is-light">摸鱼达人</h5>
            &nbsp;
            <h5 class="tag is-warning is-light">附魔师</h5>
          </div>
          <canvas class="is-2by3 mb-4" id="skin_container"></canvas>
          <nav class="menu">
            <p class="menu-label">
              Menu
            </p>
            <ul class="menu-list">
              <li>
                <router-link to="/" :class="{ 'is-active': '/' == $route.path }"
                  >Dashboard</router-link
                >
              </li>
              <li>
                <router-link
                  to="/stats"
                  :class="{ 'is-active': '/stats' == $route.path }"
                  >Stats</router-link
                >
              </li>
              <li>
                <router-link
                  to="/analytics"
                  :class="{ 'is-active': '/analytics' == $route.path }"
                  >Analytics</router-link
                >
              </li>
              <li>
                <router-link
                  to="/logs"
                  :class="{ 'is-active': '/logs' == $route.path }"
                  >Logs</router-link
                >
              </li>
            </ul>
          </nav>
        </div>
        <div class="column mt-4 pt-0 scroll">
          <router-view></router-view>
        </div>
      </div>
    </section>
  </div>
</template>
