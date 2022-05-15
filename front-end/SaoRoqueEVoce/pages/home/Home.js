import React,{useState,useEffect} from 'react';
import {
  StyleSheet,
  Text,
  View,
  Image,
  ScrollView,
  FlatList,
  TouchableOpacity,
  ActivityIndicator
} from 'react-native';
import Header from '../../componentes/Header';
import MenuBar from '../../componentes/MenuBar';
import BuscarBar from '../../componentes/BuscarBar';
import CardHome from '../../componentes/CardHome';
import Globais from '../../componentes/Globais';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { useIsFocused } from '@react-navigation/native';
import axios from "axios";

export default function App(){
    const url = "http://www.racsstudios.com/api/v1";
    const [dados,setDados] = useState([]);
    const [loading,setLoading] =useState(false);
    const [page,setPage] = useState(1);
    const [filtro,setFiltro] = useState(dados);
    const [login,setLoagin] = useState(true);
    const [logado,setLogado] = useState(false);    
  
    const isFocused = useIsFocused();


    useEffect(()=>{
        loadApi();        
    },[]);


    async function loadApi(){
        if(loading) return;

        if(page <= 1){
        setLoading(true)
        }

        const response = await axios.get(`${url}/apps?page=${page}`);

        
        if(page < response.data.paginacao.quantidadeTotalPaginas+1){
            setDados([...dados,...response.data.apps]);
            setPage(page + 1)};
            setTimeout(()=>{setLoading(false);},800);            
        }

        useEffect(()=>{            
            setFiltro(dados.filter(item=>{if(item.segmento !== 'servicos'){return true}}))
        },[dados]);

        function verificarLogin(){
            if(Globais.dados?.usernome){
                setLogado(true);
                setLoagin(false);
            } else {
                setLogado(false);
                setLoagin(true);
            }
        }
        

      
        useEffect(()=>{
            const dadosdousuario = async ()=>{           
                const json = await AsyncStorage.getItem("usuario");
                if(json){
                    Globais.dados = JSON.parse(json)
                }     
            }
            console.log(Globais.dados)
            verificarLogin();
            dadosdousuario()
        },[isFocused]);
        
   
  return (
    <View style={estilos.container}>
    <ScrollView showsVerticalScrollIndicator={false}>
      <Header nobr={true} login={login} logado={logado} goingback={false}/>
      <View style={{flex:1}}>
      
        <BuscarBar/>

        <View style={estilos.menuBar}>
            <ScrollView
            horizontal={true}
            showsHorizontalScrollIndicator={false}>
                <MenuBar
                nome={'Pontos Turísticos'}
                icon={require('../../images/menubar/pontos.png')}
                pesquisa={'Turismo'}
                busca={'turismo'}
                />
                <MenuBar
                nome={'Hospedagem'}
                icon={require('../../images/menubar/hotel.png')}
                pesquisa={'Hospedagem'}
                busca={'hospedagem'}
                />
                <MenuBar
                nome={'Gastronomia'}
                icon={require('../../images/menubar/gastronomia.png')}
                pesquisa={'Gastronomia'}
                busca={'gastronomia'}
                />
                <MenuBar
                nome={'Comércio'}
                icon={require('../../images/menubar/comercio.png')}
                pesquisa={'Comércio'}
                busca={'comercio'}
                />
                <MenuBar
                nome={'Eventos'}
                icon={require('../../images/menubar/evento.png')}
                pesquisa={'Eventos'}
                busca={'evento'}
                />
                <MenuBar
                nome={'Serviços'}
                icon={require('../../images/menubar/servico.png')}
                pesquisa={'Servicos'}
                />
                <MenuBar
                nome={'Sobre Nós'}
                icon={require('../../images/menubar/quemsomos.png')}
                pesquisa={'QuemSomos'}
                />
                <MenuBar
                nome={'Ajustes'}
                icon={require('../../images/menubar/config.png')}
                pesquisa={'Configuracao'}
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
        {!loading ?
        <View style={{flex:1, alignItems:'center', marginVertical:20, marginBottom:10}}>           
               <FlatList               
               data={filtro}
               keyExtractor={item => String(item.idApp)}
               renderItem={({item})=> <CardHome data={item}/>}
               />
        <View style={{marginVertical:5, marginBottom:20}}>
            <TouchableOpacity style={{flexDirection:'row', alignItems:'center', justifyContent:'center'}} onPress={loadApi}>
                <Image style={{marginHorizontal:10, width:25, height:25}} source={require('../../images/paginadetalhes/mais.png')}/>
                <Text style={{fontFamily:'Poppins-Regular',color:'#910046',fontSize:14}}>Carregar mais</Text>
            </TouchableOpacity>
        </View>      
        </View>:
        <View style={{marginTop:100,alignItems:'center', justifyContent: 'center'}}>
                    <ActivityIndicator size={50} color="#910046"/>
        </View>} 

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