<template>
    <q-page class="flex flex-center">
      <q-card>
        <q-card-section>
          <q-input v-model="email" label="Email" type="email" />
          <q-input v-model="password" label="Password" type="password" />
        </q-card-section>
        <q-card-actions align="right">
            <q-btn label="Login" @click="handleLogin" color="primary" />

        </q-card-actions>
      </q-card>
    </q-page>
  </template>
  
  <script lang="ts" setup>
  import { ref } from 'vue';
  import { useAuth } from 'src/composables/useAuth';
  
  const { login } = useAuth();
  const email = ref('');
  const password = ref('');
  
  const handleLogin = async () => {
    try {
      await login(email.value, password.value);
    } catch (error) {
      console.log(error);
    }
  };
  </script>
  