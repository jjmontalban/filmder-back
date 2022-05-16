<template>
    <div class="container">
        <form @submit.prevent="contact">

            <div class="form-group">
                <input type="text" id="name" name="name" v-model="fields.name" placeholder="Your Name">
                <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
            </div>

            <div class="form-group">
                <input type="email" id="email" name="email" v-model="fields.email" placeholder="Your Email">
                <div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div>
            </div>

            <div class="form-group">
                <textarea name="message" id="message" v-model="fields.message" cols="30" rows="5" placeholder="Message"></textarea>
                <div v-if="errors && errors.message" class="text-danger">{{ errors.message[0] }}</div>
            </div>

            <button type="submit" value="submit" class="btn btn-primary">Send mensaje</button>

            <div v-if="success" class="alert alert-success mt-3">
                <h1 class="pass">Message sent!</h1>
            </div>

        </form>
    </div>
</template>

<script>

import axios from 'axios'

export default {
  data() {
    return {
      fields: {},
      errors: {},
      success: false,
      loaded: true,
    }
  },

 methods: {
    contact() {
      if (this.loaded) {
        this.loaded = false;
        this.success = false;
        this.errors = {};
/*         axios.post('/contact', this.fields).then(response => {
          this.fields = {}; //Clear input fields.
          this.loaded = true;
          this.success = true;
        }).catch(error => {
          this.loaded = true;
          if (error.response.status === 422) {
            this.errors = error.response.data.errors || {};
          }
        }); */
      }
    },
  },
}
</script>

<style scoped>

    * {box-sizing: border-box;}

    .container {
        display: block;
        margin:auto;
        text-align: center;
        padding: 20px;
        width: 50%;
    }

    label {
        float: left;
    }

    input[type=text], [type=email], textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid black;
        /* box-sizing: border-box; */
        margin-top: 6px;
        margin-bottom: 16px;
        resize: vertical;
    }

    button[type=submit] {
        background-color: black;
        color: white;
        padding: 12px 20px;
        border: none;
        cursor: pointer;
    }

    button[type=submit]:hover {
        background-color: #E32F07;
    }

    .pass{
        color: #E32F07;
    }

</style>