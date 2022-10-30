<script>
import { Bar } from 'vue-chartjs';

export default {
   extends: Bar,
   mounted() {
         let author = new Array();
         let count = new Array();
         axios.get('stats_get/2').then((response) => {
            let data = response.data.author
            if(data) {
               data.forEach(element => {
               author.push(this.chkLength(element.Name));
               count.push(element.Count);
               });
               this.renderChart({
               labels: author,
               datasets: [{
                  label: 'Greatest contributors',
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
                  data: count
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
