<template>
    <div class="container mt-5">
      <div class="cep-card p-4 shadow-sm rounded">
        <div class="text-center mb-4">
          <h2>Consulta de CEP</h2>
          <p class="text-muted">Informe um CEP para consultar os dados.</p>
        </div>

        <div class="mb-3">
          <label for="cep" class="form-label">Digite o CEP:</label>
          <div class="input-group">
            <input
            type="text"
            v-model="cep"
            class="form-control"
            id="cep"
            placeholder="Ex: 01001-000"
            :class="{'is-invalid': error}"
            @input="formatCep"
            maxlength="10"
          />
            <button
              class="btn btn-primary input-group-text"
              @click="consultarCep"
              :disabled="isLoading"
            >
              <i v-if="!isLoading" class="fas fa-search"></i>
              <div v-else class="spinner-border spinner-border-sm" role="status"></div>
            </button>
          </div>
        </div>

        <div v-if="error" class="alert alert-danger mt-3">
          <i class="fas fa-exclamation-triangle"></i> {{ error }}
        </div>

        <div v-if="endereco" class="mt-4">
          <h4 class="mb-3">Endereço:</h4>
          <ul class="list-unstyled">
            <li><strong>Logradouro:</strong> {{ endereco.logradouro }}</li>
            <li><strong>Bairro:</strong> {{ endereco.bairro }}</li>
            <li><strong>Cidade:</strong> {{ endereco.localidade }}</li>
            <li><strong>Estado:</strong> {{ endereco.uf }}</li>
          </ul>
        </div>
      </div>
    </div>
  </template>

  <script>
  import axios from "axios";

  export default {
    data() {
      return {
        cep: "",
        endereco: null,
        error: null,
        isLoading: false,
      };
    },
    methods: {
        formatCep(event) {
      let value = this.cep.replace(/\D/g, "");
      if (value.length > 5) {
        value = value.slice(0, 5) + "-" + value.slice(5, 8);
      }
      this.cep = value;
    },
    async consultarCep() {
    this.error = null;
    this.endereco = null;
    this.isLoading = true;

    if (!this.cep.match(/^\d{5}-?\d{3}$/)) {
        this.error = "CEP inválido!";
        this.isLoading = false;
        return;
    }

    try {
        const response = await axios.get(`/api/consulta-cep/${this.cep}`, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem("authToken")}`
            }
        });
        this.endereco = response.data;
    } catch (error) {
        if (error.response && error.response.data.error) {
            this.error = error.response.data.error;
        } else {
            this.error = "Erro ao consultar o CEP.";
        }
    } finally {
        this.isLoading = false;
    }
},

    },
  };
  </script>

  <style scoped>
  .container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
  }

  .cep-card {
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  h2 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #343a40;
  }

  p.text-muted {
    font-size: 1rem;
    color: #6c757d;
  }

  .input-group {
    display: flex;
    align-items: center;
  }

  .input-group .form-control {
    border-radius: 0.375rem;
    padding: 0.75rem;
  }

  .input-group .btn {
    border-radius: 0.375rem;
    padding: 0.75rem;
  }

  .input-group .form-control.is-invalid {
    border-color: #dc3545;
  }

  .btn-primary {
    background-color: #007bff;
    border: none;
  }

  .spinner-border {
    width: 1.25rem;
    height: 1.25rem;
    border-width: 0.2em;
  }
  .alert {
    border-radius: 0.375rem;
  }

  .alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
  }

  .list-unstyled li {
    margin: 8px 0;
  }

  strong {
    font-weight: 600;
  }

  .fas {
    font-size: 1.25rem;
    margin-right: 8px;
    color: rgb(238, 229, 229);
  }
  </style>
