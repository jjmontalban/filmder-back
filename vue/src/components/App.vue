<template>
    <v-app id="main">
        <navbar ref="navbar"></navbar>
        <v-main>
            <vue-page-transition name="fade" class="px-15">
                <router-view></router-view>  
            </vue-page-transition>
        </v-main>
        <app-footer></app-footer>
    </v-app>

</template>

<script>
    import Navbar from './Navbar'
    import Footer from './Footer'

    export default {

        name: 'App',

        components: {
            'navbar': Navbar,
            'app-footer': Footer,
        }
    }
</script>
<style>

*{
    font-family: 'Jost', sans-serif;
}

</style>
