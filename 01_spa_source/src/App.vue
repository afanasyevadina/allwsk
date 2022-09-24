<template>
  <div class="p-4">
    <router-view/>
  </div>
</template>
<script>
export default {
  data() {
    return {
      user: null,
      flash: null
    }
  },
  mounted() {
    if (localStorage.getItem('_user_wsk2019'))
      this.user = JSON.parse(localStorage.getItem('_user_wsk2019'))
  }
}
</script>