<template>
    <v-row class="text-center">
        <v-col cols="12">
            <h1 class="display-2 font-weight-bold mb-3">Hi.</h1>
            <p class="subheading font-weight-regular">Do you want to know our film affinity? If your curiosity has brought you here, please:</p>
            <blockquote>You stay in Wonderland and I show you how deep the rabbit-hole goes...</blockquote>
            <br><br>
            <h2 class="headline font-weight-bold mb-3">Let's start!</h2>
            
            <v-btn link exact :to="{ name: 'game' }" icon width="auto" height="auto" class="ma-3" elevation="10">
                <v-avatar size="150">
                    <img :src="require('../assets/rabbit-icon.png')">
                </v-avatar>
            </v-btn>
        </v-col>
    </v-row>
</template>

<script>

  export default {
    name: 'Home',
  }
</script>
