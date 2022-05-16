<template>
    <v-container>
        <h1 class="text-center">These are my 101 all time favs</h1>
        <v-row>
            <v-col lg="3" md="4" sm="6" v-for="movie in movies" :key="movie.id">
                <v-card class="mx-auto" max-width="300">
                    <a href="#"><v-img :src="movie.photo" alt="image movie" height="350px"/></a>
                    <v-card-title>{{ movie.id }}</v-card-title>
                    <v-card-subtitle>{{ movie.rating }}</v-card-subtitle>
                    <v-card-actions>
                        <v-btn color="orange lighten-2" text>icon info</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn icon @click="show = !show">
                            <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                        </v-btn>
                    </v-card-actions>
                    <v-expand-transition>
                        <div v-show="show">
                            <v-divider></v-divider>
                            <v-card-text>{{ movie.description }}</v-card-text>
                        </div>
                    </v-expand-transition>
                    
                </v-card>   
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import axios from 'axios'

export default {
    data: () => ({
    show: false,
        movies: {}
    }),
    mounted() {
        axios.get('/movies')
            .then(response => {
                this.movies = response.data.data;
            });
    },
}
</script>