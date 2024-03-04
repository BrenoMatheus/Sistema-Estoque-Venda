import axios from 'axios';
import { Environment } from '../../../environment';

const API_URL = Environment.URL_BASE;
const token = localStorage.getItem('userToken');

const ServiceGrupoPessoa = {
    async getAll() {
    try {
        const response = await axios.get(`${API_URL}/grupo_pessoa`, {
          headers: { Authorization: `Bearer ${token}` }
        });
        
        return response.data;
      } catch (error) {
        console.error('Erro ao obter grupo de pessoa', error);
        throw new Error('Erro ao obter grupo de pessoa da API.');
      }
  }
 
};


export default ServiceGrupoPessoa;