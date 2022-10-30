<template>
<div class="mt-2">
    <div class="row">
        <div class="custom-control custom-switch col-md-6">

            <input :disabled="user !== 'admin'" v-on:click="slider1" type="checkbox" v-model="value1Bool" class="custom-control-input" id="bool1">
            <label class="custom-control-label" for="bool1"><h5>Email all users when a new article is created</h5></label>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="custom-control custom-switch col-md-6">
            <input :disabled="user !== 'admin'" v-on:click="slider4" type="checkbox" v-model="value4Bool" class="custom-control-input" id="bool4">
            <label class="custom-control-label" for="bool4"><h5>Notifiy all users when a new article is created</h5></label>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="custom-control custom-switch col-md-6">
            <input :disabled="user !== 'admin'" v-on:click="slider3" type="checkbox" v-model="value3Bool" class="custom-control-input" id="bool3">
            <label class="custom-control-label" for="bool3"><h5>Allow editors to delete articles</h5></label>
        </div>
    </div>
    <br>
    <div class="row">
         <div class="custom-control custom-switch col-md-6">
            <input :disabled="user !== 'admin'" v-on:click="slider2" type="checkbox" v-model="value2Bool" class="custom-control-input" id="bool2">
            <label class="custom-control-label" for="bool2"><h5>Articles created or updated by editors need to be approved by admin</h5></label>
        </div>
    </div>
    <br>
    <div class="row">
         <div class="custom-control custom-switch col-md-6">
            <input :disabled="user !== 'admin'"  v-on:click="slider5" v-model="value5Bool" type="checkbox" class="custom-control-input" id="bool5">
            <label class="custom-control-label" for="bool5"><h5>Enable full text search</h5></label>
        </div>
    </div>

</div>
</template>
<script>
export default {
    props: {user: String },
    data() {
      return {
        value1Bool: '',
        value2Bool: '',
        value3Bool: '',
        value4Bool: '',
        value5Bool: '',
      }
    },
    created(){
     axios.get('/settings/all').then(response => {
         this.value1Bool = response.data[0].email_all
         this.value2Bool = response.data[0].approve_articles
         this.value3Bool = response.data[0].allow_delete
         this.value4Bool = response.data[0].notifications
         this.value5Bool = response.data[0].fulltext

        })
     },
     methods: {
     slider1 (){
         axios.post('/settings/update',{bool1: this.value1Bool}).then(response => {
        })
     },
     slider2 (){

         axios.post('/settings/update',{bool2: this.value2Bool}).then(response => {
        })
     },
     slider3 (){

         axios.post('/settings/update',{bool3: this.value3Bool}).then(response => {
        })
     },
     slider4 (){

         axios.post('/settings/update',{bool4: this.value4Bool}).then(response => {
        })
     },
      slider5 (){

         axios.post('/settings/update',{bool5: this.value5Bool}).then(response => {
        })
     }
     }

}
</script>
