import axios from 'axios';
import { Environment } from '../../../environment';

const API_URL = Environment.URL_BASE;
const token = localStorage.getItem('userToken');

const ProdutosService = {

  async getAll(params) {
    try {
      const headers = {
        Authorization: `Bearer ${token}`
      };

      const response = await axios.get(`${API_URL}/produto`, {
        params:params,
        headers: headers
      });

      return response.data;
    } catch (error) {
      console.error('Erro ao obter produto:', error);
      throw new Error('Erro ao obter produto da API.');
      return '';
    }
  },
  async getById(id) {
    try {
      const response = await axios.get(`${API_URL}/produto/${id}`, {
        headers: { Authorization: `Bearer ${token}` }
      });
      return response.data;
    } catch (error) {
      console.error('Erro ao obter produto:', error);
      throw new Error('Erro ao obter produto da API.');
    }
  },

  async cadastrar(data) {
    try {
        const response = await axios.post(`${API_URL}/produto`, data,{
            headers: {
              Authorization: `Bearer ${token}`
            }
          });

      if (response.status === 201) {
        return { success: true, message: 'Produto cadastrada com sucesso' };
      }
    } catch (error) {
      console.error('Erro ao cadastrar a produto:', error);
      return { success: false, message: 'Erro ao cadastrar a produto' };
    }
  },

  async atualizar(id, newData) {
    try {
      const response = await axios.put(`${API_URL}/produto/${id}`, newData, {
        headers: { Authorization: `Bearer ${token}` }
      });
      if (response.status === 201) {
        return { success: true, message: 'Cadastro de produto atualizada com sucesso' };
      }
    } catch (error) {
      console.error('Erro ao atualizar produto:', error);
      throw new Error('Erro ao atualizar produto da API.');
    }
  },

  async remover(id) {
    try {
      const response = await axios.delete(`${API_URL}/produto/${id}`, {
        headers: { Authorization: `Bearer ${token}` }
      });
      if (response.status === 201) {
        return { success: true, message: 'Cadastro de produto removido com sucesso' };
      }
    } catch (error) {
      console.error('Erro ao remover produto:', error);
      throw new Error('Erro ao remover produto da API.');
    }
  }

};

export default ProdutosService;

//mail@mail.com