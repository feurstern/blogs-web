import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const isAuthenticated = ref(false);
const user = ref(null);
const token = ref('');

export function useAuth() {
  const router = useRouter();

  const login = async (email: string, password: string) => {
    try {
      const response = await axios.post('http://127.0.0.1:8000/api/admin/login', { email, password });
      token.value = response.data.token;
      user.value = response.data.user;
      isAuthenticated.value = true;


      localStorage.setItem('auth_token', token.value);
      router.push('/blogs');
    } catch (error) {
      console.error('Login failed', error);
      throw new Error('Invalid login credentials');
    }
  };
 
  const logout = () => {
    token.value = '';
    user.value = null;
    isAuthenticated.value = false;
    localStorage.removeItem('auth_token');
    router.push('/login');
  };

  const checkAuth = () => {
    const storedToken = localStorage.getItem('auth_token');
    if (storedToken) {
      token.value = storedToken;
      isAuthenticated.value = true;
    }
  };

  return {
    isAuthenticated,
    user,
    login,
    logout,
    checkAuth,
  };
}
