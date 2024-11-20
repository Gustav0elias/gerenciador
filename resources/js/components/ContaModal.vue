<template>
    <div class="modal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ mode === 'create' ? 'Cadastrar Nova Conta' : 'Editar Conta' }}</h5>
            <button type="button" class="btn-close" @click="close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="saveConta">
              <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <input type="text" v-model="conta.descricao" class="form-control" required />
              </div>
              <div class="mb-3">
                <label for="valor" class="form-label">Valor</label>
                <input type="text" v-model="conta.valor" class="form-control" required />
              </div>
              <div class="mb-3">
                <label for="data_vencimento" class="form-label">Data de Vencimento</label>
                <input type="date" v-model="conta.data_vencimento" class="form-control" required />
              </div>
              <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select v-model="conta.status" class="form-select" required>
                  <option>Pendente</option>
                  <option>Pago</option>
                  <option>Atrasado</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">{{ mode === 'create' ? 'Salvar Conta' : 'Salvar Alterações' }}</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  export default {
    props: {
      mode: { type: String, required: true },
      conta: { type: Object, required: true },
    },
    methods: {
      saveConta() {
        this.$emit('save');
      },
      close() {
        this.$emit('close');
      },
    },
  };
  </script>
