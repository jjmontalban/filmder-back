<template>
    <v-row class="text-center">
      <Tinder ref="tinder" key-name="img" :queue.sync="queue" :offset-y="4" allow-down @submit="onSubmit">
              
            <template slot-scope="movie">
                {{ movie.data.title }}
                
              <v-img
                    :aspect-ratio="16/9" class="pic" 
                    :style="{ 'background-image': `url(${movie.data.img})` }"/>
            </template>
            
            <img class="nope-pointer" slot="nope" src="../assets/nope.png">
            <img class="super-pointer" slot="super" src="../assets/super.png">
            <img class="down-pointer" slot="down" src="../assets/down.png">
            <img class="like-pointer" slot="like" src="../assets/like.png">
           
      </Tinder>
      <div class="btns">
        <img src="../assets/nope.png" @click="decide('nope')">
        <img src="../assets/super.png" @click="decide('super')">
        <img src="../assets/down.png" @click="decide('down')">
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
    moviesUrl: "http://localhost/wp-vue/wordpress/wp-json/wp/v2/movies?per_page=3&orderby=rand",
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

       

        mock(count = 3) {
        const list = [];

        axios
              .get(this.moviesUrl)
              .then(response => {
                          this.movies = response.data;
                          for (let j = 0; j < count; j++) {
                                list.push({ img: this.movies[this.offset].movie_image,
                                            title: this.movies[this.offset].title.rendered,
                                              });
                                this.offset++;
                          }
                          this.queue = this.queue.concat(list);
        
                    }).catch(error => { console.log(error); });                
        },

        onSubmit({ item }) {
        if (this.queue.length < 3) {
            this.mock();
        }
        },

        async decide (choice) {
                if (choice === "rewind") {
                    if (this.history.length) {
                      this.$refs.tinder.rewind([this.history.pop()]);
                    }
                } else if (choice === "help") {
                    window.open("https://shanlh.github.io/vue-tinder");
                } else {
                    this.$refs.tinder.decide(choice);
                }
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
  top: 1%;
  left: 0;
  right: 20px;
  margin: auto;
  width:400px;
  height: 600px;
}

.tinder-card { border-radius: 0px !important; }


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

.down-pointer {
  position: absolute;
  z-index: 1;
  top: 8px;
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
  z-index: 10;
  position: absolute;
  left: 0;
  right: 0;
  bottom: 50px;
  margin: auto;
  height: 0;
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
