<div class="rounded-2xl p-6 card-hover bg-white mb-8">
  <h3 class="text-lg font-semibold mb-3">แนวโน้มผู้เข้าชม (30 วัน)</h3>
  <canvas id="chartViews30"></canvas>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
  <div class="rounded-2xl p-6 card-hover bg-white">
    <h3 class="text-lg font-semibold mb-3">แนวโน้มผู้เข้าชม (7 วัน)</h3>
    <canvas id="chartViews7"></canvas>
  </div>
  <div class="rounded-2xl p-6 card-hover bg-white">
    <h3 class="text-lg font-semibold mb-3">แนวโน้มถูกใจ (7 วัน)</h3>
    <canvas id="chartLoves7"></canvas>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function(){
  const R = window.__REPORT__ || {view30:[], view7:[], love7:[]};
  const toXY = arr => ({
    labels: arr.map(x => x.d),
    data:   arr.map(x => Number(x.c || 0))
  });

  function drawLine(id, series, label){
    const el = document.getElementById(id);
    if(!el) return;
    const xy = toXY(series);
    new Chart(el.getContext('2d'), {
      type: 'line',
      data: {
        labels: xy.labels,
        datasets: [{ label, data: xy.data, borderWidth: 2, fill:false, tension:0.2 }]
      },
      options: { responsive:true, scales:{ y:{ beginAtZero:true } } }
    });
  }

  drawLine('chartViews30', R.view30, 'Views (30d)');
  drawLine('chartViews7',  R.view7,  'Views (7d)');
  drawLine('chartLoves7',  R.love7,  'Loves (7d)');
})();
</script>
