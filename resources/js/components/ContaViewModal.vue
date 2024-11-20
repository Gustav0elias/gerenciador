<template>
    <div class="modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-title">Visualizar Conta</h5>
            <button type="button" class="btn-close" @click="close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Descrição</label>
              <p>{{ conta.descricao }}</p>
            </div>
            <div class="mb-3">
              <label class="form-label">Valor</label>
              <p>{{ formatarValor(conta.valor) }}</p>
            </div>
            <div class="mb-3">
              <label class="form-label">Data de Vencimento</label>
              <p>{{ formatDate(conta.data_vencimento) }}</p>
            </div>
            <div class="mb-3">
              <label class="form-label">Status</label>
              <p>{{ conta.status }}</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="close">Fechar</button>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  export default {
    props: {
      conta: { type: Object, required: true },
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
      close() {
        this.$emit('close');
      },
    },
  };
  </script>
