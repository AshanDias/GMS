<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>
                <i class="nav-icon fas fa-tractor"></i>&nbsp;Vehicle
              </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <router-link to="/">Master Files</router-link>
                </li>
                <li class="breadcrumb-item active">Vehicle</li>
              </ol>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </section>
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Create new Vehicle</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-remove"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body pb-1">
            <div class="row">
              <div class="col-md-6">                
                <div class="form-group form-group.required">
                  <label>Name</label>
                  <input
                  required
                    type="text"
                    class="form-control"
                    name
                    id
                    v-model="vname"
                    placeholder="Vehicle name"
                  />
                  <span v-if="errors.name">
                    <p class="text-danger">{{errors.name[0]}}</p>
                  </span>
                </div>
                <!-- /.form-group -->
              <div class="form-group">
                  <label>Manufacture Year</label>
                  &nbsp;
                  <div> 
                    <multiselect
                      v-model="manufacture_year"
                      :options="years"
                      :searchable="true"
                      :close-on-select="true"
                      :show-labels="false"
                      placeholder="Pick a value"
                    ></multiselect> 
                     
                  </div>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Vehicle Type</label>
                  &nbsp;
                  <div>
                    <multiselect
                      v-model="selected_vehicle_type"
                      deselect-label="Can't remove this value"
                      track-by="id"
                      label="type_code"
                      placeholder="Select one"
                      :options="Vehicle_types"
                      :searchable="true"
                      :allow-empty="false"
                    ></multiselect>
                  </div>
                    <span v-if="errors.vehicle_type_id">
                    <p class="text-danger">{{errors.vehicle_type_id[0]}}</p>
                  </span>
                </div>
                <!-- /.form-group -->
              
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Vehicle No</label>
                  &nbsp;
                  <input
                    type="number"
                    required
                    class="form-control"
                    name
                    id
                    v-model="regNo"
                    placeholder="Vehicle Registration No."
                  />
                  <span v-if="errors.reg_no">
                    <p class="text-danger">{{errors.reg_no[0]}}</p>
                  </span>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Registered Year</label>
                  &nbsp;
                  <div> 
                    <multiselect
                      v-model="registered_year"
                      :options="years"
                      :searchable="true"
                      :close-on-select="true"
                      :show-labels="false"
                      placeholder="Pick a value"
                    ></multiselect> 
                  </div>
                   <span v-if="errors.reg_year">
                    <p class="text-danger">{{errors.reg_year[0]}}</p>
                  </span>
                </div>
                <!-- /.form-group -->
                  <div class="form-group">
                  <label>Status</label>
                  &nbsp;
                  <div>
                    <multiselect
                      v-model="selectedVehicleStatus"
                      deselect-label="Can't remove this value"
                      track-by="id"
                      label="status"
                      placeholder="Select one"
                      :options="VehicleStatus"
                      :searchable="false"
                      :allow-empty="false"
                      required
                    ></multiselect>
                  </div>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="form-group float-right pt-4">
              <button type="button" @click="resetForm" class="btn btn-danger">Cancel</button>&nbsp;
              <button
                v-if="isEdit == false"
                type="button"
                @click="createVehicle"
                class="btn btn-success "
              >Submit</button>
              <button
                v-if="isEdit"
                type="button"
                @click="updateVehicle"
                class="btn btn-primary "
              >Update</button>
            </div>

            <!-- /.form-group -->
          </div>
          <!-- /.card-body -->
        </div>

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Vehicle List</h3>

            <div class="card-tools">
              <div class="input-group input-group-sm" style="width: 250px;">
                <label for></label>
                <select @change="populateVehicle" class="form-control" name id v-model="rpp">
                  <option v-for="(item,index) in ppi" :key="index">{{item}}</option>
                </select>&nbsp;
                <input
                v-model="search_str"
                @input="isEmpty(search_str)"
                  type="text"
                  name="table_search"
                  class="form-control float-right"
                  placeholder="Search"
                />

                <div class="input-group-append">
                  <button type="submit" class="btn btn-default" @click="populateInitialData">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0" style="height: 550px;">
            <table class="table table-head-fixed">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">Vehicle No</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(vehicle,index) in vehicles.data" :key="index">
                  <td class="text-center">{{vehicle.id}}</td>
                  <td class="text-center">{{vehicle.name}}</td>
                  <td class="text-center">{{vehicle.reg_no}}</td>
                  <td class="text-center"> 
                   <span v-if="vehicle.status_id == 1" class="badge badge-success">{{vehicle.status}}</span> 
                   <span v-if="vehicle.status_id == 2" class="badge badge-danger">{{vehicle.status}}</span>
                  </td> 
                  <td class="text-center">
                    <button
                      type="button"
                      @click="setVehicleToUpdate(vehicle)"
                      class="btn btn-primary"
                    >Edit</button>
                    <button
                      type="button"
                      @click="deleteVehicle(vehicle)"
                      class="btn btn-danger"
                    >Delete</button>
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
              :data="vehicles"
              @pagination-change-page="populateVehicle"
            ></pagination>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      id: "",
      vname: "",
      regNo: null,
      manufacture_year: "",
      registered_year: "",
      selected_vehicle_type:null,
      Vehicle_types: [],
      paginate_count: 10,
      years: [],
      selectedVehicleStatus:null,
      VehicleStatus: [],
      errors: [],
      vehicles: [],
      status:[],
      isEdit: false,
      load_data: true,
      rpp:10,
      search_str:null,
      ppi:[]

    };
  },
  mounted() {
    this.populateInitialData();
    this.itemPerPage();
    //this.populateVehicle();
    
  },
  methods: {
    resetForm() {
      this.isEdit = false;
      this.id = "";
      this.vname = "";
      this.regNo= null,
      this.manufacture_year= "",
      this.registered_year= "",
      this.selected_vehicle_type = null; 
      this.selectedVehicleStatus = null; 
      this.errors = [];
      this.populateVehicle();
    },

    createVehicle() {
      axios
        .post("/create/vehicle", {
          name: this.vname,
          reg_no: this.regNo,
          reg_year:this.registered_year,
          manf_year:this.manufacture_year,
          vehicle_type_id: this.selected_vehicle_type.id,
          status_id:this.selectedVehicleStatus.id, 
        })
        .then(res => {
          if (res.status == 200) {
            if (res.data == "Success") {
              Vue.notify({
                group: "foo",
                type: "success",
                title: "Important message",
                text: "Vehicle create success!"
              }),
                this.resetForm();
            } else {
              Vue.notify({
                group: "foo",
                type: "warn",
                title: "Important message",
                text: "Vehicle create fail!"
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
    },

    
    itemPerPage() {
      axios.get("/prp").then(res => {
        if (res.status == 200) {
          this.ppi = res.data;
        }
      });
    },

    isEmpty(x)
    {
      if(x == '')
      this.populateVehicle();
    },

    populateInitialData(page = 1)
    { 
      this.load_data = true
        axios.post("/populate/all/data?page=" + page,{
          rpp:this.rpp,
          search_str:this.search_str
        }).then(res => {
        if (res.status == 200) {
          this.vehicles = res.data["vehicle_list"];
          this.Vehicle_types = res.data["vehicle_type"];
          this.years = res.data['years'];
          this.VehicleStatus = res.data['status'];
          console.log(this.vehicles);
          this.load_data = false;
        }
      });
    },

    populateVehicle(page = 1) {
      axios.get("/populate/vehicles/" + this.paginate_count).then(res => {
        if (res.status == 200) {
          this.vehicles = res.data;
          console.log(this.vehicles);
          this.load_data = false;
        }
      });
    },

    setVehicleToUpdate(Vehicle) {console.log(Vehicle);
      this.isEdit = true;
      this.id = Vehicle.id;
      this.vname = Vehicle.name;
      this.regNo = Vehicle.reg_no;
      this.manufacture_year= Vehicle.manf_year;
      this.registered_year= Vehicle.reg_year;
      this.selected_vehicle_type = {"id":Vehicle.vehicle_type_id,"type_code":Vehicle.type_code};
      this.selectedVehicleStatus = {"id":Vehicle.status_id,"status":Vehicle.status}; 
      
    },

    updateVehicle() {
      axios
        .post("/update/vehicle", {
          id: this.id,
          name: this.vname,
          reg_no: this.regNo,
          reg_year:this.registered_year,
          manf_year:this.manufacture_year,
          vehicle_type_id: this.selected_vehicle_type.id,
          status_id:this.selectedVehicleStatus.id, 
        })
        .then(res => {
          console.log(res);
          if (res.status == 200) {
            if (res.data == "Success") {
              Vue.notify({
                group: "foo",
                type: "success",
                title: "Important message",
                text: "Vehicle update success!"
              }),
                this.resetForm();
            } else {
              Vue.notify({
                group: "foo",
                type: "warn",
                title: "Important message",
                text: "Vehicle update fail!"
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
    },

    deleteVehicle(vehicle) {
      this.$confirm("Are you sure?").then(() => {
        axios
          .get("/delete/vehicle/" + vehicle.id)
          .then(res => {
            console.log(res);
            if (res.status == 200) {
              if (res.data == "Success") {
                Vue.notify({
                  group: "foo",
                  type: "success",
                  title: "Important message",
                  text: "Vehicle deleted success!"
                }),
                  this.resetForm();
              } else {
                Vue.notify({
                  group: "foo",
                  type: "warn",
                  title: "Important message",
                  text: "Vehicle delete fail!"
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