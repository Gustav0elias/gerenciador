<template>
    <div class="wrapper">
      <nav v-if="showLayout" class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
          </li>
        </ul>

      </nav>

      <aside v-if="showLayout" style="background: linear-gradient(135deg, #013668, #3470AF);" class="main-sidebar sidebar-dark-primary elevation-4">
        <router-link to="/dashboard" class="brand-link">
          <span class="brand-text font-weight-light"></span>
        </router-link>
        <div class="sidebar">
          <router-link to="/profile">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                <span style="font-size: 1rem; font-weight: bold;">GUSTAVO ELIAS</span>
              </div>
            </div>
          </router-link>
          <sidebar-menu></sidebar-menu>
        </div>
      </aside>

      <div class="content-wrapper">
        <router-view></router-view>
        <vue-progress-bar></vue-progress-bar>
      </div>
    </div>
  </template>

  <script>
  import SidebarMenu from './components/SidebarMenu.vue';
  import VueProgressBar from 'vue-progressbar';
  import axios from "axios";

  export default {
    name: 'App',
    components: {
      SidebarMenu,
      VueProgressBar,
    },
    data() {
      return {
        backgroundColor: '#ffffff',
      };
    },
    computed: {
      showLayout() {
        return this.$route.name !== 'Login';
      },
    },
    mounted() {
      this.fetchConfiguration();
    },
    methods: {
      fetchConfiguration() {
        axios.get('/api/global-configuration')
          .then(response => {
            const color = response.data.background_color || '#ffffff';
            this.updateCSSVariable(color);
          })
          .catch(error => {
            console.error('Erro ao carregar configuração', error);
          });
      },
      updateCSSVariable(newColor) {
        document.documentElement.style.setProperty('--content-wrapper-bg', newColor);
      },
    },
  };
  </script>


