<template>
        <v-row>
            <v-col>
                <h1 class="text-center">Hi.</h1>
                <blockquote>Life is like riding a bicycle. </blockquote>
                <blockquote> To keep your balance you must keep moving.</blockquote>
                <br>
                <blockquote>Do you want to contact me and tell me that my movie taste sucks?</blockquote>
                <blockquote>Send me a message!</blockquote>
                <contact-form></contact-form>
            </v-col>
        </v-row>
</template>

<script>
    import ContactForm from '../components/ContactForm'

    export default {
        components: {
            'contact-form': ContactForm
        }
    }
</script>