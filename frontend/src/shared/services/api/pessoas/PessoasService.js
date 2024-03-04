import axios from 'axios';
import { Environment } from '../../../environment';

const API_URL = Environment.URL_BASE;
const token = localStorage.getItem('userToken');

const PessoasService = {

  async getAll(params) {
    try {
      const headers = {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'application/json'
      };

      const response = await axios.get(`${API_URL}/pessoa`, {
        params:params,
        headers: headers
      });
      
      return response.data;
    } catch (error) {
      console.error('Erro ao obter pessoa:', error);
      throw new Error('Erro ao obter pessoa da API.');
      return '';
    }
  },
  async getById(id) {
    try {
      const response = await axios.get(`${API_URL}/pessoa/${id}`, {
        headers: { Authorization: `Bearer ${token}` }
      });
      return response.data;
    } catch (error) {
      console.error('Erro ao obter pessoa:', error);
      throw new Error('Erro ao obter pessoa da API.');
    }
  },

  async cadastrar(data) {
    try {
        const response = await axios.post(`${API_URL}/pessoa`, data,{
            headers: {
              Authorization: `Bearer ${token}`
            }
          });

      if (response.status === 201) {
        return { success: true, message: 'Pessoa cadastrada com sucesso' };
      }
    } catch (error) {
      console.error('Erro ao cadastrar a pessoa:', error);
      return { success: false, message: 'Erro ao cadastrar a pessoa' };
    }
  },

  async atualizar(id, newData) {
    try {
      const response = await axios.put(`${API_URL}/pessoa/${id}`, newData, {
        headers: { Authorization: `Bearer ${token}` }
      });
      if (response.status === 201) {
        return { success: true, message: 'Cadastro de pessoa atualizada com sucesso' };
      }
    } catch (error) {
      console.error('Erro ao atualizar pessoa:', error);
      throw new Error('Erro ao atualizar pessoa da API.');
    }
  },

  async remover(id) {
    try {
      const response = await axios.delete(`${API_URL}/pessoa/${id}`, {
        headers: { Authorization: `Bearer ${token}` }
      });
      if (response.status === 201) {
        return { success: true, message: 'Cadastro de pessoa removido com sucesso' };
      }
    } catch (error) {
      console.error('Erro ao remover pessoa:', error);
      throw new Error('Erro ao remover pessoa da API.');
    }
  }

};

export default PessoasService;

//mail@mail.com