import React,{useState,useRef,useEffect} from 'react';
import {
  StyleSheet,
  Text,
  View,
  ScrollView,
  Image,
  Dimensions,
  TouchableOpacity,
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import NavPages from './NavPages';
import axios from "axios";
import Carousel from 'react-native-snap-carousel';
import Globais from './Globais';

export default function App({route}){
    const navigation = useNavigation();
    const {width: screenWidth, height: screenHeight} = Dimensions.get('window');
    const url = `http://www.racsstudios.com/api/v1/apps/${route.params.id}`;
    const [dados,setDados] = useState([]);
    const [loading,setLoading] =useState(false);
 
   
    useEffect(()=>{
        loadApi();
    },[]);

    async function loadApi(){
        if(loading) return;

        setLoading(true)

        const response = await axios.get(`${url}`);
        setDados(response.data);
        
        setLoading(false);
        
    }
    
    
    const carouselRef = useRef(null);

    const lista = ([
        {
            img: dados.img1
        },
        {
            img: dados.complemeto?.img2
        },
        {
            img: dados.complemeto?.img3
        },      
      ]);
     

      const renderItem = ({ item, index }) => {
        return(
          <View>
            <View>
              <Image
            //   source={{uri: item.img}} buscar imagem por url
              source={{uri: item.img}}
              style={estilos.carouselImg}
              />
            </View>
          </View>
        );
      };

          
          
    
    let estrelas = dados.estrelas;
    let custo = dados.custoMedio;

    let arrayestrela = []
    let arraycusto = []
  
    let i = 0

    for(i=0 ; i<5 ; i++){
        if(estrelas > 0.5){
             arrayestrela[i] = require('../images/paginadetalhes/star1.png')
            estrelas = estrelas - 1
        } else {
            if(estrelas <= 0.5 && estrelas > 0){
             arrayestrela[i] = require('../images/paginadetalhes/star2.png')
             estrelas = 0
        } else {
            arrayestrela[i]= require('../images/paginadetalhes/star0.png')
        }
    }}

    for(i=0 ; i<5 ; i++){
        if(custo > 0){
             arraycusto[i] = require('../images/paginadetalhes/custo1.png')
            custo = custo - 1
        } else {            
             arraycusto[i] = require('../images/paginadetalhes/custo0.png')
        }
    }

    let tipo = '';
    let icon = '';

    if (dados.segmento == 'turismo'){tipo = 'Pontos Turísticos' ; icon = require('../images/menubar/pontos.png')};
    if (dados.segmento == 'hospedagem'){tipo = 'Hospedagem' ; icon = require('../images/menubar/hotel.png')};
    if (dados.segmento == 'gastronomia'){tipo = 'Gastronomia' ; icon = require('../images/menubar/gastronomia.png')};
    if (dados.segmento == 'evento'){tipo = 'Eventos' ; icon = require('../images/menubar/evento.png')};
    if (dados.segmento == 'comercio'){tipo = 'Comércio' ; icon = require('../images/menubar/comercio.png')};
    if (dados.segmento == 'servicos'){tipo = 'Serviços' ; icon = require('../images/menubar/pontos.png')};
    

  return (
    <View style={estilos.container}>
        <ScrollView showsVerticalScrollIndicator={false}>
            <View style={{flex:1}}>      
                <NavPages 
                    icon={icon}
                    title={tipo}/>
               <View>
                   <Text style={{fontSize:24, fontFamily:'Roboto-Bold', textAlign:'center', color:'#000'}}>{dados.nomeFantasia}</Text>
               </View>
               <View style={{flex:1,alignItems:'center'}}>
                    <View style={{width:Dimensions.get('window').width-Dimensions.get('window').width*0.15, paddingHorizontal:15,marginVertical:15}}>
                        <View style={{flexDirection:'row', justifyContent:'space-between', alignItems:'center'}}>
                            <TouchableOpacity onPress={() => navigation.navigate('PaginaDetalhesComentario',{
                                icon: icon, tipo:tipo, id:dados.idApp})}>
                            <View style={{flexDirection:'row', alignItems:'center'}}>
                                <Image style={estilos.img} source={arrayestrela[0]}/>                                       
                                <Image style={estilos.img} source={arrayestrela[1]}/>                                       
                                <Image style={estilos.img} source={arrayestrela[2]}/>                                       
                                <Image style={estilos.img} source={arrayestrela[3]}/>                                       
                                <Image style={estilos.img} source={arrayestrela[4]}/>
                                <View style={{width:50}}>
                                <Image style={{marginLeft:5, width:21, height:21}} source={require('../images/paginadetalhes/minichat.png')}/>
                                <Text style={estilos.txt}>{dados.avaliacao}</Text>
                                </View>
                            </View>
                            </TouchableOpacity>
                            <View style={{flexDirection:'row', paddingHorizontal:2}}>
                                <Image style={estilos.img} source={arraycusto[0]}/>                                       
                                <Image style={estilos.img} source={arraycusto[1]}/>                                       
                                <Image style={estilos.img} source={arraycusto[2]}/>                                       
                                <Image style={estilos.img} source={arraycusto[3]}/>                                       
                                <Image style={estilos.img} source={arraycusto[4]}/>                                
                            </View>
                        </View>
                    </View>
               </View>

               <View style={estilos.slideView}>
                <Carousel
                style={estilos.carousel}
                ref={carouselRef}
                data={lista}
                renderItem={renderItem}
                sliderWidth={screenWidth}
                itemWidth={Dimensions.get('window').width-Dimensions.get('window').width*0.20}
                inactiveSlideOpacity={0.5}              
                />
                </View>

            
                <View>                   
                <View style={{alignItems:'center',marginBottom:5, marginTop:10}}>
                    <View style={{flex:1,flexDirection:'row', alignItems:'center'}}>
                        <Image source={require('../images/paginadetalhes/localizacao.png')}/>            
                        <Text style={estilos.txtDistancia}>Você está a ?? km de distância.</Text>
                    </View>
                </View>

                <View style={{alignItems:'center', marginVertical:10}}>
                <View style={{width:Dimensions.get('window').width-Dimensions.get('window').width*0.10,flexDirection:'row',flexWrap:'wrap'}}>
                    {dados.complemeto?.estacionamento?
                    <View style={{flexDirection:'row', alignItems:'center', marginVertical:8, width:'33%',paddingHorizontal:5}}>
                        <Image source={require('../images/paginadetalhes/estacionamento.png')}/>            
                        <Text style={{fontSize:10, fontFamily:'Poppins-Regular', color:'#414141',paddingLeft:5}}>Estacionamento</Text>
                    </View>
                    :<View></View>}

                    {dados.complemeto?.arCondicionado?
                    <View style={{flexDirection:'row', alignItems:'center', marginVertical:8, width:'33%',paddingHorizontal:5}}>
                        <Image source={require('../images/paginadetalhes/arcondicionado.png')}/>            
                        <Text style={{fontSize:10, fontFamily:'Poppins-Regular', color:'#414141',paddingLeft:5}}>Ar-Condicionado</Text>
                    </View>
                    :<View></View>}

                    {dados.complemeto?.acessibilidade?
                    <View style={{flexDirection:'row', alignItems:'center', marginVertical:8, width:'33%',paddingHorizontal:5}}>
                        <Image source={require('../images/paginadetalhes/acessibilidade.png')}/>            
                        <Text style={{fontSize:10, fontFamily:'Poppins-Regular', color:'#414141',paddingLeft:5}}>Acessibilidade</Text>
                    </View>
                    :<View></View>}

                    {dados.complemeto?.academia?
                    <View style={{flexDirection:'row', alignItems:'center', marginVertical:8, width:'33%',paddingHorizontal:5}}>
                        <Image source={require('../images/paginadetalhes/academia.png')}/>            
                        <Text style={{fontSize:10, fontFamily:'Poppins-Regular', color:'#414141',paddingLeft:5}}>Academia</Text>
                    </View>
                    :<View></View>}

                    {dados.complemeto?.piscina?
                    <View style={{flexDirection:'row', alignItems:'center', marginVertical:8, width:'33%',paddingHorizontal:5}}>
                        <Image source={require('../images/paginadetalhes/piscina.png')}/>            
                        <Text style={{fontSize:10, fontFamily:'Poppins-Regular', color:'#414141',paddingLeft:5}}>Piscina</Text>
                    </View>
                    :<View></View>}

                    {dados.complemeto?.wiFi?
                    <View style={{flexDirection:'row', alignItems:'center', marginVertical:8, width:'33%',paddingHorizontal:5}}>
                        <Image source={require('../images/paginadetalhes/wifi.png')}/>            
                        <Text style={{fontSize:10, fontFamily:'Poppins-Regular', color:'#414141',paddingLeft:5}}>Wi-fi</Text>
                    </View>
                    :<View></View>}

                    {dados.complemeto?.refeicao?
                    <View style={{flexDirection:'row', alignItems:'center', marginVertical:8, width:'33%',paddingHorizontal:5}}>
                        <Image source={require('../images/paginadetalhes/refeicao.png')}/>            
                        <Text style={{fontSize:10, fontFamily:'Poppins-Regular', color:'#414141',paddingLeft:5}}>Refeição</Text>
                    </View>
                    :<View></View>}

                    {dados.complemeto?.trilhas?
                    <View style={{flexDirection:'row', alignItems:'center', marginVertical:8, width:'33%',paddingHorizontal:5}}>
                        <Image source={require('../images/paginadetalhes/trilhas.png')}/>            
                        <Text style={{fontSize:10, fontFamily:'Poppins-Regular', color:'#414141',paddingLeft:5}}>Trilhas</Text>
                    </View>
                    :<View></View>}

                    </View>
                </View>

                <Image source={require('../images/line3.png')} style={{alignSelf:'center', resizeMode:'contain', marginVertical:10}}/> 

                <View style={{paddingHorizontal:30, marginVertical:10}}>
                    <Text style={{fontFamily:'Poppins-Regular', color:'#414141', fontSize:14}}>
                        {dados.complemeto?.descricao}
                    </Text>
                </View>   


                <View style={{alignItems:'center', marginVertical:10}}>
                    <Image source={require('../images/line.png')} style={{alignSelf:'center', resizeMode:'contain', marginVertical:10}}/> 
                        <TouchableOpacity onPress={() => navigation.navigate('PaginaDetalhesComentario',{
                                icon: icon, tipo:tipo, id:dados.idApp})}>
                            <View style={{flexDirection:'row'}}>
                                <Text style={{fontFamily:'Poppins-Regular', fontSize:18, color:'#910046',}}>Comentários</Text>
                                <View style={{width:50, marginLeft:5}}>
                                    <Image style={{marginLeft:5, width:21, height:21}} source={require('../images/paginadetalhes/minichat.png')}/>
                                    <Text style={estilos.txt}>{dados.avaliacao}</Text>
                                </View>
                            </View>
                        </TouchableOpacity>
                    <Image source={require('../images/line.png')} style={{alignSelf:'center', resizeMode:'contain', marginVertical:10}}/> 
                </View>

                <View style={{paddingHorizontal:25,marginTop:25, marginBottom:30}}>
                    <View style={{flexDirection:'row',alignItems:'center'}}>
                        <Image style={{width:30, height:30}} source={require('../images/servicos/funcionamento.png')}/>
                        <Text style={[estilos.h1,{fontSize:18}]}>Horário de Funcionamento</Text>
                    </View>
                    <View style={{flexDirection:'row',paddingHorizontal:25, marginTop:20}}>
                        <Text style={[estilos.txtDistancia,{fontSize:15, width:80}]}>Seg a Sex </Text>
                        <Text style={{fontFamily:'Poppins-Regular', color:'#414141', fontSize:14,}}>-   {dados.complemeto?.semana}</Text>
                    </View>
                    <View style={{flexDirection:'row',paddingHorizontal:25, }}>
                        <Text style={[estilos.txtDistancia,{fontSize:15, width:80}]}>Sábado </Text>
                        <Text style={{fontFamily:'Poppins-Regular', color:'#414141', fontSize:14,}}>-   {dados.complemeto?.sabado}</Text>
                    </View>
                    <View style={{flexDirection:'row',paddingHorizontal:25, }}>
                        <Text style={[estilos.txtDistancia,{fontSize:15, width:80}]}>Domingo </Text>
                        <Text style={{fontFamily:'Poppins-Regular', color:'#414141', fontSize:14,}}>-   {dados.complemeto?.domingo}</Text>
                    </View>
                    <View style={{flexDirection:'row',paddingHorizontal:25, }}>
                        <Text style={[estilos.txtDistancia,{fontSize:15, width:80}]}>Feriado </Text>
                        <Text style={{fontFamily:'Poppins-Regular', color:'#414141', fontSize:14,}}>-   {dados.complemeto?.feriado}</Text>
                    </View>
                </View>

                <View style={{paddingHorizontal:30,marginTop:15, marginBottom:30}}>
                    {dados.logradouro?
                    <View style={{flexDirection:'row', alignItems:'center',marginBottom:20}}> 
                        <Image source={require('../images/paginadetalhes/rota.png')}/>
                        <Text style={{fontFamily:'Poppins-Regular', color:'#414141', fontSize:14, marginLeft:15}}>{dados.logradouro}, {dados.numero} - {dados.bairro}</Text>
                    </View>
                    :<View></View>}
                    {dados.telefone?
                    <View style={{flexDirection:'row', alignItems:'center',marginBottom:20}}> 
                        <Image source={require('../images/paginadetalhes/contato.png')}/>
                        <Text style={{fontFamily:'Poppins-Regular', color:'#414141', fontSize:14, marginLeft:15}}>{dados.telefone}</Text>
                    </View>
                    :<View></View>}
                    {dados.site?
                    <View style={{flexDirection:'row', alignItems:'center',marginBottom:20}}> 
                        <Image source={require('../images/paginadetalhes/site.png')}/>
                        <Text style={{fontFamily:'Poppins-Regular', color:'#414141', fontSize:14, marginLeft:15}}>{dados.site}</Text>
                    </View>
                    :<View></View>}
                </View>
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
        fontSize:12,
        fontFamily:'Roboto-Bold', 
        position:'absolute',
        top:8,
        left:18,
        color:'#910046',
    },
    txtDistancia:{
        fontSize:18,
        fontFamily:'Roboto-Bold',    
        color:'#910046',
        marginLeft:15
    },
    
    slideView:{
        width: '100%',
        justifyContent: 'center',
        alignItems: 'center',
        marginBottom:15,     
    },
    carousel:{
        flex:1,
        overflow:'visible'
    },
    carouselImg:{
        alignSelf: 'center',
        width: Dimensions.get('window').width-Dimensions.get('window').width*0.20,
        height: Dimensions.get('window').height-Dimensions.get('window').height*0.70,
        borderRadius: 12,
        backgroundColor: 'rgba(0,0,0,0.5)',
        resizeMode:'cover',
        maxHeight:225 
    },
    carouselText:{
        padding: 15,
        color: '#FFF',
        position: 'absolute',
        bottom: 10,
        left: 2,
        fontWeight: 'bold'
    },
    carouselIcon:{
        position:'absolute',
        top: 15,
        right: 15,
    },
    img:{
        height:18,
        width:18,
    }
});