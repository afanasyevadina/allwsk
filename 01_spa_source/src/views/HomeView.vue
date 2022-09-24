<template>
  <div class="home">
    <div class="d-flex align-items-center justify-content-between mb-5">
      <h1>Event Booking Platform</h1>
      <router-link to="/login" class="btn btn-primary login-btn" v-if="!$root.user">Login</router-link>
      <div v-else class="d-flex align-items-center">
        <div class="me-3">{{ $root.user.username }}</div>
        <a href="#" class="btn btn-primary" @click.prevent="logout">Logout</a>
      </div>
    </div>
    <router-link :to="`/organizers/${event?.organizer.slug}/events/${event.slug}`" class="card text-decoration-none text-dark event mb-4" v-for="event in events" :key="event.id">
      <div class="card-body">
        <h4 class="mb-3">{{ event.name }}</h4>
        <div>{{ event.organizer?.name }}, {{ new Date(event.date).toLocaleDateString('en-US', {month: 'long', day: 'numeric', year: 'numeric'}) }}</div>
      </div>
    </router-link>
  </div>
</template>

<script>
export default {
  name: 'HomeView',
  data() {
    return {
      events: [],
    }
  },
  mounted() {
    fetch('http://192.168.100.155/comp01/02_server/api/v1/events')
        .then(response => response.json())
        .then(json => this.events = json.events)
  },
  methods: {
    logout: function () {
      fetch(`http://192.168.100.155/comp01/02_server/api/v1/logout?token=${this.$root.user?.token}`, {
        method: 'POST'
      })
          .then(response => response.json())
          .then(() => {
            this.$root.user = null
            localStorage.removeItem('_user_wsk2019')
          })
    }
  }
}
</script>
