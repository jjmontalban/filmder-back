<template>
    <v-row class="text-center">
      <Tinder ref="tinder" class="col s4 m4" key-name="id" :queue.sync="queue" :offset-y="10" allow-down @submit="onSubmit">
            <template slot-scope="movie">
                <div class="pic" :style="{ 'background-image': `url(${movie.data.id})` }"/>
            </template>
            <img class="like-pointer" slot="like" src="../assets/like.png">
            <img class="nope-pointer" slot="nope" src="../assets/nope.png">
            <img class="super-pointer" slot="super" src="../assets/super.png">
            <img class="next-pointer" slot="next" src="../assets/next.png">
      </Tinder>
      <div class="btns">
        <img src="../assets/nope.png" @click="decide('nope')">
        <img src="../assets/super.png" @click="decide('super')">
        <img src="../assets/next.png" @click="decide('rewind')">
        <img src="../assets/like.png" @click="decide('like')">
      </div>
    </v-row>
</template>

<script>
import Tinder from "vue-tinder";
import axios from "axios";

export default {
  
  name: "Game",
  components: { Tinder },
  
    data: () => ({
      // Wordpress Posts Endpoint
    moviesUrl: "http://localhost/wp-vue/wordpress/wp-json/wp/v2/movies",
    queue: [],
    movies: [],
    offset: 0,
    history: [],
    total_pages: 0,
    page_number: 0
  }),

  created() {
    this.mock();
  },

  methods: {

       

        mock(count = 10) {
        const list = [];
        
        axios
            .get(this.moviesUrl)
            .then(response => {
                this.total_pages = response.headers['x-wp-totalpages'];
                //get random page between all pages to start game
                this.page_number = Math.floor(Math.random() * (this.total_pages - 1 + 1) ) + 1;
                axios
                      .get(this.moviesUrl + "?page=" + this.page_number)
                      .then(response => {
                                  this.movies = response.data;
                                  for (let j = 0; j < count; j++) {
                                        list.push({ id: this.movies[this.offset].movie_image });
                                        this.offset++;
                                  }
                                  this.queue = this.queue.concat(list);
                
                            }).catch(error => { console.log(error); });
                
                  }).catch(error => { console.log(error); });
        },

        onSubmit({ item }) {
        if (this.queue.length < 3) {
            this.mock();
        }
        },

        decide (choice) {
        this.$refs.tinder.decide(choice)
        },
   },
};
</script>

<style>
html,
body {
  height: 100%;
}

body {
  margin: 0;
  background-color: #20262e;
  overflow: hidden;
}

#app .vue-tinder {
  position: absolute;
  z-index: 1;
  left: 0;
  right: 0;
  top: 23px;
  margin: auto;
  width: calc(100% - 20px);
  height: calc(80% - 23px - 65px - 47px - 16px);
  min-width: 300px;
  max-width: 355px;
}

.nope-pointer,
.like-pointer {
  position: absolute;
  z-index: 1;
  top: 100px;
  width: 164px;
  height: 164px;
}

.nope-pointer {
  left: 10px;
}

.like-pointer {
  right: 10px;
}

.super-pointer {
  position: absolute;
  z-index: 1;
  bottom: 80px;
  left: 0;
  right: 0;
  margin: auto;
  width: 164px;
  height: 164px;
}

.next-pointer {
  position: absolute;
  z-index: 1;
  bottom: 80px;
  left: 0;
  right: 0;
  margin: auto;
  width: 164px;
  height: 164px;
}


.pic {
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
}

.btns {
  position: absolute;
  left: 0;
  right: 0;
  bottom: 30px;
  margin: auto;
  height: 300px;
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 300px;
  max-width: 500px;
}

.btns img {
  margin-right: 12px;
  box-shadow: 0 4px 9px rgba(0, 0, 0, 0.15);
  border-radius: 50%;
  cursor: pointer;
  -webkit-tap-highlight-color: transparent;
}

.btns img:nth-child(1n) {
  width: 65px;
}
.btns img:nth-child(2n) {
  width: 53px;
}
.btns img:nth-child(3n) {
  width: 53px;
}

.btns img:nth-child(4n) {
  width: 65px;
}

.btns img:nth-last-child(1) {
  margin-right: 0;
}
</style>
