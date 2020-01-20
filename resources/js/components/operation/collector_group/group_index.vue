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
                      label="reg_no"
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
                      v-model="selectedDriver"
                      deselect-label="Can't remove this value"
                      track-by="id"
                      label="name"
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
                @click="createGroup"
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

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Employee Group List</h3>

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
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0" style="height: 500px;">
            <table class="table table-head-fixed">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Group Code</th>
                  <th class="text-center">Driver</th>
                  <th class="text-center">Group Members</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(group,index) in collector_group_with_members" :key="index">
                  <td class="text-center">{{group.collector_group[0].id}}</td>
                  <td class="text-center">{{group.collector_group[0].group_code}}</td>
                  <td class="text-center">{{group.collector_group[0].name}}</td>
                  <td class="row">
                    <div v-for="(members,index) in group.group_member" :key="index">
                      <span
                        class="badge badge-success text-center"
                      >{{members.name}}</span>&nbsp;
                    </div>
                  </td>
                  <td class="text-center">
                    <button
                      type="button"
                      @click="setGroupToUpdate(group)"
                      class="btn btn-primary"
                    >Edit</button>
                    <button
                      type="button"
                      @click="deleteVehicle(group)"
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

          <!-- /.card -->
        </div>
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
      selectedDriver: null,
      drivers: [],
      workers: [],
      groups: [],
      selectedVehicle: null,
      vehicles: [],
      paginate_count: 10,
      errors: [],
      status: [],
      isEdit: false,
      load_data: true,
      selectedWorkers: [],
      collector_group_with_members: []
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
      this.group_code = "";
      this.selectedDriver = null;
      this.selectedVehicle = null;
      this.errors = [];
      this.populateInitialData();
    },

    createGroup() {
      axios
        .post("/create/employee/group", {
          group_code: this.group_code,
          driver_id: this.selectedDriver.id,
          vehicle_id: this.selectedVehicle.id,
          selectedWorkers: this.selectedWorkers
        })
        .then(res => {
          if (res.status == 200) {
            if (res.data == "Success") {
              Vue.notify({
                group: "foo",
                type: "success",
                title: "Important message",
                text: "Employee Group create success!"
              }),
                this.resetForm();
            } else if ((red.data = "Fail")) {
              Vue.notify({
                group: "foo",
                type: "warn",
                title: "Important message",
                text: "Employee Group create fail!"
              });
            } else if ((red.data = "exception")) {
              Vue.notify({
                group: "foo",
                type: "warn",
                title: "Important message",
                text: red.data["exception"]
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
          this.vehicles = res.data["vehicles"];
          this.collector_group_with_members =
            res.data["collector_group_with_members"];
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

    setGroupToUpdate(group) {
      console.log(group.collector_group);
      this.isEdit = true;
      this.selectedDriver = {"id":group.collector_group[0].driver_id,"name":group.collector_group[0].name};
      this.selectedVehicle = {"id":group.collector_group[0].vehicle_id,"reg_no":group.collector_group[0].reg_no};
      this.group_code = group.collector_group[0].group_code;
      this.workers = group.group_member;
      // 
      // this.id = Vehicle.id;
      // this.vname = Vehicle.name;
      // this.regNo = Vehicle.reg_no;
      // this.manufacture_year = Vehicle.manf_year;
      // this.registered_year = Vehicle.reg_year;
      // this.selected_vehicle_type.id = Vehicle.vehicle_type_id;
      // this.selected_vehicle_type.type_code = Vehicle.type_code;
      // this.selectedVehicleStatus.id = Vehicle.status_id;
      // this.selectedVehicleStatus.status = Vehicle.status;
      // console.log(Vehicle);
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