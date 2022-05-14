import React from 'react';
import {
  StyleSheet,
  Text,
  TouchableOpacity,
  Image
} from 'react-native';
import { useNavigation } from '@react-navigation/native';


export default function App(props){
  const navigation = useNavigation();
  let nome = props.nome
  let icon = props.icon
  let nav = props.nav
  return (
    <TouchableOpacity style={estilos.menuIcon} onPress={() => navigation.navigate(props.nav)}>
        <Image style={estilos.img} source={props.icon}/>
        <Text style={estilos.txtIcon}>{props.nome}</Text>
    </TouchableOpacity>
  );
};

const estilos = StyleSheet.create({
menuIcon:{
    height:70,
    width:87,
    alignItems:'center',
},
txtIcon:{
    fontSize:12,
    textAlign:'center',
    fontFamily:'Roboto-Bold',
    color:'#555'
},
img:{
    height:35,
    width:35,
    resizeMode:'contain'
}

});

