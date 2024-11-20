import { createRouter, createWebHistory } from 'vue-router';
import AdminDashboard from './views/AdminDashboard.vue';
import ContasIndex from './views/ContasIndex.vue';
import PermissionsIndex from './views/PermissionsIndex.vue';
import UsersIndex from './views/UsersIndex.vue';
 import Login from './views/Login.vue';
import Configuracoes from './views/Configuracoes.vue';
import Cep from './views/ConsultarCep.vue';
import gpt from './views/ChatGpt.vue';

const routes = [
    {
      path: '/gerenciar-contas',
      name: 'ContasIndex',
      component: ContasIndex,
      meta: {  requiresPermission: ['visualizar valores de contas', 'visualizar inscrições específicas'] },
        },
    {
        path: '/gerenciar-permissoes',
        name: 'PermissionsIndex',
        component: PermissionsIndex,
        meta: { requiresRole: 'Master' },
      },

      {
        path: '/configuracoes',
        name: 'Configuracoes',
        component: Configuracoes,
        meta: { requiresRole: 'Master' },
      },

      {
        path: '/gerenciar-users',
        name: 'UsersIndex',
        component: UsersIndex,
        meta: { requiresRole: 'Master' },
      },

    {
      path: '/admin-dashboard',
      name: 'AdminDashboard',
      component: AdminDashboard,
      meta: { requiresAuth: true },
    },

    {
      path: '/login',
      name: 'Login',
      component: Login,
    },
    {
        path: '/cep',
        name: 'Cep',
        component: Cep,
        meta: { requiresRole: 'Master' },
      },
      {
        path: '/chatgpt',
        name: 'gpt',
        component: gpt,
        meta: { requiresRole: 'Master' },
      },
    {
      path: '/:pathMatch(.*)*',
      name: 'Login',
      component: Login,
    },
  ];

  const router = createRouter({
    history: createWebHistory(),
    routes,
  });


// Guardas de rota para verificar papéis e permissões
router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('authToken');
    const userRole = localStorage.getItem('userRole');
    const userPermissions = JSON.parse(localStorage.getItem('userPermissions') || '[]');

    // Verifica se a rota requer autenticação
    if (to.matched.some(record => record.meta.requiresAuth) && !token) {
      return next({ name: 'Login' });
    }

    // Verifica se a rota requer um papel específico
    if (to.matched.some(record => record.meta.requiresRole)) {
      const requiredRole = to.meta.requiresRole;
      if (userRole !== requiredRole) {
        return next({ name: 'Login' }); // Redireciona se o papel não for adequado
      }
    }

    // Verifica se a rota requer uma permissão específica
    if (to.matched.some(record => record.meta.requiresPermission)) {
      const requiredPermissions = to.meta.requiresPermission;

      // Se for uma lista de permissões (array), verificamos se o usuário tem pelo menos uma
      if (Array.isArray(requiredPermissions)) {
        const hasPermission = requiredPermissions.some(permission => userPermissions.includes(permission));
        if (!hasPermission) {
          return next({ name: 'Login' }); // Redireciona se o usuário não tem permissão
        }
      } else {
        // Se for uma permissão única, verificamos diretamente
        if (!userPermissions.includes(requiredPermissions)) {
          return next({ name: 'Login' }); // Redireciona se não tiver a permissão
        }
      }
    }

    // Prossegue para a rota se tudo estiver validado
    next();
  });

  export default router;
