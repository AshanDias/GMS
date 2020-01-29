<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>
                <i class="nav-icon fas fa-user-friends"></i>&nbsp;Request
              </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <router-link to="/">Operation</router-link>
                </li>
                <li class="breadcrumb-item active">Request</li>
              </ol>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- Modal -->
      <!-- Employee List -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Request List</h3>

          <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 250px;">
              <label for></label>
              <select @change="populateRequest" class="form-control" name id v-model="page_count">
                <option v-for="(item,index) in ppi" :key="index">{{item}}</option>
              </select>&nbsp;
              <input
                type="text"
                v-model="search_str"
                name="table_search"
                class="form-control float-right"
                placeholder="Search"
              />

              <div class="input-group-append">
                <button type="button" class="btn btn-default" @click="populateRequest" >
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-header table-head-fixed -->
        <div class="card-body table-responsive p-0" style="height: 600px;">
          <table class="table">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Customer Name</th>
                <th class="text-center">Email</th>
                <th class="text-center">Contact No.</th> 
                <th class="text-center">Area</th>
                <th class="text-center">Category</th>
                <th class="text-center">Vehicle Type</th>
                <th class="text-center">Address</th>
                <th class="text-center">Date</th>                
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(request,index) in requests.data" :key="index">
                <td
                  class="text-center"
                  :class="request.status_id==6 ?'bg-gradient-green':request.status_id == 8 ?'bg-gradient-primary':'bg-gradient-warning'"
                >{{request.id}}</td>
                <td
                  class="text-center"
                  :class="request.status_id==6 ?'bg-gradient-green': request.status_id == 8 ?'bg-gradient-primary': 'bg-gradient-warning' "
                >{{request.customer_name}}</td>
                <td
                  class="text-center"
                  :class="request.status_id==6 ?'bg-gradient-green': request.status_id == 8 ?'bg-gradient-primary': 'bg-gradient-warning' "
                >{{request.email}}</td>
                 <td
                  class="text-center"
                  :class="request.status_id==6 ?'bg-gradient-green': request.status_id == 8 ?'bg-gradient-primary': 'bg-gradient-warning' "
                >{{request.tele_no}}</td>
                <td
                  class="text-center"
                  :class="request.status_id==6 ?'bg-gradient-green': request.status_id == 8 ?'bg-gradient-primary': 'bg-gradient-warning' "
                >{{request.area_name}}</td>
                <td
                  class="text-center"
                  :class="request.status_id==6 ?'bg-gradient-green': request.status_id == 8 ?'bg-gradient-primary': 'bg-gradient-warning' "
                >{{request.category_name}}</td>
                <td
                  class="text-center"
                  :class="request.status_id==6 ?'bg-gradient-green': request.status_id == 8 ?'bg-gradient-primary': 'bg-gradient-warning' "
                >{{request.vehicle_type}}</td>
                <td
                  v-if="request.address_1 != 'null'"
                  class="text-center"
                  :class="request.status_id==6 ?'bg-gradient-green': request.status_id == 8 ?'bg-gradient-primary': 'bg-gradient-warning' "
                >{{request.address_1}}&nbsp;{{request.address_2!='null'? ', '+request.address_2: '' }}&nbsp;{{request.address_3!='null'? ', '+request.address_3: '' }}</td>
                <td
                  v-else
                  class="text-center"
                  :class="request.status_id==6 ?'bg-gradient-green': request.status_id == 8 ?'bg-gradient-primary': 'bg-gradient-warning' "
                >-</td>
                <td
                  class="text-center"
                  :class="request.status_id==6 ?'bg-gradient-green': request.status_id == 8 ?'bg-gradient-primary': 'bg-gradient-warning' "
                >
                  {{request.request_date }}
                  <br />
                  {{request.request_date | moment("from","now")}}
                </td>
                <td
                  class="text-center"
                  :class="request.status_id==6 ?'bg-gradient-green': request.status_id == 8 ?'bg-gradient-primary': 'bg-gradient-warning' "
                >{{request.status}}</td>
                <td
                  class="text-center"
                  :class="request.status_id==6 ?'bg-gradient-green': request.status_id == 8 ?'bg-gradient-primary': 'bg-gradient-warning' "
                >
                  <select
                    v-if="request.employee_group_id == null"
                    name="group_id"
                    @change="approveRequest(request.id,request.email,request.customer_name,request.vehicle_type,$event)"
                    class="form-control"
                  >
                    <!-- group -->
                    <option value="d0">--- Select Group ---</option>
                    <option
                      v-for="group in groups"
                      :key="group.id"
                      :value="group.id"
                    >{{group.group_code}}</option>
                  </select>
                </td>
              </tr>
            </tbody>
          </table>

          <div v-if="load_data" class="d-flex justify-content-center mt-5">
            <div class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <pagination
            v-if="load_data==false"
            class="float-right"
            :limit="2"
            :data="requests"
            @pagination-change-page="populateRequest"
          ></pagination>
        </div>
        <!-- /.card -->
      </div>
      <!-- Employee List End -->
    </div>
  </div>
