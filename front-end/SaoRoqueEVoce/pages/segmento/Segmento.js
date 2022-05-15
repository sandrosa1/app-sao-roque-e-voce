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
import CardDetalhes from '../../componentes/CardDetalhes';
import axios from "axios";

export default function App({route}){
  const url = "http://www.racsstudios.com/api/v1";
  const [dados,setDados] = useState([]);
  const [loading,setLoading] =useState(false);
  const [page,setPage] = useState(1);
  const [filtro,setFiltro] = useState(dados);
  const [organizar,setOrganizar] = useState('desc');
  const [ordenado,setOrdenado] = useState('');

  

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
        console.log('carregoudados')           
    }

    const btnfiltro = (tipo)=>{
      if (organizar == 'asc'){
      setOrganizar('desc')
      {(tipo == 'preco')? filtroPreco(organizar):
      (tipo == 'avaliacao')? filtroAvaliacao(organizar):
      (tipo == 'distancia')? filtroDistancia(organizar):
      filtroMaisprocurados(organizar)}
    }else {
      setOrganizar('asc')
      {(tipo == 'preco')? filtroPreco(organizar):
      (tipo == 'avaliacao')? filtroAvaliacao(organizar):
      (tipo == 'distancia')? filtroDistancia(organizar):
      filtroMaisprocurados(organizar)}
    }}

    const filtroPreco = (tipo) =>{          
      if(tipo == 'asc'){
        filtro.sort((a,b)=>(a.custoMedio > b.custoMedio)?-1:(b.custoMedio > a.custoMedio)?1:0);
        setOrdenado('Mais Caro')        
      } else {  
        filtro.sort((a,b)=>(a.custoMedio > b.custoMedio)?1:(b.custoMedio > a.custoMedio)?-1:0);       
        setOrdenado('Mais Barato')        
         }
      setFiltro(filtro)
    }
    const filtroAvaliacao = (tipo) =>{          
      if(tipo == 'asc'){
        filtro.sort((a,b)=>(a.estrelas > b.estrelas)?-1:(b.estrelas > a.estrelas)?1:0);        
        setOrdenado('Melhor Avaliado')       
      } else {  
        filtro.sort((a,b)=>(a.estrelas > b.estrelas)?1:(b.estrelas > a.estrelas)?-1:0); 
        setOrdenado('Pior Avaliado')       
         }
      setFiltro(filtro)
    }
    const filtroDistancia = (tipo) =>{          
      if(tipo == 'asc'){
        filtro.sort((a,b)=>(a.custoMedio > b.custoMedio)?-1:(b.custoMedio > a.custoMedio)?1:0);
        setOrdenado('Mais Próximos')          
      } else {  
        filtro.sort((a,b)=>(a.custoMedio > b.custoMedio)?1:(b.custoMedio > a.custoMedio)?-1:0);       
        setOrdenado('Mais Distantes')          
      }
      setFiltro(filtro)
    }
    const filtroMaisprocurados = (tipo) =>{          
      if(tipo == 'asc'){
        filtro.sort((a,b)=>(a.visualizacao > b.visualizacao)?-1:(b.visualizacao > a.visualizacao)?1:0);        
        setOrdenado('Mais Procurados')          
      } else {  
        filtro.sort((a,b)=>(a.visualizacao > b.visualizacao)?1:(b.visualizacao > a.visualizacao)?-1:0);       
        setOrdenado('Menos Procurados')          
         }
      setFiltro(filtro)
    }

    useEffect(()=>{            
        setFiltro(dados.filter(item=>{if(item.segmento == busca){return true}}))
    },[dados]);
      
    
 console.log(filtro.custoMedio) 

    let icon = route.params?.icon
    let tipo = route.params?.tipo
    let pesquisa= route.params?.pesquisa
    let busca = route.params?.busca
  return (
    <View style={estilos.container}>
        <ScrollView showsVerticalScrollIndicator={false}>
            <View style={{flex:1}}>      
                <NavPages 
                    icon={icon}
                    title={tipo}/>
                <BuscarBar title={pesquisa}/>
                <View style={{flexDirection:'row', marginTop:20, justifyContent:'space-around'}}>
                  <TouchableOpacity style={estilos.containerIcon} onPress={()=>{btnfiltro('preco')}}>
                      <Image style={estilos.img} source={require('../../images/menupages/preco.png')}/>
                      <Text style={estilos.txt}>Preço</Text>
                  </TouchableOpacity>
                  <TouchableOpacity style={estilos.containerIcon} onPress={()=>{btnfiltro('avaliacao')}}>
                      <Image style={estilos.img} source={require('../../images/menupages/estrelas.png')}/>
                      <Text style={estilos.txt}>Avaliação</Text>
                  </TouchableOpacity>
                  <TouchableOpacity style={estilos.containerIcon} onPress={()=>{btnfiltro('distancia')}}>
                      <Image style={estilos.img} source={require('../../images/menupages/distancia.png')}/>
                      <Text style={estilos.txt}>Distância</Text>
                  </TouchableOpacity>
                  <TouchableOpacity style={estilos.containerIcon} onPress={()=>{btnfiltro('maisprocurados')}}>
                      <Image style={estilos.img} source={require('../../images/menupages/maisprocurados.png')}/>
                      <Text style={estilos.txt}>Mais Procurados</Text>
                  </TouchableOpacity>
                  <TouchableOpacity style={estilos.containerIcon}>
                      <Image style={estilos.img} source={require('../../images/menupages/filtro.png')}/>
                      <Text style={estilos.txt}>Filtro</Text>
                  </TouchableOpacity>                 
                </View>
                <Image source={require('../../images/line.png')} style={{alignSelf:'center', resizeMode:'contain', marginTop:10}}/> 
                <View style={{paddingHorizontal:30, paddingVertical:15}}>
                {ordenado? <Text style={[estilos.txt,{textAlign:'left', fontSize:15}]}>Ordenado por {ordenado}</Text>:<View></View>}
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
    containerIcon:{
      height:70,
      width:75,
      alignItems:'center',
    },
    txt:{
        paddingTop:6,
        fontFamily:'Roboto-Regular',
        textAlign:'center',
        fontSize:12,
        color:'#111'
    },
    img:{
      height:40,
      width:40,
      resizeMode:'contain'
    }   
});