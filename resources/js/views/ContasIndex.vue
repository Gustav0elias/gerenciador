<template>
    <div style="margin-top: 20px;"></div>
    <section class="content">
        <div class="container-fluid"></div>
        <div>
            <div v-if="isLoading" class="loading-overlay">Carregando...</div>

            <div class="row">
                <div class="filter-container mb-3">
                    <div class="filter-input-group">
                        <select class="filter-select" v-model="filterStatus" @change="fetchContas">
                            <option value="">Filtrar por status</option>
                            <option value="pago">Pago</option>
                            <option value="pendente">Pendente</option>
                        </select>

                        <select class="filter-select" v-model="filterTipo" @change="fetchContas">
                            <option value="">Filtrar por tipo</option>
                            <option value="receita">Receita</option>
                            <option value="despesa">Despesa</option>
                        </select>

                        <input type="text" class="filter-input" placeholder="Pesquisar..." v-model="searchTerm"
                            @input="fetchContas" />

                    </div>
                </div>


                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 style="color: white!important;" class="card-title">Contas</h3>
                            <div class="card-tools">
                                <button  v-if="hasPermission('adicionar novas contas')" type="button" class="btn btn-primary" @click="showCreateModal">
                                    <i class="fa fa-plus-square"></i> Adicionar Conta
                                </button>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Descrição</th>
                                        <th>Valor</th>
                                        <th>Data de Vencimento</th>
                                        <th>Status</th>

                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="conta in contas.data" :key="conta.id">
                                        <td>{{ conta.descricao }}</td>
                                        <td>{{ formatarValor(conta.valor) }}</td>

                                        <td>{{ formatDate(conta.data_vencimento) }}</td>
                                        <td>
                                            <div style="width: 60%;" :class="statusClass(conta.status)"> {{ conta.status
                                                }}</div>

                                        </td>

                                        <td>
                                            <a  style="margin-right: 0.9rem;" href="" @click.prevent="viewConta(conta)">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <a  v-if="hasPermission('editar valores de contas')"  style="margin-right: 0.9rem;" href="#" @click.prevent="editConta(conta)">
                                                <i class="fa fa-edit blue"></i>
                                            </a>

                                            <a href="#" @click.prevent="confirmDeleteConta(conta)">
                                                <i class="fa fa-trash red"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <div class="card-footer">
                            <pagination :data="contas" @pagination-change-page="fetchContas"></pagination>
                        </div>
                    </div>
                </div>
            </div>

            <ContaModal v-if="modalState.showCreateModal" :mode="'create'" :conta="newConta" @close="closeModal"
                @save="createConta" />
            <ContaModal v-if="modalState.showEditModal" :mode="'edit'" :conta="currentConta" @close="closeModal"
                @save="updateConta" />
            <ContaViewModal v-if="modalState.showViewModal" :conta="currentConta" @close="closeModal" />
            <ContaDeleteModal v-if="modalState.showDeleteModal" :conta="currentConta" @close="closeModal"
                @delete="deleteConta" />
        </div>


    </section>
</template>

<script>
import axios from 'axios';
import { ref, reactive, onMounted, watch } from 'vue';
import ContaModal from '../components/ContaModal.vue';
import ContaDeleteModal from '../components/ContaDeleteModal.vue';
import ContaViewModal from '../components/ContaViewModal.vue';

