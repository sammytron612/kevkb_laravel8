<script>
import { Bar } from 'vue-chartjs';

export default {
   extends: Bar,
   mounted() {
         let title = new Array();
         let rating = new Array();
         axios.get('stats_get/3').then((response) => {
            let data = response.data.rated
            console.log(data)
            if(data) {
               data.forEach(element => {
               title.push(this.chkLength(element.title));
               rating.push(element.rating);
               });
               this.renderChart({
               labels: title,
               datasets: [{
                   data: rating,
                  label: 'Highest rated',
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
         }, {responsive: true, maintainAspectRatio: false})
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
