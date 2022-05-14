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


export default function App({dados}){
  const navigation = useNavigation();
  
  let title = dados.nome
  let data = dados.data
  let comentario = dados.comentario
  let estrelas = dados.avaliacao

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
console.log(dados)
  return (    
    <View style={{flex:1, alignItems:'center', marginVertical:10}}>
    <View style={{width:Dimensions.get('window').width-Dimensions.get('window').width*0.15, padding:10}}>
        <View style={{flexDirection:'row', justifyContent:'space-between', alignItems:'center'}}>
        <View style={{flexDirection:'row', alignItems:'center',}}>
        <View style={{marginRight:5, width:40, height:40}}>
        <Image style={{height:40, width:40, resizeMode:'contain'}} source={require('../images/paginadetalhes/avatar.png')}/>
        </View>
            <View>
                <Text style={estilos.txtTitle}>{title}</Text>
                <View style={{flexDirection:'row'}}>
                    <Image style={estilos.star} source={arrayestrela[0]}/>                                       
                    <Image style={estilos.star} source={arrayestrela[1]}/>                                       
                    <Image style={estilos.star} source={arrayestrela[2]}/>                                       
                    <Image style={estilos.star} source={arrayestrela[3]}/>                                       
                    <Image style={estilos.star} source={arrayestrela[4]}/>                                  
                </View>
            </View>
        </View>
            <View>
                <Text style={estilos.txtData}>{data}</Text>
            </View>
        </View>
            <View style={{flexDirection:'row', alignItems:'center'}}>
            <View style={{paddingVertical:10}}>
                <Text style={estilos.txtComantario}>
               {comentario}
                </Text>
            </View>            
        </View>

    <View style={{width:'100%', flexDirection:'row', justifyContent:'space-between', alignItems:"center"}}>
        <Text style={estilos.txtData}>Essa informação foi útil?</Text>
        <View style={{flexDirection:'row',}}>
            <TouchableOpacity style={estilos.miniBtn}>
                <Text style={estilos.txtMiniBtn}>Sim({dados.utilSim})</Text>
            </TouchableOpacity>
            <TouchableOpacity style={estilos.miniBtn}>
                <Text style={estilos.txtMiniBtn}>Não({dados.utilNao})</Text>
            </TouchableOpacity>
        </View>
    </View>
    </View>
    <Image source={require('../images/paginadetalhes/line.png')} style={{alignSelf:'center', resizeMode:'contain'}}/> 
</View>  
  );
};

const estilos = StyleSheet.create({
    txtTitle:{
        fontSize:17,
        fontFamily:'Roboto-Bold',
        color:'#000',
    },
    txtData:{
        fontSize:13,
        fontFamily:'Poppins-Regular',
        color:'#920046'
    },
    txtComantario:{
        fontSize:14,
        fontFamily:'Poppins-Regular',
        color:'#414141'
    },
    miniBtn:{
        backgroundColor:'rgba(146, 0 , 70, 0.28)',
        borderRadius:5,
        borderColor:'#920046',
        borderWidth:1,
        height:20,
        width:45,
        marginRight:10
    },
    txtMiniBtn:{
        flex:1,
        fontSize:10,
        textAlign:'center',
        textAlignVertical:'center',
        color:'#920046',
    }, 
    star:{
        width:20,
        height:20,
    }

});
