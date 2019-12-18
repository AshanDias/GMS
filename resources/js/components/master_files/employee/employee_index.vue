<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1><i class="nav-icon fas fa-user-friends"></i>&nbsp;Employee</h1>
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
                  <input type="text" class="form-control" name id />
                  <span>
                    <p class="text-danger">This feild can't be empty</p>
                  </span>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Last Name</label>
                  <input type="text" class="form-control" name id />
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row form-group float-right">
              <button type="button" class="btn btn-danger btn-sm">Cancel</button>&nbsp;
              <button type="button" class="btn btn-success btn-sm">Submit</button>
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
                  <th>#</th>
                  <th>User</th>
                  <th>Date</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>183</td>
                  <td>John Doe</td>
                  <td>11-7-2014</td>
                  <td>
                    <span class="tag tag-success">Approved</span>
                  </td>
                </tr>
                <tr>
                  <td>219</td>
                  <td>Alexander Pierce</td>
                  <td>11-7-2014</td>
                  <td>
                    <span class="tag tag-warning">Pending</span>
                  </td>
                </tr>
                <tr>
                  <td>657</td>
                  <td>Bob Doe</td>
                  <td>11-7-2014</td>
                  <td>
                    <span class="tag tag-primary">Approved</span>
                  </td>
                </tr>
                <tr>
                  <td>175</td>
                  <td>Mike Doe</td>
                  <td>11-7-2014</td>
                  <td>
                    <span class="tag tag-danger">Denied</span>
                  </td>
                </tr>
                <tr>
                  <td>134</td>
                  <td>Jim Doe</td>
                  <td>11-7-2014</td>
                  <td>
                    <span class="tag tag-success">Approved</span>
                  </td>
                </tr>
                <tr>
                  <td>494</td>
                  <td>Victoria Doe</td>
                  <td>11-7-2014</td>
                  <td>
                    <span class="tag tag-warning">Pending</span>
                  </td>
                </tr>
                <tr>
                  <td>832</td>
                  <td>Michael Doe</td>
                  <td>11-7-2014</td>
                  <td>
                    <span class="tag tag-primary">Approved</span>
                  </td>
                </tr>
                <tr>
                  <td>982</td>
                  <td>Rocky Doe</td>
                  <td>11-7-2014</td>
                  <td>
                    <span class="tag tag-danger">Denied</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->

          <!-- /.card -->
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {};
</script>