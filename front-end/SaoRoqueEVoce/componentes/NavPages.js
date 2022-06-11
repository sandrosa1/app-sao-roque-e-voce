import React from 'react';
import {StyleSheet, Text, View, TouchableOpacity, Image} from 'react-native';
import {useNavigation} from '@react-navigation/native';

export default function App(props) {
  const navigation = useNavigation();

  let icon = props.icon;
  let title = props.title;

  return (
    <View style={estilos.container}>
      <View style={estilos.icon}>
        <TouchableOpacity onPress={() => navigation.goBack()}>
          <Image
            style={{height: 30, width: 30}}
            source={require('../images/goingback.png')}
          />
        </TouchableOpacity>
      </View>
      <View style={{flexDirection: 'row', marginLeft: 10, marginTop: 10}}>
        <Image style={estilos.img} source={props.icon} />
        <Text style={estilos.h1}>{props.title}</Text>
      </View>
    </View>
  );
}

const estilos = StyleSheet.create({
  container: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    marginTop: 10,
  },
  icon: {
    position: 'absolute',
    left: 15,
    padding: 15,
  },
  h1: {
    marginLeft: 10,
    fontSize: 24,
    fontFamily: 'Poppins-SemiBold',
    color: '#910046',
    textShadowColor: '#000',
    textShadowOffset: {width: 0.2, height: 0.2},
    textShadowRadius: 2,
  },
  img: {
    height: 35,
    width: 35,
    resizeMode: 'contain',
  },
});
