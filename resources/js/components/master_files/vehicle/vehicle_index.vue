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
                <div class="form-group">
                  <label>Name</label>
                  <input
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
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group p-0 m-0">
                  <label>Vehicle No</label>
                  &nbsp;
                  <input
                    type="text"
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
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
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
                    <span class="tag tag-success">{{vehicle.status}}</span>
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
      regNo: "",
      Vehicle_type: "",
      paginate_count: 10,
      errors: [],
      vehicles: [],
      isEdit: false,
      load_data: true
    };
  },
  mounted() {
    this.populateVehicle();
  },
  methods: {
    resetForm() {
      this.isEdit = false;
      this.id = "";
      this.vname = "";
      this.regNo = "";
      this.Vehicle_type = "";
      this.errors = [];
      this.populateVehicle();
    },

    createVehicle() {
      axios
        .post("/create/vehicle", {
          name: this.vname,
          reg_no: this.regNo,
          vehicle_type: this.Vehicle_type
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

    populateVehicle(page = 1) {
      axios.get("/populate/vehicles/" + this.paginate_count).then(res => {
        if (res.status == 200) {
          this.vehicles = res.data;
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
      console.log(Vehicle);
    },

    updateVehicle() {
      axios
        .post("/update/vehicle", {
          id: this.id,
          name: this.vname,
          reg_no: this.regNo,
          Vehicle_type: this.Vehicle_type,
          password: this.password
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