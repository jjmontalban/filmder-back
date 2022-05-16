<template>
        <v-app-bar color="white" app absolute elevate-on-scroll>

                <v-btn link exact :to="{ name: 'home' }" icon width="auto" height="auto" class="ma-3" elevation="10">
                    <v-avatar size="80">
                        <img src="\images\pop-corn-icon.png">
                    </v-avatar>
                </v-btn>

                <v-btn link exact :to="{ name: 'about' }" icon width="auto" height="auto" class="ma-3" elevation="10">
                    <v-avatar size="80">
                        <img src="\images\chair-icon.png">
                    </v-avatar>
                </v-btn>

                <v-btn link exact :to="{ name: 'contact' }" icon width="auto" height="auto" class="ma-3" elevation="10">
                    <v-avatar size="80">
                        <img src="\images\paper-plane-icon.png">
                    </v-avatar>
                </v-btn>
                
        </v-app-bar>
        
</template>
<script>

    export default {
        name: 'App',
    }
</script>
