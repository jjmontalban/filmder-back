<template>
    <v-row class="text-center">
      <result-game></result-game>
        <v-col cols="12">
            <h1 class="display-2 font-weight-bold mb-3">This is result game page.</h1>
        </v-col>
    </v-row>
</template>

<script>

import Game from './Game'

export default {
  name: 'Result',
  
  components: {
    'result-game': Game,
  },

  data: () => ({
    //
  }),
};
</script>