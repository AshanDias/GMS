<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>
                <i class="nav-icon fas fa-tractor"></i>&nbsp;Collector Groups
              </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <router-link to="/">Operation</router-link>
                </li>
                <li class="breadcrumb-item active">Collector Groups</li>
              </ol>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </section>
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Create new Group</h3>

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
                <div class="form-group">
                  <label>Group Code</label>
                  <input
                    required
                    type="text"
                    class="form-control"
                    name
                    id
                    v-model="group_code"
                    placeholder="Group Code"
                  />
                  <span v-if="errors.name">
                    <p class="text-danger">{{errors.name[0]}}</p>
                  </span>
                </div>
                <div class="form-group">
                  <label>Vehicle</label>
                    &nbsp;
                  <div>
                    <multiselect
                      v-model="selectedVehicle"
                      deselect-label="Can't remove this value"
                      track-by="id"
                      label="name"
                      placeholder="Select one"
                      :options="vehicles"
                      :searchable="false"
                      :allow-empty="false"
                      required
                    ></multiselect>
                  </div>
                  <span v-if="errors.name">
                    <p class="text-danger">{{errors.name[0]}}</p>
                  </span>
                </div>
              </div>
              <!-- /.form-group -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Driver</label>
                  &nbsp;
                  <div>
                    <multiselect
                      v-model="driver"
                      deselect-label="Can't remove this value"
                      track-by="id"
                      label="first_name"
                      placeholder="Select one"
                      :options="drivers"
                      :searchable="false"
                      :allow-empty="false"
                      required
                    ></multiselect>
                  </div>
                </div>
              </div>
            </div>
            <DualListBox
              :source="workers"
              :destination="selectedWorkers"
              label="name"
              @onChangeList="onChangeList"
            />
                 <div class="form-group float-right pt-4">
              <button type="button" @click="resetForm" class="btn btn-danger btn-sm">Cancel</button>&nbsp;
              <button
                v-if="isEdit == false"
                type="button"
                @click="createVehicle"
                class="btn btn-success btn-sm"
              >Submit</button>
              <button
                v-if="isEdit"
                type="button"
                @click="updateVehicle"
                class="btn btn-primary btn-sm"
              >Update</button>
            </div>

          </div>
          <!-- /.card-body -->
          
        </div>

        <!-- <div class="card">
          <div class="card-header">
            <h3 class="card-title">Vehicle List</h3>

            <div class="card-tools">
              <div class="input-group input-group-sm" style="width: 250px;">
                <label for></label>
                <select class="form-control" name id>
                  <option>10</option>
                  <option>50</option>
                  <option>100</option>
                </select>&nbsp;
                <input
                  type="text"
                  name="table_search"
                  class="form-control float-right"
                  placeholder="Search"
                />

                <div class="input-group-append">
                  <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
            </div>
        </div>-->
        <!-- /.card-header -->
        <!-- <div class="card-body table-responsive p-0" style="height: 500px;">
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
                    <span
                      v-if="vehicle.status_id == 1"
                      class="badge badge-success"
                    >{{vehicle.status}}</span>
                    <span
                      v-if="vehicle.status_id == 2"
                      class="badge badge-danger"
                    >{{vehicle.status}}</span>
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
        </div>-->
        <!-- /.card-body -->

        <!-- /.card -->
        <!-- </div> -->
      </div>
    </div>
  </div>
</template>
<script>
import DualListBox from "dual-listbox-vue";
import "dual-listbox-vue/dist/dual-listbox.css";
export default {
  components: {
    DualListBox
  },
  data() {
    return {
      id: "",
      group_code: "",
      driver: "",
      drivers: [],
      workers: [],
      groups: [],
      selectedVehicle:null,
      vehicles:[],
      paginate_count: 10,
      errors: [],
      status: [],
      isEdit: false,
      load_data: true,
      selectedWorkers: []
    };
  },
  mounted() {
    this.populateInitialData();
    //this.populateVehicle();
  },
  methods: {
    onChangeList: function({ source, destination }) {
      this.workers = source;
      this.selectedWorkers = destination;
    },

    resetForm() {
      this.isEdit = false;
      this.id = "";
      this.vname = "";
      (this.regNo = null),
        (this.manufacture_year = ""),
        (this.registered_year = ""),
        (this.selected_vehicle_type.id = null);
      this.selected_vehicle_type.type_code = null;
      this.selectedVehicleStatus.id = null;
      this.selectedVehicleStatus.status = null;
      this.errors = [];
      this.populateVehicle();
    },

    createVehicle() {
      axios
        .post("/create/vehicle", {
          name: this.vname,
          reg_no: this.regNo,
          reg_year: this.registered_year,
          manf_year: this.manufacture_year,
          vehicle_type_id: this.selected_vehicle_type.id,
          status_id: this.selectedVehicleStatus.id
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

    populateInitialData() {
      axios.get("/collector/groups/" + this.paginate_count).then(res => {
        if (res.status == 200) {
          this.drivers = res.data["drivers"];
          this.workers = res.data["workers"];
          this.groups = res.data["groups"];
          this.vehicles = res.data["vehicles"]
          console.log(this.vehicles);
          this.load_data = false;
        }
      });
    },

    populateVehicle(page = 1) {
      axios.get("/populate/vehicles/" + this.paginate_count).then(res => {
        if (res.status == 200) {
          this.drivers = res.data;

          console.log(this.vehicles);
          this.load_data = false;
        }
      });
    },

    setVehicleToUpdate(Vehicle) {
      this.isEdit = true;
      this.id = Vehicle.id;
      this.vname = Vehicle.name;
      this.regNo = Vehicle.reg_no;
      this.manufacture_year = Vehicle.manf_year;
      this.registered_year = Vehicle.reg_year;
      this.selected_vehicle_type.id = Vehicle.vehicle_type_id;
      this.selected_vehicle_type.type_code = Vehicle.type_code;
      this.selectedVehicleStatus.id = Vehicle.status_id;
      this.selectedVehicleStatus.status = Vehicle.status;
      console.log(Vehicle);
    },

    updateVehicle() {
      axios
        .post("/update/vehicle", {
          id: this.id,
          name: this.vname,
          reg_no: this.regNo,
          reg_year: this.registered_year,
          manf_year: this.manufacture_year,
          vehicle_type_id: this.selected_vehicle_type.id,
          status_id: this.selectedVehicleStatus.id
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