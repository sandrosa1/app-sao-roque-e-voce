import React,{useState,useRef,useEffect} from 'react';
import {
  StyleSheet,
  Text,
  View,
  ScrollView,
  Image,
  Dimensions,
  TouchableOpacity,
  FlatList
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import NavPages from './NavPages';
import axios from "axios";
import CardComentarios from './CardComentarios';
import Carousel from 'react-native-snap-carousel';

export default function App({route}){
    const navigation = useNavigation();
    const [rank,setRank] = useState(0);
    const url = `http://www.racsstudios.com/api/v1/apps/${route.params.id}`;
    const [dados,setDados] = useState([]);
    const [comentarios,setComentarios] = useState();
    const [loading,setLoading] =useState(false);
 
   
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

        setLoading(false);
        
    }
    
    console.log(comentarios)
    let ranks = rank
    let estrelas = dados.estrelas
    
    let arrayrank= []
    let arrayestrela= []

    let i = 0
    for(i=0 ; i<5 ; i++){
        if(ranks > 0.5){
             arrayrank[i] = require('../images/paginadetalhes/star1.png')
            ranks = ranks - 1
        } else {
            if(ranks <= 0.5 && ranks > 0){
             arrayrank[i] = require('../images/paginadetalhes/star2.png')
             ranks = 0
        } else {
            arrayrank[i]= require('../images/paginadetalhes/star0.png')
        }
    }}

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

      let icon = route.params.icon
      let tipo = route.params.tipo

  return (
    <View style={estilos.container}>
        <ScrollView showsVerticalScrollIndicator={false}>
            <View style={{flex:1}}>      
                <NavPages 
                    icon={route.params.icon}
                    title={route.params.tipo}/>
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
              
             
                <View style={{marginHorizontal:30, flexDirection:'row', justifyContent:'space-between'}}>
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
                <TouchableOpacity onPress={() => navigation.navigate('PaginaDetalhes',{id:route.params.idApp})}>
                            <View style={{flexDirection:'row'}}>
                                <Text style={{fontFamily:'Poppins-Regular', fontSize:18, color:'#910046',}}>Informações</Text>                               
                            </View>
                        </TouchableOpacity>
                </View>
               </View>

                <View style={{marginVertical:20}}>
                    <View style={{flexDirection:'row', justifyContent:'space-between', marginHorizontal:30}}>
                        <View style={{flexDirection:'row'}}>
                            <Text style={estilos.h1}>Avaliações</Text>
                            <View style={{width:50}}>
                                <Image style={{marginLeft:5, width:21, height:21}} source={require('../images/paginadetalhes/minichat.png')}/>
                                <Text style={{fontSize:12,fontFamily:'Roboto-Bold',position:'absolute',top:8,left:18,color:'#910046',}}>{dados.avaliacao}</Text>
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
                    </View> 

                    
                    
                    {/* <View style={{marginVertical:5}}>
                        <TouchableOpacity style={{flexDirection:'row', alignItems:'center', justifyContent:'center'}}>
                        <Image style={{marginHorizontal:10}} source={require('../images/paginadetalhes/mais.png')}/>
                        <Text style={[estilos.h1,{fontSize:14}]}>Carregar mais comentários</Text>
                        </TouchableOpacity>
                    </View> */}

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
        fontSize:18,
        fontFamily:'Poppins-Regular',
        color:'#910046',
    },
    txt:{
        fontSize:13,
        fontFamily:'Poppins-Light', 
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
    }
});