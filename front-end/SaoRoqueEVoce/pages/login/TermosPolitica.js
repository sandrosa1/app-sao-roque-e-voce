import React from 'react';
import {StyleSheet, Text, View,ScrollView} from 'react-native';
import Header from '../../componentes/Header';

export default function App({route}) {
  let title = route.params.title;
  let text = route.params.text;

  return (
    <View style={estilos.container}>
      <ScrollView>
      <Header space={true} goingback={true} />
      <View style={{flex: 4, paddingHorizontal: 30}}>
        <Text style={estilos.h1}>{title}</Text>
        <Text style={estilos.txt}>{text}</Text>
      </View>
      </ScrollView>
    </View>
  );
}

const estilos = StyleSheet.create({
  container: {
    flex: 1,
  },
  h1: {
    fontSize: 24,
    fontFamily: 'Poppins-Regular',
    color: '#910046',
    paddingBottom: 10,
  },
  txt: {
    fontSize: 16,
    fontFamily: 'Poppins-Regular',
    color: '#414141',
  },
});
