<template>
    <div class="container my-4">
        <h1 class="mb-4 h1config">Configurações</h1>
        <div class="accordion" id="settingsAccordion">

            <!-- Seção de Perfil -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingProfile">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseProfile" aria-expanded="true" aria-controls="collapseProfile">
                        Cor de background
                    </button>
                </h2>
                <div id="collapseProfile" class="accordion-collapse collapse show" aria-labelledby="headingProfile"
                    data-bs-parent="#settingsAccordion">
                    <div class="accordion-body">
                        <p>Escolha uma cor para personalizar o background do sistema. Essa nova cor será visível para todos os usuários do sistema.

                        </p>
                        <label for="colorPicker">Selecione a cor de fundo:</label>
                        <input id="colorPicker" v-model="backgroundColor" type="color" @input="updateBackgroundColor"
                            @change="updateBackgroundColor" />

                            <div class="mt-3 d-flex justify-content-start">
              <button
                :class="['btn', 'btn-primary', buttonSize, 'd-flex', 'align-items-center']"
                @click="saveBackgroundColor"
              >
                Salvar
              </button>
            </div>


                        <div v-if="showModal" class="modal fade show" tabindex="-1" role="dialog"
                            style="display: block;" aria-labelledby="successModal" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="successModal">Sucesso!</h5>
                                        <button type="button" class="btn-close" aria-label="Fechar"
                                            @click="closeModal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>A cor de fundo foi atualizada com sucesso!</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            @click="closeModal">Fechar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            backgroundColor: '#ffffff',
            showModal: false,
        };
    },
    mounted() {
        this.fetchConfiguration();
    },
    methods: {

        fetchConfiguration() {
            const token = localStorage.getItem('authToken');
            axios
                .get('/api/global-configuration', {
                    headers: { Authorization: `Bearer ${token}` },
                })
                .then((response) => {
                    this.backgroundColor = response.data.background_color || '#ffffff';
                    this.updateCSSVariable(this.backgroundColor);
                })
                .catch((error) => {
                    console.error('Erro ao carregar configuração', error);
                });
        },

        updateCSSVariable(newColor) {
            document.documentElement.style.setProperty('--content-wrapper-bg', newColor);
        },

        saveBackgroundColor() {
            const token = localStorage.getItem('authToken');
            axios
                .put(
                    '/api/global-configuration',
                    { background_color: this.backgroundColor },
                    {
                        headers: {
                            'Content-Type': 'application/json',
                            Authorization: `Bearer ${token}`,
                        },
                    }
                )
                .then(() => {
                    this.updateCSSVariable(this.backgroundColor);
                    this.showModal = true;
                })
                .catch((error) => {
                    console.error('Erro ao atualizar configuração', error);
                });
        },

        closeModal() {
            this.showModal = false;
        },

        updateBackgroundColor() {
            this.$root.$emit('update-background-color', this.backgroundColor);
            this.updateCSSVariable(this.backgroundColor);
        },
    }

};
</script>


<style scoped>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    text-align: center;
}

button {
    padding: 10px 15px;
    margin-top: 10px;
}

.h1config {
    font-size: 1.4rem;

}

.accordion-body{
    display: flex;
    flex-direction: column;
}
</style>
