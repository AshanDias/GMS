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
                  <th class="text-center">Customer Name</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">Area</th>                   	
                  <th class="text-center">Address</th>
                  <th class="text-center">Address 2</th>
                  <th class="text-center">Address 3</th>
                  <th class="text-center">Category</th> 
                  <th class="text-center">Status</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="request in requests.data" :key="request.id">
                  <td class="text-center">{{request.id}}</td>
                  <td class="text-center">{{request.customer_name}}</td>
                  <td class="text-center">{{request.email}}</td>
                  <td class="text-center">{{request.area_name}}</td>
                  <td v-if="request.address_1 != 'null'" class="text-center">{{request.address_1}}</td>
                   <td v-else class="text-center">-</td>
                    <td v-if="request.address_2 != 'null'" class="text-center">{{request.address_2}}</td>
                   <td v-else class="text-center">-</td>
                  <td v-if="request.address_3 != 'null'" class="text-center">{{request.address_3}}</td>
                   <td v-else class="text-center">-</td>
                  <td class="text-center">{{request.category_name}}</td>
                  <td class="text-center">{{request.status}}</td>
                  <td class="text-center">                  
                    <button type="button"  class="btn btn-danger">Delete</button>
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
      requests: [],
      isEdit: false,
      cmfPwd: false,
      load_data:true
    };
  },
  mounted() {
    this.populateRequest();
  },
  methods: {
   
    populateRequest(page = 1) {
      axios.get("/customer/request/" + this.paginate_count).then(res => {
        if (res.status == 200) {
            console.log(res.data);
          this.requests = res.data;
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