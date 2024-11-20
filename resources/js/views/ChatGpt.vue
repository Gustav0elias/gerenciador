<template>
    <div style="  height: 85vh; display: flex; justify-content: center; align-items: center;">

    <div class="chat-container">

        <div class="chat-header">
            <h2> ChatGPT</h2>
        </div>

        <div class="chat-messages" ref="messagesContainer">
            <div v-for="(message, index) in messages" :key="index" :class="['chat-message', message.sender]">
                <div class="message-text">{{ message.text }}</div>
            </div>
        </div>

        <form @submit.prevent="askChatGPT" class="chat-form">
            <input v-model="question" type="text" class="chat-input" placeholder="Digite sua pergunta..."
                :disabled="isSending" />
            <button type="submit" class="chat-send-button" :disabled="isSending">
                Enviar
            </button>
        </form>

        <div v-if="isSending" class="loading-spinner">
            <div class="spinner"></div>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            question: '',
            messages: [],
            isSending: false,
        };
    },
    methods: {
        async askChatGPT() {
            if (!this.question) return;

            this.messages.push({ sender: 'user', text: this.question });
            this.scrollToBottom();

            this.isSending = true;
            this.question = '';

            try {
                const token = localStorage.getItem("authToken");

                const response = await axios.post('api/ask-chatgpt',
                    {
                        question: this.messages[this.messages.length - 1].text
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${token}`
                        }
                    }
                );

                const answer = response.data.answer;

                this.messages.push({ sender: 'chatgpt', text: answer });
            } catch (error) {
                this.messages.push({ sender: 'chatgpt', text: 'Erro ao obter resposta. Tente novamente.'  });
            } finally {
                this.isSending = false;
                this.scrollToBottom();
            }
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.messagesContainer;
                container.scrollTop = container.scrollHeight;
            });
        },
    },
};
</script>

<style scoped>
.chat-container {
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
    background-color: #f7f7f7;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.chat-header {

    background: linear-gradient(135deg, rgb(1, 54, 104), rgb(52, 112, 175));
    padding: 15px;
    text-align: center;
    color: white;
    font-size: 1.5rem;
    font-weight: bold;
}

.chat-header h2 {
    font-size: 1.4rem;
}

.chat-messages {
    height: 400px;
    overflow-y: auto;
    padding: 15px;
    background-color: #ffffff;
    border-bottom: 2px solid #e0e0e0;
}

.chat-message {
    margin-bottom: 20px;
    padding: 10px;
    border-radius: 8px;
    max-width: 80%;
    line-height: 1.5;
}

.chat-message.user {
    background-color: #b6caff;
    margin-left: auto;
}

.chat-message.chatgpt {
    background-color: #e4e4e4;
    margin-right: auto;
}

.message-text {
    font-size: 1rem;
    color: #333;
}

.chat-form {
    display: flex;
    padding: 10px;
    background-color: #ffffff;
    border-top: 2px solid #e0e0e0;
}

.chat-input {
    flex-grow: 1;
    padding: 10px;
    font-size: 1rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    outline: none;
}

.chat-send-button {
    padding: 10px 15px;
    margin-left: 10px;
    background: linear-gradient(135deg, rgb(1, 54, 104), rgb(52, 112, 175));
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
}

.chat-send-button:disabled {
    background-color: #ddd;
    cursor: not-allowed;
}

.loading-spinner {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

.spinner {
    border: 4px solid rgba(255, 255, 255, 0.3);
    border-top: 4px solid #4caf50;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>
