<template>
  <div class="home">
    <template v-if="error">
      <h1 class="text-center">{{ error }}</h1>
    </template>
    <template v-else>
      <h1 class="mb-5">{{ session.title }}</h1>
      <p v-html="session.description"></p>
      <table>
        <tr>
          <td class="pe-3 pb-3"><b>Speaker:</b></td>
          <td class="pe-3 pb-3">{{session.speaker }}</td>
        </tr>
        <tr>
          <td class="pe-3 pb-3"><b>Start:</b></td>
          <td class="pe-3 pb-3">{{ new Date(session.start).toLocaleTimeString('en-US', {hour: 'numeric', minute: '2-digit'}) }}</td>
        </tr>
        <tr>
          <td class="pe-3 pb-3"><b>End:</b></td>
          <td class="pe-3 pb-3">{{ new Date(session.end).toLocaleTimeString('en-US', {hour: 'numeric', minute: '2-digit'}) }}</td>
        </tr>
        <tr v-if="session.cost">
          <td class="pe-3 pb-3"><b>Cost:</b></td>
          <td class="pe-3 pb-3">{{ session.cost }}</td>
        </tr>
      </table>
    </template>
  </div>
</template>

<script>
export default {
  name: 'SessionView',
  props: ['organizerSlug', 'eventSlug', 'sessionId'],
  data() {
    return {
      session: {},
      error: null
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
            this.session = json.channels?.map(c => c.rooms?.map(r => r.sessions).flat()).flat().find(s => s.id == this.sessionId)
            if (!this.session) this.error = 'Session not found'
          } else {
            this.error = json.message
          }
        })
  }
}
</script>
