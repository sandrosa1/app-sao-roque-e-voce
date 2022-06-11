import React from 'react';
import {StyleSheet, Text, TouchableOpacity, Image} from 'react-native';
import {useNavigation} from '@react-navigation/native';

export default function App(props) {
  const navigation = useNavigation();

  let icon = props.icon;
  let title = props.title;

  return (
    <TouchableOpacity style={estilos.containerIcon}>
      <Image style={estilos.imgMenu} source={props.icon} />
      <Text style={estilos.txtMenu}>{props.title}</Text>
    </TouchableOpacity>
  );
}

const estilos = StyleSheet.create({
  containerIcon: {
    height: 70,
    width: 80,
    alignItems: 'center',
  },
  txtMenu: {
    paddingTop: 10,
    fontFamily: 'Roboto-Regular',
    textAlign: 'center',
    fontSize: 12,
    color: '#111',
  },
  imgMenu: {
    height: 40,
    width: 40,
    resizeMode: 'contain',
  },
});
