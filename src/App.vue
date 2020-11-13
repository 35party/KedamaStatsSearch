<template>
  <div id="app">
    <NavBar />
    <Home />
  </div>
</template>

<script>
// @ is an alias to /src
import NavBar from "@/components/NavBar";
import Home from "@/components/Home";

export default {
  components: {
    NavBar,
    Home
  }
};
</script>
