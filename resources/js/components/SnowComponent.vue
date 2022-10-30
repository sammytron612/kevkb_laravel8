<template>
<div>
            <div class="row mt-2 mx-auto">
                <div class="input-group offset-3 col-md-6">
                    <input class="form-control h3 py-2 search-input w-50 border-right-0 border" type="search" placeholder="Search a snow group" v-model="search" @input="sendTyping(search)"  id="search">
                    <span class="input-group-append">
                        <button class="btn btn-secondary border-left-0 border">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </div>
    <br>

    <div class="d-flex justify-content-center">
        <div  id="spinner" style="display:none" class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="smokey border p-5" style="display:none" id="nothing">
            <h2 class="text-center">No Results</h2>
            <p>Your search did not match any documents</p>
            <p>Suggestions</p>
                <ul>
                    <li>Make sure all words are spelled correctly</li>
                    <li>Try different, more general, or fewer keywords</li>
                </ul>
    </div>
    <div style="display:none" id="tab" class="smokey border h-0 shadow">
        <h1><span class="fa fa-list fa-1x mr-3"></span>Results</h1>
        <hr>
        <ul class="list-unstyled">
            <li v-for="group in groups" :key="group.id">
                <h3>{{ group.title}}</h3>
                <div>{{ group.description}}</div>
            </li>

        </ul>
    </div>


</div>
</template>

<script>
export default {
    data() {
      return {
        search: '',
        groups: [],
      }
    },

methods: {
    sendTyping(){
        if(this.search.length > 3){
            $('#spinner').show()
            this.fetchGroups()

        } else
        {
            $('#tab').hide();
            $('#nothing').hide();


        }
    },
    fetchGroups(){
        axios.post('/snow_group/results',{search: this.search}).then(response => {
            if (response.data.length == 0){
                $('#tab').hide()
                $('#nothing').show()
                $('#spinner').hide();
                } else
            {

             $('#nothing').hide()
             this.groups = response.data
             $('#spinner').hide();
             $('#tab').addClass('p-5')
             $('#tab').show()
           }
        })
    },

}
}

</script>
