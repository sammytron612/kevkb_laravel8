<script>
import { Bar } from 'vue-chartjs';

export default {
   extends: Bar,
   mounted() {
         let titles = new Array();
         let views = new Array();
         axios.get('/stats_get/1').then((response) => {
            let data = response.data.articles

            if(data) {
               data.forEach(element => {
               titles.push(this.chkLength(element.title));
               views.push(element.views);
               });
               this.renderChart({
               labels: titles,
               datasets: [{
                  data: views,
                  label: 'Most viewed articles',
                  backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 26, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 190, 255, 0.2)',
                'rgba(202, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 26, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 190, 255, 0.2)',
                'rgba(202, 159, 64, 0.2)'
            ],
            borderWidth: 2,
            }]
         },
         {responsive: true, maintainAspectRatio: false, })
       }
      });
   },
   methods: {
      chkLength(label) {
        if (label.length > 20) {
        var shortString = label.substring(0,20);
        return shortString + '...';
    }
    return label;
      }
    }
}

</script>
