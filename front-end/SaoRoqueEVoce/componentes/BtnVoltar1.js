import React from 'react';
import {StyleSheet, Text, View, TouchableHighlight} from 'react-native';
import {useNavigation} from '@react-navigation/native';

export default function App() {
  const navigation = useNavigation();
  return (
    <View style={{width: '100%', alignItems: 'center'}}>
      <TouchableHighlight
        onPress={() => navigation.goBack()}
        style={estilos.btn}>
        <Text
          style={{
            fontSize: 24,
            fontFamily: 'Poppins-Regular',
            color: '#CDCDCD',
            textAlign: 'center',
            padding: 4,
          }}>
          Voltar
        </Text>
      </TouchableHighlight>
    </View>
  );
}

const estilos = StyleSheet.create({
  btn: {
    width: '90%',
    height: 42,
    borderRadius: 33,
    backgroundColor: '#910046',
  },
});
