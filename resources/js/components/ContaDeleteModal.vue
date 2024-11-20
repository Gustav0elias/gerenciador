<template>
    <div class="modal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Excluir Conta</h5>
            <button type="button" class="btn-close" @click="close"></button>
          </div>
          <div class="modal-body">
            <p>Tem certeza de que deseja excluir esta conta?</p>
            <p><strong>{{ conta.descricao }}</strong></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" @click="deleteConta">Excluir</button>
            <button type="button" class="btn btn-secondary" @click="close">Cancelar</button>
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
      deleteConta() {
        this.$emit('delete');
      },
      close() {
        this.$emit('close');
      },
    },
  };
  </script>
