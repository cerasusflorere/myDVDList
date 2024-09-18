<template>
  <header class="header">
    <div class="navbar__brand" @click="scrollTop">
      DVDリスト
    </div>
  </header>
</template>

<script>
export default {
  methods: {
    scrollTop: function(){
      window.scrollTo({
        top: 0,
        behavior: "smooth"
      });
    }
  }
}  
</script>