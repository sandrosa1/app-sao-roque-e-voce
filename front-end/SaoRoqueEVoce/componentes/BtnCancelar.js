import React from 'react';
import {StyleSheet, Text, View, TouchableOpacity} from 'react-native';
import {useNavigation} from '@react-navigation/native';

export default function App() {
  const navigation = useNavigation();
  return (
    <View style={{width: '100%', alignItems: 'center'}}>
      <TouchableOpacity style={estilos.btn} onPress={() => navigation.goBack()}>
        <Text
          style={{
            fontSize: 24,
            fontFamily: 'Poppins-Regular',
            color: '#910046',
            padding: 5,
          }}>
          Cancelar
        </Text>
      </TouchableOpacity>
    </View>
  );
}

const estilos = StyleSheet.create({
  btn: {
    Flex: 1,
    marginTop: 20,
    width: '75%',
    height: 45,
    borderRadius: 33,
    backgroundColor: '#CDCDCD',
    alignItems: 'center',
    justifyContent: 'center',
  },
});
