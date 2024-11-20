<template>
    <nav style="" class="mt-2">
      <ul style="background-color: red !important;" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Dashboard -->
        <li class="nav-item">
          <router-link to="/dashboard" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt blue"></i>
            <p>Dashboard</p>
          </router-link>
        </li>

        <!-- Products -->
        <li class="nav-item">
          <router-link to="/products" class="nav-link">
            <i class="nav-icon fas fa-list orange"></i>
            <p>Product</p>
          </router-link>
        </li>

        <!-- Users (Admin only) -->
        <li  class="nav-item">
          <router-link to="/users" class="nav-link">
            <i class="fa fa-users nav-icon blue"></i>
            <p>Users</p>
          </router-link>
        </li>

        <!-- Settings (Admin only) -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cog green"></i>
            <p>
              Settings
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <router-link to="/product/category" class="nav-link">
                <i class="nav-icon fas fa-list-ol green"></i>
                <p>Category</p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/product/tag" class="nav-link">
                <i class="nav-icon fas fa-tags green"></i>
                <p>Tags</p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/developer" class="nav-link">
                <i class="nav-icon fas fa-cogs white"></i>
                <p>Developer</p>
              </router-link>
            </li>
          </ul>
        </li>

        <!-- Logout -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-power-off red"></i>
            <p></p>
          </a>
        </li>
      </ul>
    </nav>
  </template>

  <script>
  export default {
    name: 'Sidebar',

  };
  </script>

  <style scoped>
  /* Adicione seus estilos personalizados aqui */
  </style>