</template> 
<script>
export default {
  data() {
    return {
      id: "",
      name: "",
      email: "",
      user_type: "",
      password: "",
      cmf_password: "",
      page_count: 10,
      errors: [],
      requests: [],
      isEdit: false,
      cmfPwd: false,
      load_data: true,
      selectedVehicle: null,
      search_str:null,
      vehicles: [],
      groups: [],
      ppi: []
    };
  },
  filters: {},
  computed: {},
  mounted() {
    this.populateRequest();
    this.itemPerPage();
  },
  methods: {
    onChange(event) {
      console.log(event.target.value);
    },
    approveRequest(id, customerEmail, customerName, vehicleType, event) {
      var grp_id = event.target.value;
      if (event.target.value != undefined || event.target.value != null) {
        this.$swal
          .fire({
            title: "Are you sure?",
            text: "You want to approve this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, approve it!"
          })
          .then(result => {
            if (result.value) {
              axios
                .post("/approve/customer/request", {
                  id: id,
                  group_id: event.target.value
                })
                .then(res => {
                  if (res.status == 200) {
                    if (res.data == "Success") {
                      this.populateRequest();
                      this.sendMailToCustomer(
                        customerEmail,
                        customerName,
                        vehicleType,
                        grp_id
                      );
                      Vue.notify({
                        group: "foo",
                        type: "success",
                        title: "Important message",
                        text: "Request approved success!"
                      });
                      if (result.value) {
                        this.$swal.fire(
                          "Approved!",
                          "Request has been approved.",
                          "success"
                        );
                      }
                    } else {
                      Vue.notify({
                        group: "foo",
                        type: "warn",
                        title: "Important message",
                        text: "Request approved fail!"
                      });
                    }
                  } else if (res.status == 500) {
                    Vue.notify({
                      group: "foo",
                      type: "warn",
                      title: "Important message",
                      text: "Server error !"
                    });
                  }
                })
                .catch(err => {
                  if (err.response.status == 422)
                    this.errors = err.response.data.errors;
                });
            }
            event.target.value = "d0";
            result = null;
          });
      }
    },
    sendMailToCustomer(customerEmail, customerName, vehicleType, grpId) {
      console.log("in mail");
      axios
        .post("/sendbasicemail/", {
          customerEmail: customerEmail,
          customerName: customerName,
          vehicleType: vehicleType,
          grpId: grpId
        })
        .then(res => {
          console.log("in res");
          console.log(res);
        })
        .catch(error => {
          console.log("in err");
          console.log(error);
        });
    },
    itemPerPage() {
      axios.get("/prp").then(res => {
        if (res.status == 200) {
          this.ppi = res.data;
        }
      });
    },
    populateRequest(page = 1) {
      axios
        .post("/customer/request/data?page=" + page, {
          rpp: this.page_count,
          search_str:this.search_str
        })
        .then(res => {
          if (res.status == 200) {
            console.log(res.data);
            this.requests = res.data["customerRequest"];
            this.vehicles = res.data["vehicles"];
            this.groups = res.data["group_data"];
            this.load_data = false;
          }
        });
    },

    deleteUser(user) {
      this.$confirm("Are you sure?").then(() => {
        axios
          .get("/delete/user/" + user.id)
          .then(res => {
            console.log(res);
            if (res.status == 200) {
              if (res.data == "Success") {
                Vue.notify({
                  group: "foo",
                  type: "success",
                  title: "Important message",
                  text: "User deleted success!"
                }),
                  this.resetForm();
              } else {
                Vue.notify({
                  group: "foo",
                  type: "warn",
                  title: "Important message",
                  text: "User delete fail!"
                });
              }
            } else if (res.status == 500) {
              Vue.notify({
                group: "foo",
                type: "warn",
                title: "Important message",
                text: "Server error !"
              });
            }
          })
          .catch(err => {
            if (err.response.status == 422)
              this.errors = err.response.data.errors;
          });
      });
    }
  }
};
</script>