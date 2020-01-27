<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>
                <i class="nav-icon fas fa-tractor"></i>&nbsp;Area Payment
              </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <router-link to="/">Operation Files</router-link>
                </li>
                <li class="breadcrumb-item active">Area Payment</li>
              </ol>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </section>
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Create new Area Payment</h3>

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
              <div class="col-md-4">
                <div class="form-group">
                  <label>Area</label>
                  &nbsp;
                  <div v-if="isEdit">
                    <multiselect
                      disabled
                      v-model="selected_area"
                      deselect-label="Can't remove this value"
                      track-by="id"
                      label="name"
                      placeholder="Select one"
                      :options="areas"
                      :searchable="true"
                      :allow-empty="false"
                    ></multiselect>
                  </div>
                  <div v-else>
                    <multiselect
                      v-model="selected_area"
                      deselect-label="Can't remove this value"
                      track-by="id"
                      label="name"
                      placeholder="Select one"
                      :options="areas"
                      :searchable="true"
                      :allow-empty="false"
                    ></multiselect>
                  </div>
                  <span v-if="errors.id">
                    <p class="text-danger">{{errors.id[0]}}</p>
                  </span>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <div class="form-group">
                  <label>Area Price</label>
                  &nbsp;
                  <input
                    type="number"
                    class="form-control"
                    v-model="price"
                    placeholder="Area Price"
                  />
                </div>
                <span v-if="errors.price">
                  <p class="text-danger">{{errors.price[0]}}</p>
                </span>
                <!-- <div class="form-group">
                  <label>Vehicle Type</label>
                  &nbsp;
                  <input
                    type="text"
                    disabled
                    class="form-control"
                    v-model="vType"
                    placeholder="Vehicle Type"
                  />
                </div>-->
              </div>
              <!-- <div class="col-md-4">
                <div class="form-group">
                  <label>Vehicle Price</label>
                  &nbsp;
                  <input
                    type="number"
                    class="form-control"
                    v-model="price"
                    placeholder="Vehicle Price"
                  />
                </div>
              </div>-->
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="form-group float-right pt-4">
              <button type="button" @click="resetForm" class="btn btn-danger btn-sm">Cancel</button>&nbsp;
              <button
                v-if="isEdit == false"
                type="button"
                @click="createPayment"
                class="btn btn-success btn-sm"
              >Submit</button>
              <button
                v-if="isEdit"
                type="button"
                @click="updateAreaPayment"
                class="btn btn-primary btn-sm"
              >Update</button>
            </div>

            <!-- /.form-group -->
          </div>
          <!-- /.card-body -->
        </div>

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Area Payment List</h3>

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
                  <th class="text-center">Area</th>
                  <th class="text-center">Price</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(payment,index) in payments.data" :key="index">
                  <td class="text-center">{{payment.pid}}</td>
                  <td class="text-center">{{payment.name}}</td>
                  <td class="text-center">{{payment.price}}</td>
                  <td class="text-center">
                    <button
                      type="button"
                      @click="setPaymentToUpdate(payment)"
                      class="btn btn-primary"
                    >Edit</button>
                    <button
                      type="button"
                      @click="deletePayment(payment)"
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
      regNo: null,
      vType: null,
      price: null,
      selected_area: null,
      paginate_count: 10,
      errors: [],
      areas: [],
      status: [],
      payments: [],
      isEdit: false,
      load_data: true
    };
  },
  mounted() {
    this.populateInitialData();
    //this.populateVehicle();
  },
  methods: {
    resetForm() {
      this.isEdit = false;
      this.id = "";
      this.selected_area = null;
      this.errors = [];
      this.price = null;
      this.populateInitialData();
    },

    createPayment() {
      console.log(this.selected_area);
      axios
        .post("/assign/area/payment/post", {
          id: this.selected_area.id,
          price: this.price
        })
        .then(res => {
          if (res.status == 200) {
            if (res.data == "Success") {
              Vue.notify({
                group: "foo",
                type: "success",
                title: "Important message",
                text: "Payment added success!"
              }),
                this.resetForm();
            } else {
              Vue.notify({
                group: "foo",
                type: "warn",
                title: "Important message",
                text: "Payment added fail!"
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
      axios
        .get("/populate/area/payment/data/get/" + this.paginate_count)
        .then(res => {
          if (res.status == 200) {
            this.areas = res.data["areadata"];
            this.payments = res.data["payments"];
            console.log(this.vehicle_types);
            this.load_data = false;
          }
        });
    },
    setPaymentToUpdate(payment) {
      this.isEdit = true;
      this.id = payment.pid;
      this.selected_area = payment;
      this.price = payment.price;
      console.log(payment);
    },

    updateAreaPayment() {
      axios
        .post("/update/area/payment/post", {
          id: this.id,
          price: this.price
        })
        .then(res => {
          console.log(res);
          if (res.status == 200) {
            if (res.data == "Success") {
              Vue.notify({
                group: "foo",
                type: "success",
                title: "Important message",
                text: "Payment update success!"
              }),
                this.resetForm();
            } else {
              Vue.notify({
                group: "foo",
                type: "warn",
                title: "Important message",
                text: "Payment update fail!"
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

    deletePayment(payment) {
      this.$confirm("Are you sure?").then(() => {
        axios
          .get("/delete/area/payment/get/" + payment.id)
          .then(res => {
            console.log(res);
            if (res.status == 200) {
              if (res.data == "Success") {
                Vue.notify({
                  group: "foo",
                  type: "success",
                  title: "Important message",
                  text: "Payment deleted success!"
                }),
                  this.resetForm();
              } else {
                Vue.notify({
                  group: "foo",
                  type: "warn",
                  title: "Important message",
                  text: "Payment delete fail!"
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