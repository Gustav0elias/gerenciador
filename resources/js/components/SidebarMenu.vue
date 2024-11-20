<template>
    <div>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <router-link to="/admin-dashboard" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt white"></i>
                    <p>Início</p>
                </router-link>
            </li>

            <li v-if="hasPermission('visualizar valores de contas') || hasPermission('visualizar inscrições específicas')" class="nav-item">
                <router-link to="/gerenciar-contas" class="nav-link">
                    <i class="nav-icon fas fa-file-invoice white"></i>
                    <p>Contas</p>
                </router-link>
            </li>

            <li v-if="hasPermission('modulo usuario')" class="nav-item">
                <router-link to="/gerenciar-users" class="nav-link">
                    <i class="fa fa-users nav-icon white"></i>
                    <p>Usuários</p>
                </router-link>
            </li>

            <li v-if="hasRole('Master')" class="nav-item">
                <router-link to="/gerenciar-permissoes" class="nav-link">
                    <i class="fa fa-users nav-icon white"></i>
                    <p>Papéis e Permissões</p>
                </router-link>
            </li>

            <li v-if="hasRole('Master')" class="nav-item has-treeview">
                <router-link to="/configuracoes" class="nav-link">
                    <i class="nav-icon fas fa-cog white"></i>
                    <p>Configurações </p>
                </router-link>
            </li>

            <li v-if="hasRole('Master') || hasRole('Administrador')" class="nav-item has-treeview" :class="{'menu-open': isApiExternasOpen}">
    <a href="#" class="nav-link" @click="toggleApiExternas">
        <i class="nav-icon fas fa-plug white"></i>
        <p>API Externas <i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <router-link to="/cep" class="nav-link">
                <i class="nav-icon fas fa-map-marker-alt white"></i>
                <p>Consulta Cep</p>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link to="/chatgpt" class="nav-link">
                <i class="nav-icon fas fa-comments white"></i>
                <p>Consulta Chat GPT</p>
            </router-link>
        </li>
    </ul>
</li>


            <li class="nav-item">
                <a href="#" class="nav-link" @click.prevent="logout">
                    <i class="nav-icon fas fa-power-off red"></i>
                    <p>sair</p>
                </a>
            </li>
        </ul>
    </div>
</template>



<script>
import axios from 'axios';
export default {
    data() {
        return {
            totalContas: 120,
            totalUsuarios: 50,
            configuracaoAtual: "Configuração padrão aplicada",
            isApiExternasOpen: false
        };
    },
    methods: {
        toggleApiExternas() {
            this.isApiExternasOpen = !this.isApiExternasOpen;
        },
        navigate(page) {
            console.log(`Navegando para ${page}`);
        },
        logout() {
            alert("Você foi desconectado.");
        },
        hasRole(role) {
            const userRole = localStorage.getItem('userRole');
            return userRole === role;
        },
        async logout() {
            try {
                await axios.post('http://127.0.0.1:8000/api/logout', {}, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('authToken')}`,
                    },
                });

                localStorage.removeItem('authToken');
                localStorage.removeItem('userPermissions');

                this.$router.push({ name: 'Login' });
            } catch (error) {
                console.error('Erro ao fazer logout:', error);
            }
        },

    },

    computed: {
        hasPermission() {
            return (permission) => {
                const permissions = JSON.parse(localStorage.getItem('userPermissions')) || [];
                console.log("Lista de permissões no localStorage:", permissions);
                return permissions.includes(permission);
            };
        }
    }
};
</script>


