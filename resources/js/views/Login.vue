<template>
    <div class="login-container">
      <div class="login-card">
        <h2>Entrar</h2>

        <form @submit.prevent="login">
          <div class="input-group">
            <label for="email">Email</label>
            <input
              type="email"
              id="email"
              v-model="email"
              placeholder="Digite seu email"
              required
              aria-describedby="emailHelp"
              :class="{'input-error': emailError}"
            />
          </div>

          <div class="input-group">
            <label for="password">Senha</label>
            <input
              type="password"
              id="password"
              v-model="password"
              placeholder="Digite sua senha"
              required
              :class="{'input-error': passwordError}"
            />
          </div>

          <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>

          <button type="submit" class="login-btn">Entrar</button>
        </form>


      </div>
    </div>
  </template>
  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        email: '',
        password: '',
        errorMessage: '',
      };
    },
    methods: {
        async login() {
  this.errorMessage = '';

  if (!this.email || !this.password) {
    this.errorMessage = 'Por favor, preencha todos os campos.';
    return;
  }

  try {
    const response = await axios.post('http://127.0.0.1:8000/api/login', {
      email: this.email,
      password: this.password,
    });

    const { token, role, permissions } = response.data;

    localStorage.setItem('authToken', token);
    localStorage.setItem('userRole', role);
    localStorage.setItem('userPermissions', JSON.stringify(permissions));


      this.$router.push({ name: 'AdminDashboard' });



  } catch (error) {
    if (error.response && error.response.data) {
      this.errorMessage = error.response.data.message || 'Erro ao fazer login. Tente novamente.';
    } else {
      this.errorMessage = 'Erro ao fazer login. Verifique a conexão com o servidor.';
    }
    console.error('Erro ao fazer login', error);
  }
}

    },
  };
  </script>
<style scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f4f7fa;
}

.login-card {
  background: white;
  padding: 30px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  width: 100%;
  max-width: 400px;
}

h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}

.input-group {
  margin-bottom: 20px;
}

.input-group label {
  display: block;
  font-weight: bold;
  color: #555;
  margin-bottom: 5px;
}

.input-group input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
}

.input-group input.input-error {
  border-color: red;
}

.error-message {
  color: red;
  text-align: center;
  margin-bottom: 20px;
}

.login-btn {
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.login-btn:hover {
  background-color: #0056b3;
}

.footer-links {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
  font-size: 14px;
}

.footer-links a {
  color: #007bff;
  text-decoration: none;
}

.footer-links a:hover {
  text-decoration: underline;
}
</style>
