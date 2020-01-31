<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <div id="map"></div>
  </div>
</template>
<script>
export default {
  mounted() {
    this.map();
  },
  data() {
    return {
      data: [
        { l: "6.9065494", la: "79.8685325" },
        { l: "6.0535", la: "80.221" },
        { l: "9.6615", la: "80.0255" },
        { l: "6.9497", la: "80.7891" },
        { l: "8.5874", la: "81.2152" },
        { l: "6.8404", la: "81.8368" },
        { l: "7.5260", la: "80.7341" },
        { l: "6.8259", la: "80.9982" }
      ]
    };
  },
  methods: {
    map() {
      var map = L.map("map").setView([0, 0], 1);
      L.tileLayer(
        "https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=F3vOKEzauy5xxxUoX50X",
        {
          attribution:
            '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a><a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>'
        }
      ).addTo(map);

      this.data.forEach(element => {
        L.marker([element.l, element.la]).addTo(map);
      });

      // L.marker([6.9065494, 79.8685325]).addTo(map);
      // L.marker([6.0535, 80.221]).addTo(map);
    }
  }
};
</script>