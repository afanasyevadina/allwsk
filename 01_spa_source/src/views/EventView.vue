<template>
  <div class="home">
    <template v-if="error">
      <h1 class="text-center">{{ error }}</h1>
    </template>
    <template v-else>
      <div class="d-flex align-items-center justify-content-between mb-5">
        <h1>{{ event.name }}</h1>
        <router-link :to="`/organizers/${organizerSlug}/events/${eventSlug}/registration`" class="btn btn-primary" id="register">Register for this event</router-link>
      </div>
      <div class="alert alert-success mb-4" v-if="$root.flash">{{ $root.flash }}</div>
      <table class="table">
        <tr>
          <td colspan="2"></td>
          <td>
            <div class="d-flex justify-content-between px-3">
              <div>9:00</div>
              <div>11:00</div>
              <div>15:00</div>
              <div>19:00</div>
            </div>
          </td>
        </tr>
        <template v-for="channel in event.channels" :key="channel.id">
          <tr>
            <td class="border border-dark">
              <div class="p-3 channel">
                {{ channel.name }}
              </div>
            </td>
            <td class="border border-dark">
              <div class="p-3 room" v-for="room in channel.rooms" :key="room.id">
                {{ room.name}}
              </div>
            </td>
            <td class="border border-dark">
              <div class="p-3 d-flex row m-0" v-for="room in channel.rooms" :key="room.id">
                <router-link :to="`/organizers/${organizerSlug}/events/${eventSlug}/sessions/${session.id}`" v-for="session in room.sessions" :key="session.id" :style="session.style" class="btn session" :class="{'registered': checkRegistered(session), 'btn-outline-success': checkRegistered(session), 'btn-outline-dark': !checkRegistered(session)}">
                  {{ session.title }}
                </router-link>
              </div>
            </td>
          </tr>
        </template>
      </table>
    </template>
  </div>
</template>

<script>
export default {
  name: 'EventView',
  props: ['organizerSlug', 'eventSlug'],
  data() {
    return {
      event: {channels: []},
      registrations: [],
      error: false
    }
  },
  mounted() {
    let success
    fetch(`http://192.168.100.155/comp01/02_server/api/v1/organizers/${this.organizerSlug}/events/${this.eventSlug}`)
        .then(response => {
          success = response.ok
          return response.json()
        })
        .then(json => {
          if (success) {
            this.event = json
            this.event.channels.forEach(channel => {
              channel.rooms.forEach(room => {
                let filled = 9 * 60
                room.sessions.forEach(session => {
                  let start = new Date(session.start).getHours() * 60 + new Date(session.start).getMinutes()
                  let end = new Date(session.end).getHours() * 60 + new Date(session.end).getMinutes()
                  session.style = {
                    marginLeft: `${(start - filled) / 600 * 100}%`,
                    width: `${(end - start) / 600 * 100}%`,
                  }
                  filled = end
                })
              })
            })
          } else {
            this.error = json.message
          }
        })
    if (this.$root.user) {
      fetch(`http://192.168.100.155/comp01/02_server/api/v1/registrations?token=${this.$root.user?.token}`)
          .then(response => response.json())
          .then(json => this.registrations = json.registrations)
    }
  },
  methods: {
    checkRegistered: function (session) {
      return this.registrations.find(v => v.event.id === this.event.id && (session.type === 'talk' || v.session_ids?.includes(session.id)))
    }
  }
}
</script>
