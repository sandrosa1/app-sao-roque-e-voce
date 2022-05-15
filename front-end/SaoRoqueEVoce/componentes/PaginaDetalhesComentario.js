import React,{useState,useRef,useEffect} from 'react';
import {
  StyleSheet,
  Text,
  View,
  ScrollView,
  Image,
  Dimensions,
  TouchableOpacity,
  FlatList,
  TextInput,
  ActivityIndicator
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import NavPages from './NavPages';
import axios from "axios";
import AsyncStorage from '@react-native-async-storage/async-storage';
import CardComentarios from './CardComentarios';
import Carousel from 'react-native-snap-carousel';
import Globais from './Globais';
import { useIsFocused } from '@react-navigation/native';


export default function App({route}){
    const navigation = useNavigation();
    const [rank,setRank] = useState(0);
    const [custo,setCusto] = useState(0);
    const url = `http://www.racsstudios.com/api/v1/apps/${route.params.id}`;
    const [dados,setDados] = useState([]);
    const [comentarios,setComentarios] = useState();
    const [loading,setLoading] =useState(false);
    const [mostrarinput,setMostrarinput] =useState(false);
    const [mostrarcadastro,setMostrarCadastro] =useState(false);
    const isFocused = useIsFocused();
 
   
    useEffect(()=>{
        loadApi();
    },[]);

    async function loadApi(){
        if(loading) return;
        setLoading(true)

        const response = await axios.get(`${url}`);
        setDados(response.data);

        const responseComentario = await axios.get(`http://www.racsstudios.com/api/v1/comment/${route.params.id}/`);
        setComentarios(responseComentario.data.comments);

        setTimeout(()=>{setLoading(false);},800); 
        
    }
    
    let ranks = rank
    let custos = custo
    let estrelas = dados.estrelas
    
    let arrayrank= []
    let arraycusto= []
    let arrayestrela= []

    let i = 0
    for(i=0 ; i<5 ; i++){
        if(ranks > 0.5){
             arrayrank[i] = require('../images/paginadetalhes/star1.png')
            ranks = ranks - 1
        } else {
            arrayrank[i]= require('../images/paginadetalhes/star0.png')
        }
    }
    for(i=0 ; i<5 ; i++){
        if(custos > 0.5){
             arraycusto[i] = require('../images/paginadetalhes/custo1.png')
            custos = custos - 1
        } else {
            arraycusto[i]= require('../images/paginadetalhes/custo0.png')
        }
    }

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
  

    const {width: screenWidth, height: screenHeight} = Dimensions.get('window');

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

      useEffect(()=>{
        if(rank > 0 && Globais.dados?.usernome != null){
            setMostrarinput(true)
        } else if(rank> 0){
            setMostrarCadastro(true);
        }
    },[rank,isFocused]);


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

      let id = route.params.id
      let icon = route.params.icon
      let tipo = route.params.tipo

      useEffect(()=>{
        const dadosdousuario = async ()=>{           
            const json = await AsyncStorage.getItem("usuario");
            if(json){
                Globais.dados = JSON.parse(json)
            }     
        }        
        dadosdousuario()
        setRank(0);
        setCusto(0);
        setMostrarCadastro(false)
    },[isFocused]);
    

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
             
               <View style={estilos.slideView}>
                <Carousel
                style={estilos.carousel}
                ref={carouselRef}
                data={lista}
                renderItem={renderItem}
                sliderWidth={screenWidth}
                itemWidth={Dimensions.get('window').width-Dimensions.get('window').width*0.2}
                inactiveSlideOpacity={0.5}              
                />
                </View>
                <View style={{marginHorizontal:30}}>
                    <Text style={estilos.h1}>O que você achou desse local?</Text>
                    <Text style={estilos.txt}>
                        Escolha de 1 a 5 estrelas para classificar.
                    </Text>            
                </View>
              
             
                <View style={{marginHorizontal:30, flexDirection:'row', justifyContent:'space-between', alignItems:'center'}}>
                    <View style={{flexDirection:'row',}}>
                        <TouchableOpacity onPress={()=>setRank(1)}>
                            <Image style={estilos.star} source={arrayrank[0]}/>                                       
                        </TouchableOpacity>
                        <TouchableOpacity onPress={()=>setRank(2)}>
                            <Image style={estilos.star} source={arrayrank[1]}/>                                       
                        </TouchableOpacity>
                        <TouchableOpacity onPress={()=>setRank(3)}>
                            <Image style={estilos.star} source={arrayrank[2]}/>                                       
                        </TouchableOpacity>
                        <TouchableOpacity onPress={()=>setRank(4)}>
                            <Image style={estilos.star} source={arrayrank[3]}/>                                       
                        </TouchableOpacity>
                        <TouchableOpacity onPress={()=>setRank(5)}>
                            <Image style={estilos.star} source={arrayrank[4]}/>                               
                        </TouchableOpacity>
                    </View>

                    <View>
                        <TouchableOpacity onPress={() => navigation.navigate('PaginaDetalhes',{id: id})} style={[estilos.btn, {width:125, height:25, backgroundColor:'#920046', borderColor:'rgba(146, 0 , 70, 0.28)'}]}>                                
                                    <Text style={[estilos.txtBtn,{fontSize:15,paddingTop:0, color:'white'}]}>Informações</Text>  
                        </TouchableOpacity>
                    </View>
               </View>

                {mostrarcadastro ? 
                <View style={{marginHorizontal:30, marginVertical:20}}>
                    <View style={{flexDirection:'row', alignItems:'center'}}>
                        <Image style={estilos.star} source={require('../images/paginadetalhes/warning-purple.png')}/>
                        <Text style={{fontFamily:'Poppins-Regular', fontSize:16, color:'#000',}}>Entre ou cadastre-se para interagir!</Text>
                    </View>
                    <View style={{flexDirection:'row', alignItems:'center', justifyContent:'space-around', marginTop:20}}>
                        <TouchableOpacity style={estilos.btn} onPress={() => navigation.navigate('Login',{id: id, tipo: tipo, icon: icon})}>
                            <Text style={estilos.txtBtn}>ENTRAR</Text>
                        </TouchableOpacity>
                        <TouchableOpacity style={[estilos.btn,{backgroundColor:'#920046'}]} onPress={() => navigation.navigate('Cadastro',{id: id, tipo: tipo, icon: icon})}>
                            <Text style={[estilos.txtBtn, {color:'white'}]}>CADASTRAR</Text>
                        </TouchableOpacity>                        
                    </View>
                </View>:<View></View>}

                {mostrarinput ? 
                <View style={{marginHorizontal:30, marginVertical:20}}>
                    <View style={{flexDirection:'row', alignItems:'center'}}>
                        <Image style={estilos.star} source={require('../images/paginadetalhes/comentario-icon.png')}/>
                        <Text style={{fontFamily:'Poppins-SemiBold', fontSize:16, color:'#000', marginLeft:10}}>Deixe seu comentário</Text>
                    </View>
                    <View style={{flexDirection:'row', alignItems:'center', justifyContent:'space-around', marginTop:20}}>
                        <TextInput style={estilos.input} placeholder={'Conte-nos sua experiência. (opcional)'} placeholderTextColor={'#414141'} >
                        </TextInput>     
                    </View>
                    <View style={{flexDirection:'row', alignItems:'center', justifyContent:'space-around', marginTop:10}}>
                        <View>
                            <Text style={[estilos.txt,{bottom:1}]}>O que achou dos preços?</Text>
                        <View style={{flexDirection:'row',}}>
                        <TouchableOpacity onPress={()=>setCusto(1)}>
                        <Image style={estilos.star} source={arraycusto[0]}/>                                       
                        </TouchableOpacity>
                        <TouchableOpacity onPress={()=>setCusto(2)}>
                        <Image style={estilos.star} source={arraycusto[1]}/>                                       
                        </TouchableOpacity>
                        <TouchableOpacity onPress={()=>setCusto(3)}>
                        <Image style={estilos.star} source={arraycusto[2]}/>                                       
                        </TouchableOpacity>
                        <TouchableOpacity onPress={()=>setCusto(4)}>
                        <Image style={estilos.star} source={arraycusto[3]}/>                                       
                        </TouchableOpacity>
                        <TouchableOpacity onPress={()=>setCusto(5)}>
                        <Image style={estilos.star} source={arraycusto[4]}/>                               
                        </TouchableOpacity>
                        </View>
                        <View style={{flexDirection:'row', justifyContent:'space-between'}}>
                            <Text style={{color:'#910046'}}>Baixo</Text>
                            <Text style={{marginRight:6,color:'#910046'}}>Alto</Text>
                        </View>
                    </View>
                        <TouchableOpacity style={[estilos.btn,{width:120,height:40}]} onPress={() => navigation.navigate('Login',{id: id, tipo: tipo, icon: icon})}>
                            <Text style={estilos.txtBtn}>Avaliar</Text>
                        </TouchableOpacity>
                        </View>
                    </View>:<View></View>}
                
                {!loading?
                <View style={{marginVertical:10}}>
                    <View style={{flexDirection:'row', justifyContent:'space-between', marginHorizontal:30}}>
                        <View style={{flexDirection:'row'}}>
                            <Text style={estilos.h1}>Avaliações</Text>
                            <View style={{width:50}}>
                                <Image style={{marginLeft:5, width:21, height:21}} source={require('../images/paginadetalhes/minichat.png')}/>
                                <Text style={{fontSize:12,fontFamily:'Roboto-Bold',position:'absolute',top:8,left:18,color:'#000',}}>{dados.avaliacao}</Text>
                            </View>
                        </View>
                        <View style={{flexDirection:'row', alignItems:'center'}}>
                            <Text style={[estilos.h1,{fontSize:15, paddingRight:10, top:2}]}>{dados.estrelas}/5</Text>
                                <View style={{flexDirection:'row',}}>
                                    <Image style={estilos.ministar} source={arrayestrela[0]}/>                                       
                                    <Image style={estilos.ministar} source={arrayestrela[1]}/>                                       
                                    <Image style={estilos.ministar} source={arrayestrela[2]}/>                                       
                                    <Image style={estilos.ministar} source={arrayestrela[3]}/>                                       
                                    <Image style={estilos.ministar} source={arrayestrela[4]}/>                              
                                </View>
                        </View>
                    </View>
                    
                    <Image source={require('../images/paginadetalhes/line.png')} style={{alignSelf:'center', resizeMode:'contain'}}/> 
                    <View>           
                        <FlatList               
                        data={comentarios}
                        keyExtractor={item => String(item.idComment)}
                        renderItem={({item})=> <CardComentarios dados={item}/>}
                        />
                    </View></View>

                    :<View style={{marginTop:100,alignItems:'center', justifyContent: 'center'}}>
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
    },
    h1:{
        fontSize:18,
        fontFamily:'Poppins-SemiBold',
        color:'#000',
    },
    txt:{
        fontSize:13,
        fontFamily:'Poppins-Regular', 
        color:'#414141',
        bottom:8
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
        marginVertical:15,     
    },
    carousel:{
        flex:1,
        overflow:'visible'
    },
    carouselImg:{
        alignSelf: 'center',
        width: Dimensions.get('window').width-Dimensions.get('window').width*0.2,
        height: Dimensions.get('window').height-Dimensions.get('window').height*0.72,
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
    star:{
        height:30,
        width:30,
        marginRight:5,
    },
    ministar:{
        height:20,
        width:20
    },
    btn:{
        backgroundColor:'rgba(146, 0 , 70, 0.28)',
        borderRadius:5,
        borderColor:'#920046',
        borderWidth:1,
        height:45,
        width:140,
    },
    txtBtn:{
        flex:1,
        fontSize:17,
        fontFamily:'Poppins-SemiBold',
        textAlign:'center',
        textAlignVertical:'center',
        color:'#920046',
        paddingTop:5,
        letterSpacing:1,
    }, 
    input:{
        borderWidth:1,
        width: Dimensions.get('window').width-Dimensions.get('window').width*0.2,
        borderRadius:10,
        height:100,
        borderColor:'#920046',
        textAlignVertical:'top',
        paddingHorizontal:10,
    }
});