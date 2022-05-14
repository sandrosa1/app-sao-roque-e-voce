import React from 'react';
import {
  StyleSheet,
  Text,
  View,
  TouchableOpacity,
  Image,
  Dimensions
} from 'react-native';
import { useNavigation } from '@react-navigation/native';


export default function App(props){
  const navigation = useNavigation();
  
  let title = props.title
  let data = props.data
  let comentario = props.comentario
  let estrelas = props.estrelas

  let arrayestrela = []

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

  return (    
    <View style={{alignItems:'center', marginVertical:10}}>
    <View style={{width:Dimensions.get('window').width-Dimensions.get('window').width*0.15, padding:10}}>
        <View style={{flexDirection:'row', justifyContent:'space-between', alignItems:'center'}}>
            <View>
                <Text style={estilos.txtTitle}>{props.title}</Text>
                <View style={{flexDirection:'row'}}>
                    <Image style={estilos.star} source={arrayestrela[0]}/>                                       
                    <Image style={estilos.star} source={arrayestrela[1]}/>                                       
                    <Image style={estilos.star} source={arrayestrela[2]}/>                                       
                    <Image style={estilos.star} source={arrayestrela[3]}/>                                       
                    <Image style={estilos.star} source={arrayestrela[4]}/>  
                </View>
            </View>
            <View>
                <Text style={estilos.txtData}>{props.data}</Text>
            </View>
            </View>
            <View style={{flexDirection:'row', alignItems:'center', justifyContent:'space-between'}}>
            <View style={{flex:1, paddingVertical:10, paddingRight:15}}>
                <Text style={estilos.txtComantario}>
               {props.comentario}
                </Text>
            </View>
            <View >
                <TouchableOpacity>
                <Image style={{width:30, height:30, resizeMode:'contain'}} source={require('../images/configuracao/excluir.png')}/>
                </TouchableOpacity>
            </View>
        </View>
    </View>
    <Image source={require('../images/line.png')} style={{alignSelf:'center', resizeMode:'contain'}}/> 
</View>  
  );
};

const estilos = StyleSheet.create({
    txtTitle:{
        fontSize:18,
        fontFamily:'Roboto-Bold',
        color:'#000',
    },
    txtData:{
        fontSize:12,
        fontFamily:'Poppins-Regular',
        color:'#920046'
    },
    txtComantario:{
        fontSize:14,
        fontFamily:'Poppins-Regular',
        color:'#414141'
    },
    star:{
        width:20,
        height:20,
    },
});
