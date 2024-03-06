import axios from 'axios';
import { Environment } from '../../../environment';

const API_URL = Environment.URL_BASE;
const token = localStorage.getItem('userToken');

const AuthService = {
  login(email, password) {
    return axios
      .post(`${API_URL}/login`, { email, password })
      .then(response => {
        if (response.data.token) {
          localStorage.setItem('userToken', response.data.token);
        }
        return response.data;
      });
  },

  async getById(id) {
    try {
      const response = await axios.get(`${API_URL}/user/${id}`, {
        headers: { Authorization: `Bearer ${token}` }
      });
      return response.data;
    } catch (error) {
      console.error('Erro ao obter Usuario:', error);
      throw new Error('Erro ao obter Usuario da API.');
    }
  },

  logout() {
    localStorage.removeItem('userToken');
  },
  
  isAuthenticated() {
    return localStorage.getItem('userToken') !== null;
  },

  async register(email, password, password_confirmation, nome) {
    let nameToken = nome;
    return await axios
    .post(`${API_URL}/register`, {
      email,
      password,
      password_confirmation,
      nameToken,
    })
    .then(response => {
      
        console.log(response.data.user);
        return response.data.user;
      });
  },
};

export default AuthService;
