import axios from 'axios';
import { Environment } from '../../../environment';

const API_URL = Environment.URL_BASE;
const token = localStorage.getItem('userToken');

const marcaService = {
    async getAll(params) {
    try {
        
        const headers = {
          Authorization: `Bearer ${token}`
        };
        if(!params){
          params = {};
        }
  
        const response = await axios.get(`${API_URL}/marca`, {
          params:params,
          headers: headers
        });
        
        return response.data;
      } catch (error) {
        console.error('Erro ao obter marcas', error);
        throw new Error('Erro ao obter marcas da API.');
      }
  }
 
};


export default marcaService;