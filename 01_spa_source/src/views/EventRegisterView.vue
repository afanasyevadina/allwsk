<template>
  <div class="home">
    <template v-if="error404">
      <h1 class="text-center">{{ error404 }}</h1>
    </template>
    <template v-else>
      <h1 class="mb-5">{{ event.name }}</h1>
      <form action="#" @submit.prevent="register">
        <div class="row mb-5">
          <div class="col-sm-4" v-for="ticket in event.tickets" :key="ticket.id">
            <div class="card h-100" :class="{disabled: !ticket.available}">
              <label class="card-body d-flex align-items-center ticket">
                <input type="radio" v-model="form.ticket" class="me-3" :value="ticket" :disabled="!ticket.available">
                <div class="w-100">
                  <div class="d-flex justify-content-between">
                    <span class="h4 me-3">{{ ticket.name }}</span>
                    <span class="h4">{{ ticket.cost }}</span>
                  </div>
                  <div>{{ ticket.available ? ticket.description : 'unavailable' }}</div>
                </div>
              </label>
            </div>
          </div>
        </div>
        <h4 class="mb-4">Select additional workshops you want to book:</h4>
        <template v-for="channel in event.channels" :key="channel.id">
          <template v-for="room in channel.rooms" :key="room.id">
            <template v-for="session in room.sessions" :key="session.id">
              <label v-if="session.type === 'workshop'" class="d-block mb-3 workshop">
                <input type="checkbox" v-model="form.sessions" :value="session">
                {{ session.title }}
              </label>
            </template>
          </template>
        </template>
        <div class="row justify-content-end">
          <div class="col-auto">
            <table class="mb-4">
              <tr>
                <td class="p-3">Event ticket:</td>
                <td class="p-3" id="event-cost">{{ form.ticket?.cost || '-' }}</td>
              </tr>
              <tr class="border-bottom">
                <td class="p-3">Additional workshops:</td>
                <td class="p-3" id="additional-cost">{{ form.sessions.map(s => s.cost).reduce((a, c) => a + Number(c), 0) }}</td>
              </tr>
              <tr class="fw-bold">
                <td class="p-3">Total:</td>
                <td class="p-3" id="total-cost">{{ form.ticket?.cost + form.sessions.map(s => Number(s.cost)).reduce((a, c) => a + c, 0) || 0 }}</td>
              </tr>
            </table>
            <div class="text-danger mb-3" v-if="error">{{ error }}</div>
            <div class="d-flex justify-content-end">
              <button class="btn btn-primary" id="purchase" :disabled="!form.ticket">Purchase</button>
            </div>
          </div>
        </div>
      </form>
    </template>
  </div>
</template>

<script>
export default {
  name: 'EventRegisterView',
  props: ['organizerSlug', 'eventSlug'],
  data() {
    return {
      form: {ticket: null, sessions: []},
      event: {tickets: [], channels: []},
      error: null,
      error404: null,
    }
  },
  mounted() {
    if (!this.$root.user) {
      this.$router.push(`/login?redirect=${this.$route.path}`)
    }
    let success
    fetch(`http://192.168.100.155/comp01/02_server/api/v1/organizers/${this.organizerSlug}/events/${this.eventSlug}`)
        .then(response => {
          success = response.ok
          return response.json()
        })
        .then(json => {
          if (success) {
            this.event = json
          } else {
            this.error404 = json.message
          }
        })
  },
  methods: {
    register: function () {
      this.error = null
      let success
      fetch(`http://192.168.100.155/comp01/02_server/api/v1/organizers/${this.organizerSlug}/events/${this.eventSlug}/registration?token=${this.$root.user?.token}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          ticket_id: this.form.ticket.id,
          session_ids: this.form.sessions.map(s => s.id)
        })
      })
          .then(response => {
            success = response.ok
            return response.json()
          })
          .then(json => {
            if (!success) {
              this.error = json.message
            }
            else {
              this.$root.flash = 'Registration successful'
              this.$router.push(`/organizers/${this.organizerSlug}/events/${this.eventSlug}`)
            }
          })
    }
  }
}
</script>

<style>
.card label {
  cursor: pointer;
}
.disabled {
  opacity: .5;
  pointer-events: none;
}
</style>
