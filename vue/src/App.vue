<template>
  <v-app>
    <app-navbar></app-navbar>
    <v-main>
      <vue-page-transition name="fade" class="px-15">
        <router-view></router-view>
      </vue-page-transition>
    </v-main>
    <app-footer></app-footer>
  </v-app>
</template>

<script>

import Navbar from './components/Navbar'
import Footer from './components/Footer'

export default {
  name: 'App',
  
  components: {
    'app-navbar': Navbar,
    'app-footer': Footer,
  },

  data: () => ({
    //
  }),
};
</script>

<style>

*{
    font-family: 'Jost', sans-serif;
}

</style>
