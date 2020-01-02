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
      <!-- Modal -->
      <div
        class="modal fade"
        id="modelId"
        tabindex="-1"
        role="dialog"
        aria-labelledby="modelTitleId"
        aria-hidden="true"
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="container-fluid">
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" name id v-model="password" />
                  <span v-if="errors.password">
                    <p class="text-danger">{{errors.password[0]}}</p>
                  </span>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label>Confirm Password</label>
                  <input
                    type="password"
                    class="form-control"
                    name
                    id
                    v-model="cmf_password"
                    @keyup="cmfPassword"
                  />
                </div>

                <!-- /.form-group -->
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button
                type="button"
                class="btn btn-primary"
                data-dismiss="modal"
                :disabled="cmfPwd != true"
                @click="updateUser"
              >Save</button>
            </div>
          </div>
        </div>
      </div>

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
              <div class="col-md-4">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" name id v-model="name" />
                  <span v-if="errors.name">
                    <p class="text-danger">{{errors.name[0]}}</p>
                  </span>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <div class="form-group">
                  <label>Email</label>
                  <input
                    type="email"
                    v-if="isEdit == false"
                    class="form-control"
                    name
                    id
                    v-model="email"
                  />
                  <input
                    type="email"
                    v-if="isEdit"
                    disabled
                    class="form-control"
                    name
                    id
                    v-model="email"
                  />
                  <span v-if="errors.email">
                    <p class="text-danger">{{errors.email[0]}}</p>
                  </span>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <div class="form-group">
                  <label>User Type</label>
                  <select class="form-control" name id v-model="user_type">
                    <option class="form-control" value="Admin">Admin</option>
                    <option class="form-control" value="super_admin">Super Admin</option>
                  </select>
                  <span v-if="errors.user_type">
                    <p class="text-danger">{{errors.user_type[0]}}</p>
                  </span>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row">
              <div class="col-md-4">
                <div v-if="isEdit == false" class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" name id v-model="password" />
                  <span v-if="errors.password">
                    <p class="text-danger">{{errors.password[0]}}</p>
                  </span>
                </div>
                <!-- /.form-group -->
                <!-- Button trigger modal -->
                <button
                  v-if="isEdit"
                  type="button"
                  class="btn btn-primary btn-sm"
                  data-toggle="modal"
                  data-target="#modelId"
                >Change Password</button>
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <div v-if="isEdit == false" class="form-group">
                  <label>Confirm Password</label>
                  <input type="password" class="form-control" name id v-model="cmf_password" @keyup="cmfPassword" />
                </div>
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <div class="form-group float-right pt-4">
                  <button type="button" @click="resetForm" class="btn btn-danger btn-sm">Cancel</button>&nbsp;
                  <button
                    v-if="isEdit == false"
                    type="button"
                    @click="createUser"
                    :disabled="cmfPwd != true"
                    class="btn btn-success btn-sm"
                  >Submit</button>
                  <button
                    v-if="isEdit"
                    type="button"
                    @click="updateUser"
                    class="btn btn-primary btn-sm"
                  >Update</button>
                </div>
              </div>
            </div>
            <!-- <div class="row form-group float-right">
              
            </div>-->
            <!-- /.form-group -->
          </div>
          <!-- /.card-body -->
        </div>

        <!-- Employee List -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Employee List</h3>

            <div class="card-tools">
              <div class="input-group input-group-sm" style="width: 250px;">
                <label for></label>
                <select class="form-control" name id v-model="paginate_count">
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
                  <th class="text-center">User</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">Type</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users.data" :key="user.id">
                  <td class="text-center">{{user.id}}</td>
                  <td class="text-center">{{user.name}}</td>
                  <td class="text-center">{{user.email}}</td>
                  <td class="text-center">{{user.user_type}}</td>
                  <td class="text-center">
                    <button
                      type="button"
                      @click="setUserToUpdate(user)"
                      class="btn btn-primary"
                    >Edit</button>
                    <button type="button" @click="deleteUser(user)" class="btn btn-danger">Delete</button>
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
             <!-- <pagination v-if="load_data==false" class="float-right" :limit="2" :data="bookings" 
                        @pagination-change-page="populateUser"></pagination> -->
          </div>
          <!-- /.card -->
        </div>
        <!-- Employee List End -->
      </div>
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
      paginate_count: 10,
      errors: [],
      users: [],
      isEdit: false,
      cmfPwd: false,
      load_data:true
    };
  },
  mounted() {
    this.populateUser();
  },
  methods: {
    resetForm() {
      this.isEdit = false;
      this.id = "";
      this.name = "";
      this.email = "";
      this.user_type = "";
      this.password = "";
      this.cmf_password = "";
      this.errors = [];
      this.cmfPwd = false;
      this.populateUser();
    },

    cmfPassword() {
      if (
        this.password == this.cmf_password &&
        (this.password.length > 7 && this.cmf_password.length > 7)
      ) {
        this.cmfPwd = true;
      } else this.cmfPwd = false;
    },

    createUser() {
      if (this.password != this.cmf_password) {
        Vue.notify({
          group: "foo",
          title: "Important message",
          text: "Your password not matched!"
        });
      } else {
        axios
          .post("/create/user", {
            name: this.name,
            email: this.email,
            user_type: this.user_type,
            password: this.password
          })
          .then(res => {
            if (res.status == 200) {
              if (res.data == "Success") {
                Vue.notify({
                  group: "foo",
                  type:'Success',
                  title: "Important message",
                  text: "User create success!"
                }),
                  this.resetForm();
              } else {
                Vue.notify({
                  group: "foo",
                  type:'warn',
                  title: "Important message",
                  text: "User create fail!"
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
    },

    populateUser(page = 1) {
      axios.get("/populate/users/" + this.paginate_count).then(res => {
        if (res.status == 200) {
          this.users = res.data;
          this.load_data = false;
        }
      });
    },

    setUserToUpdate(user) {
      this.isEdit = true;
      this.id = user.id;
      this.name = user.name;
      this.email = user.email;
      this.user_type = user.user_type;
      this.password = user.password;
      console.log(user);
    },

    updateUser() {
      if (this.cmfPwd != true) {
        Vue.notify({
          group: "foo",
          title: "Important message",
          text: "Your password not matched!"
        });
      } else {
        axios
          .post("/update/user", {
            id: this.id,
            name: this.name,
            email: this.email,
            user_type: this.user_type,
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
                  text: "User update success!"
                }),
                  this.resetForm();
              } else {
                Vue.notify({
                  group: "foo",
                  type: "warn",
                  title: "Important message",
                  text: "User update fail!"
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