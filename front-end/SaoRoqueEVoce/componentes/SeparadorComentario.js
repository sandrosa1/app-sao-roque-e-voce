import React from 'react';
import {View, Image} from 'react-native';

export default function App() {
  return (
    <View>
      <Image
        source={require('../images/line.png')}
        style={{alignSelf: 'center', resizeMode: 'contain'}}
      />
    </View>
  );
}
