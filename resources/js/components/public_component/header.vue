<template>
  <div>
    <notifications group="foo" />
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#">
            <i class="fas fa-bars"></i>
          </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="/" class="nav-link">Home</a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
          <a href="/" class="nav-link">Contact</a>
        </li>
      </ul>

      <!-- SEARCH FORM -->
      <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
          <input
            class="form-control form-control-navbar"
            type="search"
            placeholder="Search"
            aria-label="Search"
          />
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
          <a
            href
            @click="logout"
            class="nav-link dropdown-toggle"
            data-toggle="dropdown"
            aria-expanded="false"
          >
            <img
              src="dist/img/user2-160x160.jpg"
              class="user-image img-circle elevation-2"
              alt="User Image"
            />
            Sign Out
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->
  </div>
</template>
<script>
export default {
  data: () => ({
    csrf: document
      .querySelector('meta[name="csrf-token"]')
      .getAttribute("content")
  }),
  methods: {
    logout: function() {
     
      this.$confirm("Are you sure?").then(() => {
        axios
          .post("logout")
          .then(response => {
              
            if (response.status === 302 || 401) {
              
            } else {
              // throw error and go to catch block
            }
          })
          .catch(error => {
             location.reload();
          });
      });
    }
  }
};
</script>