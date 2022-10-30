<template>
<div>
            <div class="row mt-2 mx-auto">
                <div class="input-group offset-3 col-md-6">
                    <input class="form-control h3 py-2 search-input w-50 border-right-0 border" type="search" placeholder="Search a solution" v-model="search" @input="sendTyping(search)"  id="search">
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
            <li v-for="article in articles" :key="article.id">
                <div><a :href="'/articles/' + article.id" style="font-size:20px" v-html="$options.filters.highlight(article.title,search)" ></a>&nbsp-
                    <button v-if="user.role == 'admin'" class="btn btn-danger px-1 py-0 btn-sm" @click.prevent="deleteArticle(article.id)"><i class="fa fa-trash"></i></button>
                    <button v-if="user.role !== 'viewer'" class="btn btn-primary px-1 py-0 btn-sm" @click.prevent="editArticle(article.id)"><i class="fa fa-edit"></i></button>
                </div>
                <span class="fa fa-user mr-1">&nbspAuthored by&nbsp{{ article.author_name }} - </span>
                <span class="fa fa-eye mr-1">&nbspViews&nbsp{{ article.views }} - </span>
                <span class='fa fa-calendar mr-1'>&nbsp{{ article.created_at | timeago }}</span>&nbsp-&nbsp
                <span>{{ article.kb }}</span>
                <div id="rating" data-rate-value="2.0"></div>
                <br>
            </li>

        </ul>
    </div>


</div>
</template>
<script>
   var options = {
        max_value: 5,
        step_size: 0.5,
        readonly: true,
    }
 $(".rating").rate(options);
</script>

<script>
export default {
    data() {
      return {
        search: '',
        sectionid: 0,
        sectionName: "All Sections",
        articles: [],
      }
    },
props: ['user'],
methods: {
    sendTyping(){
        if(this.search.length > 2){
            $('#spinner').show()
            this.fetchArticles()
        } else
        {
            $('#tab').hide();
            $('#nothing').hide();

        }
    },
    fetchArticles(){
        axios.post('/searches/search',{search: this.search}).then(response => {
            console.log(response.data)
            if (response.data.length == 0){
                $('#tab').hide()
                $('#nothing').show()
                $('#spinner').hide();
                }
            else
            {
                $('#nothing').hide()
                this.articles = response.data
                $('#spinner').hide();
                $('#tab').addClass('p-5')
                $('#tab').show()
           }
        })
    },
    deleteArticle(id){
         Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
              $('#spinner').show();
              axios.delete('delete/' + id)
             .then((response)=> {
                 if (response.data == "success")
                 {
                     this.articles = this.articles.filter(u => u.id != id);
                     $('#spinner').hide();
                      Toast.fire({
                            icon: 'success',
                            title: 'Article deleted successfully'
                            })
                } else
                {
                    $('#spinner').hide();
                    Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Something went wrong!',
                        })
                }

             })
            }
          })

    },
    editArticle(id){
        window.location.href = '/alter/'+id

    },
   created(){


    },
}

}

</script>
