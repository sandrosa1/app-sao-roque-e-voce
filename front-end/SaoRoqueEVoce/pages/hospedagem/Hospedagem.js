import React,{useState,useEffect} from 'react';
import {
  StyleSheet,
  Text,
  View,
  ScrollView,
  Image,
  FlatList,
  TouchableOpacity
} from 'react-native';
import NavPages from '../../componentes/NavPages';
import BuscarBar from '../../componentes/BuscarBar';
import MenuPages from '../../componentes/MenuPages';
import CardDetalhes from '../../componentes/CardDetalhes';
import axios from "axios";

export default function App(){
  const url = "http://www.racsstudios.com/api/v1";
  const [dados,setDados] = useState([]);
  const [loading,setLoading] =useState(false);
  const [page,setPage] = useState(1);
  const [filtro,setFiltro] = useState(dados);

  

  useEffect(()=>{
      loadApi();
  },[]);

  async function loadApi(){
      if(loading) return;

      setLoading(true)

      // const response = await axios.get(`${url}allapps/turismo?page=${page}`);
      // const response = await axios.get(`${url}/apps?page=${page}`);
      const response = await axios.get(`${url}/allapps`);

      
      // if(page < response.data.paginacao.quantidadeTotalPaginas+1){
          setDados(response.data.apps);
          // setPage(page + 1)};
          setLoading(false);            
      }

      useEffect(()=>{            
          setFiltro(dados.filter(item=>{if(item.segmento == 'hospedagem'){return true}}))
      },[dados]);
      
    
 console.log(filtro) 

  return (
    <View style={estilos.container}>
        <ScrollView showsVerticalScrollIndicator={false}>
            <View style={{flex:1}}>      
                <NavPages 
                    icon={require('../../images/menubar/hotel.png')}
                    title={'Hospedagem'}/>
                <BuscarBar title={'Hospedagem'}/>
                <View style={{flexDirection:'row', marginTop:20, justifyContent:'space-around'}}>
                  <MenuPages 
                    icon={require('../../images/menupages/preco.png')}
                    title={'Preço'}/>
                  <MenuPages 
                    icon={require('../../images/menupages/estrelas.png')}
                    title={'Avaliação'}/>
                  <MenuPages 
                    icon={require('../../images/menupages/distancia.png')}
                    title={'Distância'}/>
                  <MenuPages 
                    icon={require('../../images/menupages/maisprocurados.png')}
                    title={'Mais Procurados'}/>
                  <MenuPages 
                    icon={require('../../images/menupages/filtro.png')}
                    title={'Filtro'}/>
                </View>
                <Image source={require('../../images/line.png')} style={{alignSelf:'center', resizeMode:'contain', marginTop:10}}/> 
                <View style={{paddingHorizontal:30, paddingVertical:15}}>
                <Text style={estilos.txt}>Ordenado por </Text>                   
                     <View style={{flex:1, alignItems:'center', marginVertical:20, marginBottom:10}}>           
                      <FlatList               
                      data={filtro}
                      keyExtractor={item => String(item.idApp)}
                      renderItem={({item})=> <CardDetalhes data={item}/>}
                      />
                      </View> 
                </View>
                <View style={{marginVertical:5, marginBottom:20}}>
                        <TouchableOpacity style={{flexDirection:'row', alignItems:'center', justifyContent:'center'}} onPress={loadApi}>
                        <Image style={{marginHorizontal:10, width:25, height:25}} source={require('../../images/paginadetalhes/mais.png')}/>
                        <Text style={{fontFamily:'Poppins-Regular',color:'#910046',fontSize:14}}>Carregar mais</Text>
                        </TouchableOpacity>
        </View> 
            </View>
        </ScrollView>
    </View>
   
  );
};

const estilos = StyleSheet.create({
    container:{
        flex:1,
        justifyContent:'center'
    },
  
    menuBar:{
        Flex:1,
        marginTop:18,
    },

    h1:{
        marginLeft:10,
        fontSize:24,
        fontFamily:'Poppins-Regular',
        color:'#910046',
    },
    txt:{
        fontSize:15,
        fontFamily:'Poppins-Regular',
        color:'#414141',
    },
});