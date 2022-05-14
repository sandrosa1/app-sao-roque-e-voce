import React,{useState, useEffect} from 'react';
import {
  StyleSheet,
  Text,
  View,
  TouchableOpacity,
  ImageBackground,
  Image,
  Dimensions
} from 'react-native';
import { useNavigation } from '@react-navigation/native';


export default function App({data}){
  const navigation = useNavigation();
  
  let distancia = 5
  let estrelas = data?.estrelas  
  let custo = data?.custoMedio
 
  
  
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
    if(custo > 0.5){
         arraycusto[i] = require('../images/paginadetalhes/custo1.png')
        custo = custo - 1
    } else {            
         arraycusto[i] = require('../images/paginadetalhes/custo0.png')
    }
}
  
  return ( 
      <View style={estilos.container}>
        <TouchableOpacity style={{flex:1,}} onPress={() => navigation.navigate('PaginaDetalhes',{id:data.idApp})}>
        <View style={estilos.cardcontainer}>
            <ImageBackground source={{uri:data?.img1}}
            resizeMode='cover'
            style={estilos.cardbody}
            >
            <View style={estilos.bgCardDistancia}>
            </View>
            <View style={estilos.containerTxtDistancia}>
            <Text style={estilos.txtDistancia}>{distancia} KM</Text>
            </View>       
            <View style={estilos.bgInfo}>
            </View>
            <View style={estilos.containerInfo}>
                <View style={{width:'60%',}}>              
                <Text style={estilos.titleInfo}>{data?.nomeFantasia}</Text>
                </View>
                <View style={{width:'5%', paddingHorizontal:5}}>
                <Image resizeMode='stretch' source={require('../images/line2.png')}/>
                </View>
                <View style={{width:'35%', alignItems:'center'}}>
                    <View style={{flexDirection:'row',paddingVertical:2}}>                       
                        <Image style={estilos.img} source={arrayestrela[0]}/>                                       
                        <Image style={estilos.img} source={arrayestrela[1]}/>                                       
                        <Image style={estilos.img} source={arrayestrela[2]}/>                                       
                        <Image style={estilos.img} source={arrayestrela[3]}/>                                       
                        <Image style={estilos.img} source={arrayestrela[4]}/>
                    </View>
                    <View style={{flexDirection:'row',paddingVertical:2}}>                     
                        <Image style={estilos.img} source={arraycusto[0]}/>                                       
                        <Image style={estilos.img} source={arraycusto[1]}/>                                       
                        <Image style={estilos.img} source={arraycusto[2]}/>                                       
                        <Image style={estilos.img} source={arraycusto[3]}/>                                       
                        <Image style={estilos.img} source={arraycusto[4]}/>                                                        
                    </View>
                </View>
            </View>     
            </ImageBackground>
        </View>
    </TouchableOpacity>
</View>
  );
};

const estilos = StyleSheet.create({
    container:{
        flex:1, 
        alignItems:'center', 
        marginVertical:5,
   },
    cardcontainer:{
        flex:1,
        width: Dimensions.get('window').width-Dimensions.get('window').width*0.15,
        height: Dimensions.get('window').height-Dimensions.get('window').height*0.70,
        marginVertical:15,
        maxHeight:225             
    },
    cardbody:{
        flex:1,
        borderRadius:20,
        justifyContent:'space-between',
        alignItems:'center',
        overflow:'hidden',
        shadowColor:'#000', 
        elevation:8,   
        shadowOpacity:1,
        shadowOffset:{
            width:2,
            height:3,
        }
    },
    bgCardDistancia:{
        backgroundColor:'white',
        opacity:0.7,
        width:90,
        height:40,
        alignSelf:'flex-end',
        borderBottomLeftRadius:17,
        borderTopRightRadius:17,
   },
   containerTxtDistancia:{
       position:'absolute',
       right:0,
       width:90,
       height:40,
       justifyContent:'center',
    },
    txtDistancia:{
        fontSize:20,
        fontFamily:'Roboto-Bold',
        color:'#910046',
        textAlign:'center',
        textShadowColor:'#FFF',
        textShadowOffset:{width:1,height:1},
        textShadowRadius:2
    },
    bgInfo:{
        backgroundColor:'white',
        opacity:0.65,
        width:'100%',
        height:50,
        justifyContent:'flex-end',
        borderBottomLeftRadius:17,
        borderBottomRightRadius:17,
    },
    containerInfo:{
        flexDirection:'row',
        alignItems:'center',
        position:'absolute',
        height:50,
        bottom:0,
    },
    titleInfo:{   
        flex:1,
        textAlignVertical:'center',
        textAlign:'center',
        paddingHorizontal:10,
        fontFamily:'Roboto-Bold',
        color:'#000',
        fontSize:18,
        textAlign:'center',
        textShadowColor:'#FFF',
        textShadowOffset:{width:1,height:1},
        textShadowRadius:2,
    },
    img:{
        height:16,
        width:16,
    }
});
