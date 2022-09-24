<template>
  <div class="login">
    <h1 class="mb-5">Login</h1>
    <form action="#" @submit.prevent="login">
      <div class="row mb-4">
        <label for="lastname" class="col-md-3 col-xl-2">Lastname</label>
        <div class="col-md-6 col-xl-4">
          <input type="text" class="form-control" :class="{'is-invalid': error}" id="lastname" name="lastname" v-model="form.lastname" placeholder="Lastname">
          <div class="invalid-feedback" v-if="error">{{ error }}</div>
        </div>
      </div>
      <div class="row mb-4">
        <label for="registration_code" class="col-md-3 col-xl-2">Registration Code</label>
        <div class="col-md-6 col-xl-4">
          <input type="text" class="form-control" id="registration_code" name="registration_code" v-model="form.registration_code" placeholder="Code">
        </div>
      </div>
      <div class="row">
        <div class="col-auto col-xl-2 offset-md-3 offset-xl-2">
          <button class="btn btn-primary w-100" id="login">Login</button>
        </div>
      </div>
    </form>
    <HelloWorld msg="Welcome to Your Vue.js App"/>
  </div>
</template>

<script>
export default {
  name: 'LoginView',
  data() {
    return {
      form: {lastname: '', registration_code: ''},
      error: null
    }
  },
  methods: {
    login: function () {
      this.error = null
      let success
      fetch('http://192.168.100.155/comp01/02_server/api/v1/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(this.form)
      })
          .then(response => {
            success = response.ok
            return response.json()
          })
          .then(json => {
            if (!success) {
              this.error = 'Lastname or registration code not correct'
            }
            else {
              this.$root.user = json
              localStorage.setItem('_user_wsk2019', JSON.stringify(json))
              this.$router.push(this.$route.query.redirect || '/')
            }
          })
    }
  }
}
</script>
