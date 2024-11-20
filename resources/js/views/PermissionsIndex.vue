<template>
        <div style="margin-top: 20px;"></div>
    <section class="content">
        <div class="container-fluid"></div>
    <div>



        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 style="color: white!important;" class="card-title">Papéis e Permissões</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                                <i class="fa fa-plus-square"></i>
                                Adicionar Papel
                            </button>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>

                                    <th>Papel</th>
                                    <th>Permissões</th>
                                    <th>Ações</th>
                                    <th>Vínculo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="role in roles" :key="role.name">

                                    <td>{{ role.name }}</td>
                                    <td>{{ role.permissions.join(', ') }}</td>
                                    <td>



                                        <a href="#" @click="deleteUser(user.id)">
                                            <i class="fa fa-trash red"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <button style="margin-right: 0.5rem;" type="button" class="btn btn-sm btn-primary"
                                            @click="newModalPermissions(role)">
                                         Atribuir

                                        </button>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <pagination :data="products" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>




        <div v-if="showModalAdd" class="modal fade show d-block" tabindex="-1" role="dialog" aria-labelledby="addNew"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Papel</h5>

                        <button type="button" class="close" @click="closeModalPermissions" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="createRole">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nome do Papel</label>
                                <input type="text" v-model="newRoleName" placeholder="Nome do Papel"
                                    class="form-control" required />
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModalPermissions">Fechar</button>

                            <button type="submit" class="btn btn-primary">Adicionar Papel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div v-if="showModalPermission" class="modal fade show d-block" tabindex="-1" role="dialog"
            aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Vincular Permissão</h5>

                        <button type="button" class="close" @click="closeAddModal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="assignPermissions">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Papel</label>
                                <input
              type="text"
              v-model="roleToAssign"
              :placeholder="roleToAssign"
              class="form-control"
              required
              disabled
            />                            </div>
                            <div class="form-group" v-for="permission in permissions" :key="permission">
                                <input type="checkbox" :value="permission" v-model="selectedPermissions"
                                   />
                                <label>{{ permission }}</label>
                            </div>



                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeAddModal">Fechar</button>

                            <button type="submit" class="btn btn-primary">Adicionar Papel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
    </section>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            roles: [],
            permissions: [],
            newRoleName: '',
            selectedRole: '',
            selectedPermissions: [],
            isLoading: false,
            showModalAdd: false,
            showModalPermission: false,
            roleToAssign: '',
        };
    },
    mounted() {
        this.fetchRoles();
        this.fetchPermissions();
    },
    methods: {

        newModal() {

            this.showModalAdd = true;
        },
        closeAddModal() {
            this.showModalAdd = false;
        },



        newModalPermissions(role) {
    this.roleToAssign = role.name;
    this.selectedPermissions = [];
    this.showModalPermission = true;
  },


        closeModalPermissions() {
            this.showModalPermission = false;
        },
        getAuthToken() {
            return localStorage.getItem('authToken');
        },

        async fetchRoles() {
            this.isLoading = true;
            try {
                const token = this.getAuthToken();
                const response = await axios.get('http://127.0.0.1:8000/api/roles', {
                    headers: { Authorization: `Bearer ${token}` },
                });
                this.roles = response.data.roles;
            } catch (error) {
                console.error('Erro ao carregar papéis:', error);
            } finally {
                this.isLoading = false;
            }
        },

        async fetchPermissions() {
            this.isLoading = true;
            try {
                const token = this.getAuthToken();
                const response = await axios.get('http://127.0.0.1:8000/api/permissions', {
                    headers: { Authorization: `Bearer ${token}` },
                });
                this.permissions = response.data.permissions;
            } catch (error) {
                console.error('Erro ao carregar permissões:', error);
            } finally {
                this.isLoading = false;
            }
        },

        async createRole() {
            this.isLoading = true;
            try {
                const token = this.getAuthToken();
                const response = await axios.post(
                    'http://127.0.0.1:8000/api/roles',
                    { name: this.newRoleName },
                    {
                        headers: { Authorization: `Bearer ${token}` },
                    }
                );
                this.closeAddModal();
                this.fetchRoles();
                this.roles.push(response.data.role);
                this.newRoleName = '';
            } catch (error) {
                console.error('Erro ao criar papel:', error);
            } finally {
                this.isLoading = false;
            }
        },

        async assignPermissions() {
            this.isLoading = true;
            try {
                const token = this.getAuthToken();
                await axios.post(
                    'http://127.0.0.1:8000/api/roles/assign-permissions',
                    {
                        role_name: this.roleToAssign,
                        permissions: this.selectedPermissions,
                    },
                    {
                        headers: { Authorization: `Bearer ${token}` },
                    }
                );



                this.fetchRoles();
                this.closeModalPermissions();
            } catch (error) {
                console.error('Erro ao atribuir permissões:', error);
            } finally {
                this.isLoading = false;
            }
        },
    },
};
</script>


<style scoped>
h1,
h2,
h3 {
    margin-bottom: 10px;
}

form {
    margin-top: 20px;
}

input[type="text"] {
    padding: 5px;
    margin-right: 10px;
}
</style>
