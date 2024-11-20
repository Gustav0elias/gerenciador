<template>
    <section class="content">
        <div class="container-fluid">
            <div style="margin-top: 25px;"></div>

            <div style="display: flex;    background: linear-gradient(135deg, #013668 , #3470AF);  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25),
              0 6px 6px rgba(0, 0, 0, 0.22);
                " class="welcome-grid">
                <div style="display: flex; flex-direction: column; align-items: start;">
                    <h1 style="margin-bottom: 18px;">Bem-vindo ao gerenciador de contas!</h1>
                    <p style="width:75% !important; text-align: start;" class="welcome-message">Aqui, você tem o
                        controle completo sobre todas
                        as suas contas. Além disso, pode acompanhar e gerenciar de forma eficiente
                        todos os abastecimentos realizados através do nosso aplicativo. Otimize a administração de sua
                        frota
                        e tenha um controle detalhado de todas as operações de abastecimento com facilidade e precisão!
                    </p>
                </div>
                <div>
                    <svg style="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 96 120" x="0px" y="0px" width="175"
                        height="175" fill="#fff">
                        <path d="M65.346,84.614H30.654a1,1,0,1,1,0-2H65.346a1,1,0,0,1,0,2Z" />
                        <path
                            d="M89,76.394H7a5.006,5.006,0,0,1-5-5V16.386a5.006,5.006,0,0,1,5-5H89a5.006,5.006,0,0,1,5,5V71.394A5.006,5.006,0,0,1,89,76.394ZM7,13.386a3,3,0,0,0-3,3V71.394a3,3,0,0,0,3,3H89a3,3,0,0,0,3-3V16.386a3,3,0,0,0-3-3Z" />
                        <path
                            d="M59.315,84.614H36.685a1,1,0,0,1-.874-1.486l4.571-8.22a1,1,0,0,1,.874-.514H54.744a1,1,0,0,1,.874.514l4.571,8.22a1,1,0,0,1-.874,1.486Zm-20.93-2h19.23l-3.459-6.22H41.844Z" />
                        <path d="M93,67.257H3a1,1,0,0,1,0-2H93a1,1,0,0,1,0,2Z" />
                        <path d="M28.037,59.454H10.605a1,1,0,1,1,0-2H28.037a1,1,0,0,1,0,2Z" />
                        <path d="M19.321,53.848H10.605a1,1,0,0,1,0-2h8.716a1,1,0,0,1,0,2Z" />
                        <path
                            d="M11.656,38.312a1,1,0,0,1-.832-.444,11.419,11.419,0,1,1,19,0,1,1,0,1,1-1.664-1.11,9.425,9.425,0,1,0-15.676,0,1,1,0,0,1-.83,1.556Z" />
                        <path
                            d="M20.321,36.717A2.878,2.878,0,1,1,23.2,33.839,2.881,2.881,0,0,1,20.321,36.717Zm0-3.756a.878.878,0,1,0,.878.878A.879.879,0,0,0,20.321,32.961Z" />
                        <path
                            d="M21.649,33.511a1,1,0,0,1-.707-1.707l4.01-4.01a1,1,0,0,1,1.414,1.414l-4.01,4.01A.993.993,0,0,1,21.649,33.511Z" />
                        <path d="M86.1,59.454H52.753a1,1,0,0,1,0-2H86.1a1,1,0,0,1,0,2Z" />
                        <path d="M82.355,59.454a1,1,0,0,1-1-1V35.9a1,1,0,0,1,2,0V58.454A1,1,0,0,1,82.355,59.454Z" />
                        <path d="M73.814,59.454a1,1,0,0,1-1-1V43.792a1,1,0,0,1,2,0V58.454A1,1,0,0,1,73.814,59.454Z" />
                        <path d="M65.273,59.454a1,1,0,0,1-1-1V39.75a1,1,0,0,1,2,0v18.7A1,1,0,0,1,65.273,59.454Z" />
                        <path d="M56.732,59.454a1,1,0,0,1-1-1V48.2a1,1,0,0,1,2,0v10.25A1,1,0,0,1,56.732,59.454Z" />
                        <path
                            d="M56.732,40.75A3.348,3.348,0,1,1,60.08,37.4,3.352,3.352,0,0,1,56.732,40.75Zm0-4.695A1.348,1.348,0,1,0,58.08,37.4,1.348,1.348,0,0,0,56.732,36.055Z" />
                        <path
                            d="M65.273,31.939a3.347,3.347,0,1,1,3.348-3.347A3.351,3.351,0,0,1,65.273,31.939Zm0-4.694a1.347,1.347,0,1,0,1.348,1.347A1.348,1.348,0,0,0,65.273,27.245Z" />
                        <path
                            d="M73.814,39.859a3.347,3.347,0,1,1,3.348-3.347A3.351,3.351,0,0,1,73.814,39.859Zm0-4.694a1.347,1.347,0,1,0,1.348,1.347A1.348,1.348,0,0,0,73.814,35.165Z" />
                        <path
                            d="M82.355,31.489A3.347,3.347,0,1,1,85.7,28.142,3.35,3.35,0,0,1,82.355,31.489Zm0-4.694A1.347,1.347,0,1,0,83.7,28.142,1.348,1.348,0,0,0,82.355,26.8Z" />
                        <path
                            d="M75.491,35.869a1,1,0,0,1-.7-1.714l5.188-5.085a1,1,0,0,1,1.4,1.429l-5.189,5.084A1,1,0,0,1,75.491,35.869Z" />
                        <path
                            d="M72.094,35.916a1,1,0,0,1-.68-.267l-5.1-4.728a1,1,0,1,1,1.36-1.466l5.1,4.728a1,1,0,0,1-.679,1.733Z" />
                        <path
                            d="M58.365,36.718a1,1,0,0,1-.718-1.7l5.275-5.44a1,1,0,0,1,1.435,1.393l-5.274,5.44A1,1,0,0,1,58.365,36.718Z" />

                    </svg>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div style="background-color: #E0EAFE !important;" class="info-box">
                        <span style="background: linear-gradient(135deg, #013668 , #3470AF); "
                            class="info-box-icon bg-info elevation-1"><i class="fas fa-file-invoice"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total de Contas</span>
                            <span class="info-box-number">
                                {{ dashboardData.contasCount }}

                            </span>
                        </div>
                    </div>
                </div>

                <div v-if="!hasRole('Usuário Comum')" class="col-12 col-sm-6 col-md-3">
                    <div style="background-color: #E0EAFE !important;" class="info-box mb-3">
                        <span style="background: linear-gradient(135deg, #013668 , #3470AF); "
                            class="info-box-icon   elevation-1"><i style="color: white;"
                                class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            Total de Usuários
                            <span class="info-box-number"> {{ dashboardData.usersCount }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div style="background-color: #E0EAFE !important;" class="info-box mb-3">
                        <span style="background: linear-gradient(135deg, #013668 , #3470AF); "
                            class="info-box-icon bg-success elevation-1"><i class="fas fa-file-invoice"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Contas Pendentes</span>
                            <span class="info-box-number">{{ dashboardData.status.pendentes }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div style="background-color: #E0EAFE !important;" class="info-box mb-3">
                        <span style="background: linear-gradient(135deg, #013668 , #3470AF); "
                            class="info-box-icon bg-warning elevation-1"><i style="color: white;" class="fas fa-file-invoice"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Contas Atrasadas</span>
                            <span class="info-box-number">{{ dashboardData.status.atrasadas }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</template>

<script>
import axios from 'axios';
import { ref, reactive, onMounted, watch } from 'vue';

export default {

    data() {
    return {
        dashboardData: {
            contasCount: 0,
            usersCount: 0,
            status: {
                pendentes: 0,
                atrasadas: 0
            }
        },
        isLoading: true
    };
}
,
    mounted() {
        this.fetchDashboardData();
    },
    methods: {
        hasRole(role) {
            const userRole = localStorage.getItem('userRole');
            return userRole === role;
        },
        async fetchDashboardData() {
            try {
                const userRole = localStorage.getItem('userRole');
                const url = userRole === 'Usuário Comum'
                    ? 'http://127.0.0.1:8000/api/dashboard-user'
                    : 'http://127.0.0.1:8000/api/dashboard';
                const response = await axios.get(url, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('authToken')}`
                    }
                });

                this.dashboardData = response.data;
            } catch (error) {
                console.error('Erro ao carregar os dados do dashboard', error);
            } finally {
                this.isLoading = false;
            }
        }
    ,
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




}
</script>


<style>
.welcome-grid {
    background-color: var(--back-secundaria);
    color: #fff;
    text-align: center;
    padding-top: 40px;
    padding-left: 40px;
    border-radius: 10px;
    margin: 10px;
    margin-bottom: 30px;

}
</style>
