import axios from 'axios';
import { Environment } from '../../../environment';

const API_URL = Environment.URL_BASE;
const token = localStorage.getItem('userToken');

const VendasService = {

  async getAll(params) {
    try {
      const headers = {
        Authorization: `Bearer ${token}`
      };

      const response = await axios.get(`${API_URL}/venda`, {
        params:params,
        headers: headers
      });

      return response.data;
    } catch (error) {
      console.error('Erro ao obter venda:', error);
      throw new Error('Erro ao obter venda da API.');
      return '';
    }
  },
  
  async getById(id) {
    try {
      const response = await axios.get(`${API_URL}/venda/${id}`, {
        headers: { Authorization: `Bearer ${token}` }
      });
      return response.data;
    } catch (error) {
      console.error('Erro ao obter venda:', error);
      throw new Error('Erro ao obter venda da API.');
    }
  },

  async cadastrar(data) {
    try {
        const response = await axios.post(`${API_URL}/venda`, data,{
            headers: {
              Authorization: `Bearer ${token}`
            }
          });

      if (response.status === 201) {
        await this.atualizarQuantidadeDoProduto(data.produto_id, data.quantidade);
        return { success: true, message: 'Venda cadastrada com sucesso' };
      }
    } catch (error) {
      console.error('Erro ao cadastrar a venda:', error);
      return { success: false, message: 'Erro ao cadastrar a venda' };
    }
  },

  async atualizarQuantidadeDoProduto(produtoId, quantidade) {
    try {
      const response = await axios.put(`${API_URL}/venda/${produtoId}/atualizar-quantidade`, { quantidade }, {
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
      const response = await axios.put(`${API_URL}/venda/${id}`, newData, {
        headers: { Authorization: `Bearer ${token}` }
      });
      if (response.status === 201) {
        return { success: true, message: 'Cadastro de venda atualizada com sucesso' };
      }
    } catch (error) {
      console.error('Erro ao atualizar venda:', error);
      throw new Error('Erro ao atualizar venda da API.');
    }
  },

  async remover(id) {
    try {
      const response = await axios.delete(`${API_URL}/venda/${id}`, {
        headers: { Authorization: `Bearer ${token}` }
      });
      if (response.status === 201) {
        return { success: true, message: 'Cadastro de venda removido com sucesso' };
      }
    } catch (error) {
      console.error('Erro ao remover venda:', error);
      throw new Error('Erro ao remover venda da API.');
    }
  }

};

export default VendasService;

//mail@mail.com