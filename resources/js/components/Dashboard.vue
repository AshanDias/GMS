<template>
  <!-- Content Wrapper. Contains page content -->
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
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <h5>
          <i class="far fa-thumbs-up"></i> Garbage Collecting Requests
        </h5>
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              
              <div class="inner">
                <div v-if="load_data" class="spinner-border size-25"></div>
                <h3 v-else>{{today}}</h3>
                <p>Today</p>
              </div>
              
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer"></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <div v-if="load_data" class="spinner-border size-25"></div>
                <h3 v-else>{{thisWeek}}</h3>
                <p>This Week</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer"></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <div v-if="load_data" class="spinner-border size-25"></div>
                <h3 v-else>{{thisMonth}}</h3>
                <p>This Month</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-line"></i>
              </div>
              <a href="#" class="small-box-footer"></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <div v-if="load_data" class="spinner-border size-25"></div>
                <h3 v-else>{{thisYear}}</h3>
                <p>This Year</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer"></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Today Request</h3>
                <div class="card-tools">
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a>
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-bars"></i>
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Customer Name</th>
                    <th>Category</th>
                    <th>Address</th>
                    <th>Vehicle Type</th>
                    <th>More</th>
                  </tr>
                  </thead>
                  <tbody  v-if="load_data == false">
                  <tr v-for="todayRequest in todayRequests.slice(0,7)" :key="todayRequest.id">
                    <td>
                      <img src="dist/img/logo-person.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                      {{todayRequest.customer_name}}
                    </td>
                    <td>{{todayRequest.name}}</td>
                    <td>                     
                      {{todayRequest.address_1}}&nbsp;{{todayRequest.address_2!='null'? ', '+todayRequest.address_2: '' }}&nbsp;{{todayRequest.address_3!='null'? ', '+todayRequest.address_3: '' }}
                    </td>
                    <td>
                       <small class="text-success mr-1">
                        <i class="fas fa-tractor"></i>                         
                      </small>
                      {{todayRequest.type_code}}
                    </td>
                    <td>
                     <router-link to="/customer/request">
                        <i class="fas fa-search"></i>
                     </router-link>
                    </td>
                  </tr>                 
                  </tbody>
                  <tbody v-else-if="load_data == true">
                    <td></td>
                    <td></td>
                    <td>
                    <div class="spinner-grow text-muted"></div>
                    <div class="spinner-grow text-primary"></div>
                    <div class="spinner-grow text-success"></div>
                    <div class="spinner-grow text-info"></div>
                    <div class="spinner-grow text-warning"></div>
                    <div class="spinner-grow text-danger"></div>
                    <div class="spinner-grow text-secondary"></div>
                    <div class="spinner-grow text-dark"></div>
                    <div class="spinner-grow text-light"></div>
                    </td>
                    <td></td>
                    <td></td>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Today Request
                </h3>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                    </li>
                   
                  </ul>
                </div>
              </div> 
              <div class="card-body">
                <div class="tab-content p-0"> 
                  <div
                    class="chart tab-pane active"
                    id="revenue-chart"
                    style="position: relative; height: 300px;"
                  >
                    <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                  </div>
                  <div
                    class="chart tab-pane"
                    id="sales-chart"
                    style="position: relative; height: 300px;"
                  >
                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                  </div>
                </div>
              </div>
              
            </div> -->
            <!-- /.card -->

            <!-- TO DO List -->

            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">
            <!-- Map card -->
            <div class="card">
              <div class="card-header">
                <FullCalendar
                  defaultView="dayGridMonth"
                  :plugins="calendarPlugins"
                  :events="event_list"
                />
              </div>
            </div>
            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</template>
<style lang='scss'>
@import "~@fullcalendar/core/main.css";
@import "~@fullcalendar/daygrid/main.css";
</style>
<script>
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
export default {
  components: {
    FullCalendar // make the <FullCalendar> tag available
  },
  mounted() {
    this.pupulateInitialData();

    console.log("Component mounted.");
  },
  data() {
    return {
      event_list:[],
      //  [
      //   { title: "event 1", date: "2019-12-01" },
      //   { title: "event 2", date: "2019-12-02" }
      // ],
      calendarPlugins: [dayGridPlugin],
      today: null,
      thisWeek: null,
      thisMonth: null,
      thisYear: null,
      load_data: true,
      todayRequests: []
    };
  },
  methods: {
    pupulateInitialData() {
      this.load_data = true;
      axios
        .get("/dashboard/data")
        .then(res => {
          if (res.status == 200) {
            this.todayRequests = res.data["todayRequest"];
            this.today = res.data["today"];
            this.thisWeek = res.data["thisWeek"];
            this.thisMonth = res.data["thisMonth"];
            this.thisYear = res.data["thisYear"];
            this.event_list = res.data["events"];
            this.load_data = false;
          }
        })
        .catch(err => {
           this.load_data = false;
          console.log(err);
        });
    }
  }
};
</script>