export default {
    components: {
        ContaModal,
        ContaDeleteModal,
        ContaViewModal,
    },

    methods: {
        formatDate(value) {
            if (!value) return '';
            const date = new Date(value);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        },

        formatarValor(valor) {
            return new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL',
            }).format(valor);
        },
        statusClass(status) {
            switch (status) {
                case 'Pago':
                    return 'status-pago';
                case 'Atrasado':
                    return 'status-atrasado';
                case 'Pendente':
                    return 'status-pendente';
                default:
                    return '';
            }
        },

    },
    setup() {


        const contas = ref([]);
        const currentConta = ref(null);
        const newConta = reactive({
            descricao: '',
            valor: '',
            data_vencimento: '',
            status: 'Pendente',
            tipo: 'Pagar',

        });

        const modalState = reactive({
            showCreateModal: false,
            showEditModal: false,
            showDeleteModal: false,
            showViewModal: false,
        });



        const isLoading = ref(false);
        const searchTerm = ref('');
        const filterStatus = ref('');
        const filterTipo = ref('');

        const fetchContas = async () => {
            isLoading.value = true;
            try {
                const token = localStorage.getItem('authToken');
                const userRole = localStorage.getItem('userRole');

                const url = userRole === 'Usuário Comum'
                    ? 'http://127.0.0.1:8000/api/contas/usuario'
                    : 'http://127.0.0.1:8000/api/contas';
                const response = await axios.get(url, {
                    headers: { Authorization: `Bearer ${token}` },
                    params: {
                        search: searchTerm.value,
                        status: filterStatus.value,
                        tipo: filterTipo.value,
                    }
                });

                console.log(response.data);
                contas.value = response.data;

            } catch (error) {
                console.error('Erro ao carregar contas:', error);
            } finally {
                isLoading.value = false;
            }
        };




        const showCreateModal = () => {
            newConta.descricao = '';
            newConta.valor = '';
            newConta.data_vencimento = '';
            newConta.status = 'Pendente';
            newConta.tipo = 'Pagar';
            modalState.showCreateModal = true;
        };

        const viewConta = (conta) => {
            currentConta.value = { ...conta };
            modalState.showViewModal = true;
        };

        const editConta = (conta) => {
            currentConta.value = { ...conta };
            modalState.showEditModal = true;
        };

        const confirmDeleteConta = (conta) => {
            currentConta.value = { ...conta };
            modalState.showDeleteModal = true;
        };

        const createConta = async () => {
    try {
        const token = localStorage.getItem('authToken');
        const response = await axios.post('http://127.0.0.1:8000/api/contas', newConta, {
            headers: { Authorization: `Bearer ${token}` },
        });

        if (Array.isArray(contas.value)) {
            contas.value.push(response.data.data);
        } else {
            console.error('contas.value não é um array');
        }

        fetchContas();
        closeModal();
    } catch (error) {
        console.error('Erro ao criar conta:', error);
    }
};

        const updateConta = async () => {
            try {
                const token = localStorage.getItem('authToken');
                await axios.put(`http://127.0.0.1:8000/api/contas/${currentConta.value.id}`, currentConta.value, {
                    headers: { Authorization: `Bearer ${token}` },
                });
                fetchContas();
                closeModal();
            } catch (error) {
                console.error('Erro ao atualizar conta:', error);
            }
        };

        const deleteConta = async () => {
            try {
                const token = localStorage.getItem('authToken');
                await axios.delete(`http://127.0.0.1:8000/api/contas/${currentConta.value.id}`, {
                    headers: { Authorization: `Bearer ${token}` },
                });
                fetchContas();
                closeModal();
            } catch (error) {
                console.error('Erro ao excluir conta:', error);
            }
        };

        const closeModal = () => {
            modalState.showCreateModal = false;
            modalState.showEditModal = false;
            modalState.showDeleteModal = false;
            modalState.showViewModal = false;
            currentConta.value = null;
            Object.assign(newConta, {
                descricao: '',
                valor: '',
                data_vencimento: '',
                status: 'Pendente',
                tipo: 'Pagar',
            });
        };

        watch([searchTerm, filterStatus, filterTipo], fetchContas);

        onMounted(fetchContas);

        return {
            contas,
            currentConta,
            newConta,
            modalState,
            isLoading,
            searchTerm,
            filterStatus,
            filterTipo,
            showCreateModal,
            viewConta,
            editConta,
            confirmDeleteConta,
            createConta,
            updateConta,
            deleteConta,
            closeModal,
            fetchContas,
        };
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


<style scoped>
.modal {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
}

.modal-dialog {
    max-width: 500px;
}

.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-size: 1.5em;
}

.status-pago {
    background-color: #d4edda;
    color: #155724;
    font-weight: bold;
    padding: 5px;
    border-radius: 5px;
    text-align: center;
}

.status-atrasado {
    background-color: #f8d7da;
    color: #721c24;
    font-weight: bold;
    padding: 5px;
    border-radius: 5px;
    text-align: center;
}

.status-pendente {
    background-color: #fff3cd;
    color: #856404;
    font-weight: bold;
    padding: 5px;
    border-radius: 5px;
    text-align: center;
}

.filter-container {
    width: 100%;
}

.filter-input-group {
    display: flex;
    gap: 1rem;
    width: 100%;
}

.filter-select {
    width: 100%;
    padding: 0.5rem 1rem;
    border: 2px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    font-size: 1rem;
    color: #333;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.filter-input {
    width: 100%;
    padding: 0.5rem 1rem;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    font-size: 1rem;
    color: #333;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.filter-select:focus,
.filter-input:focus {
    border-color: #dbdbdb;
    box-shadow: 0 0 0 2px rgba(0, 86, 179, 0.3);
    outline: none;
}

@media (max-width: 768px) {
    .filter-input-group {
        flex-direction: column;
    }

    .filter-select,
    .filter-input {
        margin-bottom: 1rem;
    }
}
</style>
