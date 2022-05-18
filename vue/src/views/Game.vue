<template>
    <v-row class="text-center">
        <tinder ref="tinder" key-name="id" :queue.sync="queue" :offset-y="10" @submit="onSubmit">
            <template>
                <div class="pic" :style="{
                    'background-image': `url(https://themerex.net/wp-content/uploads/edd/2019/07/Rhodos-2.png)`
                }"
                />
            </template>
            <img class="like-pointer" slot="like" src="../assets/like.png">
            <img class="nope-pointer" slot="nope" src="../assets/nope.png">
            <img class="super-pointer" slot="super" src="../assets/super-like.png">
        </tinder>
    <div class="btns">
      <img src="../assets/nope.png" @click="decide('nope')">
      <img src="../assets/super-like.png" @click="decide('super')">
      <img src="../assets/like.png" @click="decide('like')">
    </div>

<div class="col s4 m4" v-for="(post, index) in posts" :key="index">
        <div class="card">
          <div class="card-image">
            <img
              v-if="post._embedded['wp:featuredmedia']"
              :src="post._embedded['wp:featuredmedia'][0].source_url"
            />
            <span class="card-title">{{ post.title.rendered }}</span>
          </div>
          <div class="card-content" v-html="post.excerpt.rendered"></div>
          <div class="card-action">
            <a href="#">{{ post.title.rendered }}</a>
            <p>
              <strong>Published: {{ getPostDate(post.date) }}</strong>
            </p>
          </div>
        </div>
      </div>


    </v-row>
</template>

<script>
import Tinder from "vue-tinder";
import source from "@/bing";
import axios from "axios";

export default {
  
  name: "Game",
  components: { Tinder },
  
  data() {
    return {
      // Wordpress Posts Endpoint
      postsUrl: "http://localhost/wp-vue/wordpress/wp-json/wp/v2/movies",
      // Returned Posts in an Array
      posts: [],
      queue: [],
      offset: 0,
    };
  },

  created() {
    this.mock();
  },

  mounted() {
      this.initialize();
  },

  methods: {
        async initialize () {
            axios
            .get(this.postsUrl)
            .then(response => {
            this.posts = response.data;
            //console.log(this.posts[0].movie_data['original_title']);
            console.log(this.posts);
            })
            .catch(error => {
            console.log(error);
            });
        },    
        mock(count = 20) {
        const list = [];
        for (let i = 0; i < count; i++) {
            list.push({ id: source[this.offset] });
            this.offset++;
        }
        this.queue = this.queue.concat(list);
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

.btns img:nth-child(2n + 1) {
  width: 53px;
}

.btns img:nth-child(2n) {
  width: 65px;
}

.btns img:nth-last-child(1) {
  margin-right: 0;
}
</style>
