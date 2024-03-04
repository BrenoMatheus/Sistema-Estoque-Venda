import axios from 'axios';
import { Environment } from '../../../environment';

const API_URL = Environment.URL_BASE;
const token = localStorage.getItem('userToken');

const ServiceGrupoProduto = {
    
  async getAll(params) {
    try {
        
        const headers = {
          Authorization: `Bearer ${token}`
        };
        if(!params){
          params = {};
        }
  
        const response = await axios.get(`${API_URL}/grupo_produto`, {
          params:params,
          headers: headers
        });
        
        return response.data;
      } catch (error) {
        console.error('Erro ao obter grupo de produto', error);
        throw new Error('Erro ao obter grupo de produto da API.');
      }
  }
 
};


export default ServiceGrupoProduto;