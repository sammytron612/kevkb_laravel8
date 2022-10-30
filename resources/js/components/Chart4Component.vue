<template>
    <div>
        <h6 class="p-1 text-center">Recent additions</h6>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Title</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="py-2" v-for="list in lists">
                        <td><a v-bind:href="'/articles/'+ list.id"> {{ list.title    }}</a></td>
                        <td>{{ list.created_at | formatDate}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>


export default {
    data() {
      return {
        lists: {},
      }
    },
mounted() {

         axios.get('stats_get/4').then((response) => {
            this.lists = response.data.recent

      });
    }
   }

</script>
