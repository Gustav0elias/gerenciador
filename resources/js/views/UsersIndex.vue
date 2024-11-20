<template>
    <div style="margin-top: 20px;"></div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 style="color: white!important;" class="card-title">Usuários</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                                    <i class="fa fa-plus-square"></i> Adicionar usuário
                                </button>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Papel</th>
                                        <th>Ações</th>
                                        <th v-if="hasRole('Master')">Vínculo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="user in users" :key="user.id">
                                        <td>{{ user.id }}</td>
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ user.roles && user.roles.length ? user.roles[0] : 'Nenhum papel' }}</td>
                                        <td>
                                            <a style="margin-right: 1rem;" href="#" @click="editModal(user)">
                                                <i class="fa fa-edit blue"></i>
                                            </a>
                                            <a href="#" @click="openDeleteModal(user)">
                                                <i class="fa fa-trash red"></i>
                                            </a>
                                        </td>
                                        <td v-if="hasRole('Master')">       <button style="margin-right: 0.5rem;" type="button" class="btn btn-sm btn-primary"
                                @click.prevent="toggleRole(user)">
                                {{ user.roles && user.roles.length ? 'Desvincular' : 'Vincular' }}

                                        </button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="showRoleModal" class="modal fade show" tabindex="-1"
                style="display: block; background-color: rgba(0,0,0,0.5)">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Vincular Papel</h5>

                            <button type="button" class="close" @click="closeRoleModal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <h6>Selecione um papel para o usuário {{ selectedUser.name }}</h6>
                            <!-- Mudamos de checkbox para radio buttons -->
                            <div v-for="role in roles" :key="role.id">
                                <label>
                                    <input type="radio" name="role" :value="role.name" v-model="selectedRole">
                                    {{ role.name }}
                                </label>
                            </div>


                        </div>
                        <div style="display: flex; justify-content: space-between;" class="modal-footer">


                            <button type="button" class="btn btn-secondary" @click="closeRoleModal">Fechar</button>
                            <button @click="assignRoleToUser" class="btn btn-primary">Vincular</button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="showModalAdd" class="modal fade show d-block" tabindex="-1" role="dialog"
                aria-labelledby="addNew" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!editmode">Adicionar Usuário</h5>
                            <h5 class="modal-title" v-show="editmode">Edit Product</h5>
                            <button type="button" class="close" @click="closeAddModal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form @submit.prevent="editmode ? editUser() : createUser()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input v-model="newUser.name" type="text" name="name" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input v-model="newUser.email" type="text" name="email" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label>Senha</label>
                                    <input v-model="newUser.password" type="password" name="password"
                                        class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label>Confirmar Senha</label>
                                    <input v-model="newUser.password_confirmation" type="password" name="password"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="closeAddModal">Fechar</button>
                                <button v-show="editmode" type="submit" class="btn btn-success">Atualizar</button>
                                <button v-show="!editmode" type="submit" class="btn btn-primary">Adicionar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal de Editar Usuário -->
            <div v-if="showEditModal" class="modal fade show" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5)">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Usuário</h5>
                            <button type="button" class="close" @click="closeEditModal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="updateUser">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input v-model="selectedUser.name" type="text" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input v-model="selectedUser.email" type="email" class="form-control" />
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeEditModal">Fechar</button>
                            <button type="button" class="btn btn-primary" @click="updateUser">Atualizar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de Remover Usuário -->
            <div v-if="showDeleteModal" class="modal fade show" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5)">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Excluir Usuário</h5>
                            <button type="button" class="close" @click="closeDeleteModal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Tem certeza de que deseja excluir o usuário {{ selectedUser.name }}?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeDeleteModal">Cancelar</button>
                            <button type="button" class="btn btn-danger" @click="deleteUser(selectedUser.id)">Excluir</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</template>


<script>
import axios from "axios";

