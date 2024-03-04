import axios from 'axios';
import { Environment } from '../../../environment';

const API_URL = Environment.URL_BASE;

const token = localStorage.getItem('userToken');

const ComprasService = {

  async getAll(params) {
    try {
      const headers = {
        Authorization: `Bearer ${token}`
      };

      const response = await axios.get(`${API_URL}/compra`, {
        params:params,
        headers: headers
      });

      return response.data;
    } catch (error) {
      console.error('Erro ao obter compra:', error);
      throw new Error('Erro ao obter compra da API.');
      return '';
    }
  },
  async getById(id) {
    try {
      const response = await axios.get(`${API_URL}/compra/${id}`, {
        headers: { Authorization: `Bearer ${token}` }
      });
      return response.data;
    } catch (error) {
      console.error('Erro ao obter compra:', error);
      throw new Error('Erro ao obter compra da API.');
    }
  },

  async cadastrar(data) {
    try {
        const response = await axios.post(`${API_URL}/compra`, data,{
            headers: {
              Authorization: `Bearer ${token}`
            }
          });

      if (response.status === 201) {
        await this.atualizarQuantidadeDoProduto(data.produto_id, data.quantidade);
        return { success: true, message: 'Compra cadastrada com sucesso' };
      }
    } catch (error) {
      console.error('Erro ao cadastrar a compra:', error);
      return { success: false, message: 'Erro ao cadastrar a compra' };
    }
  },

  async atualizarQuantidadeDoProduto(produtoId, quantidade) {
    try {
      const response = await axios.put(`${API_URL}/compra/${produtoId}/atualizar-quantidade`, { quantidade }, {
        headers: { Authorization: `Bearer ${token}` }
      });
      if (response.status === 201) {
        console.log('Quantidade do produto atualizada com sucesso');
      }
    } catch (error) {
      console.error('Erro ao atualizar quantidade do produto:', error);
      throw new Error('Erro ao atualizar quantidade do produto da API.');
    }
  },

  async atualizar(id, newData) {
    try {
      const response = await axios.put(`${API_URL}/compra/${id}`, newData, {
        headers: { Authorization: `Bearer ${token}` }
      });
      if (response.status === 201) {
        return { success: true, message: 'Cadastro de compra atualizada com sucesso' };
      }
    } catch (error) {
      console.error('Erro ao atualizar compra:', error);
      throw new Error('Erro ao atualizar compra da API.');
    }
  },

  async remover(id) {
    try {
      const response = await axios.delete(`${API_URL}/compra/${id}`, {
        headers: { Authorization: `Bearer ${token}` }
      });
      if (response.status === 201) {
        return { success: true, message: 'Cadastro de compra removido com sucesso' };
      }
    } catch (error) {
      console.error('Erro ao remover compra:', error);
      throw new Error('Erro ao remover compra da API.');
    }
  }

};

export default ComprasService;

//mail@mail.com