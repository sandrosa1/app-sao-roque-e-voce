import React from 'react';
import {
  StyleSheet,
  Text,
  View,
  TouchableOpacity,
  Image,TextInput
} from 'react-native';
import { useNavigation } from '@react-navigation/native';


export default function App(props){
 
  function Busca(){
    if (props.title){
      return 'O que você procura em '+ props.title + '?'
    } else {
      return 'O que você procura?'
    }
  }
  const navigation = useNavigation();
  return (
    <View style={{paddingHorizontal:40, flexDirection:'row', alignItems:'center'}}>
    <View style={estilos.container}>
    <TextInput
    placeholder={Busca()}
    placeholderTextColor={'#8E8E8E'}
    style={estilos.input}
    >
    </TextInput>
      </View>
        <TouchableOpacity style={{position:'absolute', alignSelf:'center', right:50, padding:10}}>
            <Image style={estilos.img} source={require('../images/buscar.png')}/>
            </TouchableOpacity>
    </View>
  );
};

const estilos = StyleSheet.create({
    input:{
        width:'85%',
        height:50,               
        fontSize:14,
        padding:13,
        borderColor:'#E7E7E7',
        backgroundColor:'#E7E7E7',
        fontFamily:'Poppins-Regular',
        borderRadius:8,
        color:'#333'
    },
    container:{
      width:'100%',
      height:50,         
      borderColor:'#E7E7E7',
      backgroundColor:'#E7E7E7',
      fontFamily:'Poppins-Regular',
      borderRadius:8
    },
    img:{
      height:25,
      width:25,
      resizeMode:'contain'
    }, 
});

