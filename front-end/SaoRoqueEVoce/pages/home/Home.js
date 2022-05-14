import React,{useState,useEffect} from 'react';
import {
  StyleSheet,
  Text,
  View,
  Image,
  ScrollView,
  FlatList,
  TouchableOpacity
} from 'react-native';
import Header from '../../componentes/Header';
import MenuBar from '../../componentes/MenuBar';
import BuscarBar from '../../componentes/BuscarBar';
import CardHome from '../../componentes/CardHome';
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

        const response = await axios.get(`${url}/apps?page=${page}`);

        
        if(page < response.data.paginacao.quantidadeTotalPaginas+1){
            setDados([...dados,...response.data.apps]);
            setPage(page + 1)};
            setLoading(false);            
        }

        useEffect(()=>{            
            setFiltro(dados.filter(item=>{if(item.segmento !== 'servicos'){return true}}))
        },[dados]);
        
      
   console.log(filtro)  
  return (
    <View style={estilos.container}>
    <ScrollView showsVerticalScrollIndicator={false}>
      <Header nobr={true} login={true}/>
      <View style={{flex:1}}>
      
        <BuscarBar/>

        <View style={estilos.menuBar}>
            <ScrollView
            horizontal={true}
            showsHorizontalScrollIndicator={false}>
                <MenuBar
                nome={'Pontos Turísticos'}
                icon={require('../../images/menubar/pontos.png')}
                nav={'PontosTuristicos'}
                />
                <MenuBar
                nome={'Hospedagem'}
                icon={require('../../images/menubar/hotel.png')}
                nav={'Hospedagem'}
                />
                <MenuBar
                nome={'Gastronomia'}
                icon={require('../../images/menubar/gastronomia.png')}
                nav={'Gastronomia'}
                />
                <MenuBar
                nome={'Comércio'}
                icon={require('../../images/menubar/comercio.png')}
                nav={'Comercio'}
                />
                <MenuBar
                nome={'Eventos'}
                icon={require('../../images/menubar/evento.png')}
                nav={'Eventos'}
                />
                <MenuBar
                nome={'Serviços'}
                icon={require('../../images/menubar/servico.png')}
                nav={'Servicos'}
                />
                <MenuBar
                nome={'Sobre Nós'}
                icon={require('../../images/menubar/quemsomos.png')}
                nav={'QuemSomos'}
                />
                <MenuBar
                nome={'Ajustes'}
                icon={require('../../images/menubar/config.png')}
                nav={'Configuracao'}
                />
            </ScrollView>
        <Image source={require('../../images/line.png')} style={{alignSelf:'center', resizeMode:'contain'}}/> 
        </View>
        <View style={{paddingHorizontal:30}}>
            <Text style={estilos.h1}>Destaques</Text>
            <Text style={estilos.txt}>
                Em dúvida para onde ir?
            </Text>
            <Text style={estilos.txt}>
                Conheça nossas dicas para a semana.
            </Text>
        </View>
        <View style={{flex:1, alignItems:'center', marginVertical:20, marginBottom:10}}>           
               <FlatList               
               data={filtro}
               keyExtractor={item => String(item.idApp)}
               renderItem={({item})=> <CardHome data={item}/>}
               />
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
        alignItems:'center'
    },
    h1:{
        marginTop:15,
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