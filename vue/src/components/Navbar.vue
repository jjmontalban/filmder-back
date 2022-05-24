<template>
  <div class="text-center spacing-playground pa-6" fluid>

    <v-btn link exact :to="{ name: 'home' }" class="mx-2" fab x-large color="white">
        <v-img
            :src="require('../assets/pop-corn-icon.png')"
            class="my-3"
            contain
            height="95"
        />
    </v-btn>
    
    <v-btn link exact :to="{ name: 'about' }" class="mx-2" fab x-large color="white">
      <v-img
            :src="require('../assets/chair-icon.png')"
            class="my-3"
            contain
            height="95"
        />
    </v-btn>
    
    <v-btn link exact :to="{ name: 'contact' }" class="mx-2" fab x-large color="white">
        <v-img
            :src="require('../assets/paper-plane-icon.png')"
            class="my-3"
            contain
            height="95"
        />
    </v-btn>
  
  </div>
</template>

<script>

    export default {
        name: 'App',
    }
</script>
