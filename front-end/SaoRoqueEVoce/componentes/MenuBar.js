import React from 'react';
import {StyleSheet, Text, TouchableOpacity, Image} from 'react-native';
import {useNavigation} from '@react-navigation/native';

export default function App(props) {
  const navigation = useNavigation();
  let nome = props.nome;
  let icon = props.icon;
  let pesquisa = props.pesquisa;
  let busca = props.busca;
  let page = '';
  let prop = '';

  if (
    pesquisa == 'Turismo' ||
    pesquisa == 'Gastronomia' ||
    pesquisa == 'Hospedagem' ||
    pesquisa == 'Eventos' ||
    pesquisa == 'Comércio'
  ) {
    page = 'Segmento';
    prop = {tipo: nome, icon: icon, pesquisa: pesquisa, busca: busca};
  } else {
    page = pesquisa;
  }

  return (
    <TouchableOpacity
      style={estilos.menuIcon}
      onPress={() => navigation.navigate(page, prop)}>
      <Image style={estilos.img} source={props.icon} />
      <Text style={estilos.txtIcon}>{props.nome}</Text>
    </TouchableOpacity>
  );
}

const estilos = StyleSheet.create({
  menuIcon: {
    height: 70,
    alignItems: 'center',
    paddingHorizontal:15
  },
  txtIcon: {
    fontSize: 12,
    textAlign: 'center',
    fontFamily: 'Roboto-Bold',
    color: '#555',
  },
  img: {
    height: 35,
    width: 35,
    resizeMode: 'contain',
  },
});