export default {
    data() {
        return {
            users: [],
            roles: [],

            editmode: false,
            showModalAdd: false,
            newUser: {
                name: "",
                email: "",
                password: "",
                password_confirmation: ""
            },
            showRoleModal: false,
            selectedUser: null,
            selectedRole: null,
        };
    },
    methods: {
        async loadUsers() {
            try {
                const response = await axios.get("http://127.0.0.1:8000/api/users", {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem("authToken")}`
                    }
                });
                this.users = response.data.users;
            } catch (error) {
                console.error("Erro ao carregar usuários:", error);
            }
        },
        editModal(user) {
            this.selectedUser = { ...user };
            this.showEditModal = true;
        },

        closeEditModal() {
            this.showEditModal = false;
            this.selectedUser = null;
        },

        async updateUser() {
            try {
                const response = await axios.put(`http://127.0.0.1:8000/api/users/${this.selectedUser.id}/update`, this.selectedUser, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem("authToken")}`,
                    },
                });
                this.loadUsers();
                this.closeEditModal();
            } catch (error) {
                console.error("Erro ao atualizar o usuário:", error);
            }
        },
        openDeleteModal(user) {
            this.selectedUser = user;
            this.showDeleteModal = true;
        },

        closeDeleteModal() {
            this.showDeleteModal = false;
            this.selectedUser = null;
        },

        async deleteUser(userId) {
            try {
                await axios.delete(`http://127.0.0.1:8000/api/users/${userId}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem("authToken")}`,
                    },
                });
                this.closeDeleteModal();
                this.loadUsers();
            } catch (error) {
                console.error("Erro ao excluir o usuário:", error);
            }
        },

        async fetchRoles() {
            this.isLoading = true;
            try {

                const response = await axios.get('http://127.0.0.1:8000/api/roles', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem("authToken")}`
                    }
                });
                this.roles = response.data.roles;
                console.log(this.roles);
            } catch (error) {
                console.error('Erro ao carregar papéis:', error);
            } finally {
                this.isLoading = false;
            }
        }
        ,
        openRoleModal(user) {
            this.selectedUser = user;
            this.showRoleModal = true;
            this.selectedRoles = [];
            this.selectedRole = null;
        },

        closeRoleModal() {
            this.showRoleModal = false;
            this.selectedUser = null;
        },


        async deleteUser(userId) {
            try {
                await axios.delete(`http://127.0.0.1:8000/api/users/${userId}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem("authToken")}`
                    }
                });
                this.loadUsers();
            } catch (error) {
                console.error("Erro ao excluir usuário:", error);
            }
        },
        newModal() {
            this.editmode = false;
            this.newUser = { name: "", email: "", password: "", password_confirmation: "" };
            this.showModalAdd = true;
        },
        closeAddModal() {
            this.showModalAdd = false;
        },
        async createUser() {
            try {
                await axios.post(
                    "http://127.0.0.1:8000/api/register",
                    this.newUser,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem("authToken")}`
                        }
                    }
                );
                this.loadUsers();
                this.closeAddModal();
            } catch (error) {
                console.error("Erro ao criar usuário:", error);
            }
        },

        async toggleRole(user) {
        try {
            if (user.roles && user.roles.length) {
                await this.unassignRole(user);
            } else {
                this.openRoleModal(user);
            }
        } catch (error) {
            console.error("Erro ao alterar papel do usuário:", error);
        }
    },
    async unassignRole(user) {
    try {
        await axios.post('/api/unassign-role', { user_id: user.id }, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem("authToken")}`
            }
        });
        user.roles = [];
    } catch (error) {
        console.error("Erro ao desvincular papel:", error);
    }
}
,

async assignRoleToUser() {
    try {
        console.log("Role selecionado:", this.selectedRole);
        const response = await axios.post(
            'http://127.0.0.1:8000/api/users/assign-role',
            {
                user_id: this.selectedUser.id,
                role_name: this.selectedRole
            },
            {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("authToken")}`
                }
            }
        );

        this.loadUsers();

        this.closeRoleModal();
        alert(response.data.message);
    } catch (error) {
        console.error("Erro ao vincular papel ao usuário:", error);
        alert("Erro ao vincular papel. Tente novamente.");
    }
}
,
        hasRole(role) {
            const userRole = localStorage.getItem('userRole');
            return userRole === role;
        },

    },
    mounted() {
        this.loadUsers();
        this.fetchRoles();
    }
};
</script>


<style scoped>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 5px;
    max-width: 500px;
    width: 100%;
}

button {
    margin-top: 10px;
}
</style>
