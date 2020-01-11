<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>
                <i class="nav-icon fas fa-user-friends"></i>&nbsp;Employee
              </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <router-link to="/">Master Files</router-link>
                </li>
                <li class="breadcrumb-item active">Employee</li>
              </ol>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </section>
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Create new employee</h3>

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
                  <label>First Name</label>
                  <input
                    type="text"
                    class="form-control"
                    name
                    id
                    required
                    v-model="empFName"
                    placeholder="Employee name"
                  />
                  <span v-if="errors.first_name">
                    <p class="text-danger">{{errors.first_name[0]}}</p>
                  </span>
                </div>
                <div class="form-group">
                  <label>Type</label>
                  &nbsp;
                  <div>
                    <multiselect
                      v-model="selectedEmployeeType"
                      deselect-label="Can't remove this value"
                      track-by="id"
                      label="name"
                      placeholder="Select one"
                      :options="EmployeeType"
                      :searchable="false"
                      :allow-empty="false"
                      required
                    ></multiselect>
                  </div>
                  <span v-if="errors.employee_type_id">
                    <p class="text-danger">{{errors.employee_type_id[0]}}</p>
                  </span>
                </div>
                <div class="form-group">
                  <label>NIC</label>
                  &nbsp;
                  <input
                    type="number"
                    class="form-control"
                    name
                    id
                    required
                    v-model="nic"
                    placeholder="Employee NIC"
                  />
                  <span v-if="errors.nic">
                    <p class="text-danger">{{errors.nic[0]}}</p>
                  </span>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Last Name</label>
                  <input
                    type="text"
                    class="form-control"
                    name
                    id
                    required
                    v-model="empLName"
                    placeholder="Employee name"
                  />
                  <span v-if="errors.last_name">
                    <p class="text-danger">{{errors.last_name[0]}}</p>
                  </span>
                </div>
                <div class="form-group">
                  <label>Telephone No</label>
                  <input
                    type="number"
                    class="form-control"
                    name
                    id
                    required
                    v-model="teleNo"
                    placeholder="Employee name"
                  />
                  <span v-if="errors.telephone_no">
                    <p class="text-danger">{{errors.telephone_no[0]}}</p>
                  </span>
                </div>
                <!-- /.form-group -->
                  <div class="form-group">
                  <label>Status</label>
                  &nbsp;
                  <div>
                    <multiselect
                      v-model="selectedEmployeeStatus"
                      deselect-label="Can't remove this value"
                      track-by="id"
                      label="name"
                      placeholder="Select one"
                      :options="EmployeeStatus"
                      :searchable="false"
                      :allow-empty="false"
                      required
                    ></multiselect>
                  </div>
                 
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="form-group float-right pt-4">
              <button type="button" @click="resetForm" class="btn btn-danger btn-sm">Cancel</button>&nbsp;
              <button
                v-if="isEdit == false"
                type="button"
                @click="createEmployee"
                class="btn btn-success btn-sm"
              >Submit</button>
              <button
                v-if="isEdit"
                type="button"
                @click="updateEmployee"
                class="btn btn-primary btn-sm"
              >Update</button>
            </div>

            <!-- /.form-group -->
          </div>
          <!-- /.card-body -->
        </div>

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Employee List</h3>

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
                  <th class="text-center">Employee NIC</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(Employee,index) in Employees.data" :key="index">
                  <td class="text-center">{{Employee.id}}</td>
                  <td class="text-center">{{Employee.first_name}} {{Employee.last_name}}</td>
                  <td class="text-center">{{Employee.nic}}</td>                  
                  <td class="text-center">
                   <span v-if="Employee.status_id == 1" class="badge badge-success">{{Employee.status}}</span> 
                   <span v-if="Employee.status_id == 2" class="badge badge-danger">{{Employee.status}}</span>
                  </td>
                  <td class="text-center">
                    <button
                      type="button"
                      @click="setEmployeeToUpdate(Employee)"
                      class="btn btn-primary"
                    >Edit</button>
                    <button
                      type="button"
                      @click="deleteEmployee(Employee)"
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
      empFName: "",
      empLName: "",
      nic: null,
      teleNo: null,
      Employee_type: "",
      paginate_count: 10,
      errors: [],
      Employees: [],
      EmployeeType: [{ id: 4, name: "Driver" }, { id: 5, name: "Worker" }],
      selectedEmployeeType: {id: 4, name: "Driver" },
      EmployeeStatus: [{ id: 1, name: "Active" }, { id: 2, name: "Deactive" }],
      selectedEmployeeStatus: { id: 1, name: "Active" },
      isEdit: false,
      load_data: true,
    };
  },
  mounted() {
    this.populateEmployee();
  },
  methods: {
    resetForm() {
      this.isEdit = false;
      this.id = "";
      (this.empFName = ""), (this.empLName = ""), (this.nic = "");
      (this.teleNo = ""), (this.Employee_type = "");
      this.errors = [];
      this.populateEmployee();
    },

    createEmployee() {
      axios
        .post("/create/employee", {
          first_name: this.empFName,
          last_name: this.empLName,
          nic: this.nic,
          telephone_no: this.teleNo,
          employee_type_id:this.selectedEmployeeType.id,
          status_id:this.selectedEmployeeStatus.id
        })
        .then(res => {
          if (res.status == 200) {
            if (res.data == "Success") {
              Vue.notify({
                group: "foo",
                type: "success",
                title: "Important message",
                text: "Employee create success!"
              }),
                this.resetForm();
            } else {
              Vue.notify({
                group: "foo",
                type: "warn",
                title: "Important message",
                text: "Employee create fail!"
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

    populateEmployee(page = 1) {
      axios.get("/populate/employees/" + this.paginate_count).then(res => {
        if (res.status == 200) {
          this.Employees = res.data;
          console.log(this.Employees);
          this.load_data = false;
        }
      });
    },

    setEmployeeToUpdate(Employee) {
      this.isEdit = true;
      this.id = Employee.id;
      this.empFName = Employee.first_name;
      this.empLName = Employee.last_name;
      this.nic = Employee.nic;
      this.teleNo = Employee.telephone_no;
      this.selectedEmployeeType.id = Employee.employee_type_id;
      this.selectedEmployeeStatus.id = Employee.status_id;
      console.log(Employee);
    },

    updateEmployee() {
      axios
        .post("/update/employee", {
          id: this.id,
          first_name: this.empFName,
          last_name: this.empLName,
          nic: this.nic,
          telephone_no: this.teleNo,
          employee_type_id:this.selectedEmployeeType.id,
          status_id:this.selectedEmployeeStatus.id
        })
        .then(res => {
          console.log(res);
          if (res.status == 200) {
            if (res.data == "Success") {
              Vue.notify({
                group: "foo",
                type: "success",
                title: "Important message",
                text: "Employee update success!"
              }),
                this.resetForm();
            } else {
              Vue.notify({
                group: "foo",
                type: "warn",
                title: "Important message",
                text: "Employee update fail!"
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

    deleteEmployee(Employee) {
      this.$confirm("Are you sure?").then(() => {
        axios
          .get("/delete/employee/" + Employee.id)
          .then(res => {
            console.log(res);
            if (res.status == 200) {
              if (res.data == "Success") {
                Vue.notify({
                  group: "foo",
                  type: "success",
                  title: "Important message",
                  text: "Employee deleted success!"
                }),
                  this.resetForm();
              } else {
                Vue.notify({
                  group: "foo",
                  type: "warn",
                  title: "Important message",
                  text: "Employee delete fail!"
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