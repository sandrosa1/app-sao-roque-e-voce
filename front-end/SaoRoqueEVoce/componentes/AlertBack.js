import React,{useState} from 'react';
import {
Modal,
StyleSheet,
View,
Text,
Image,
TouchableOpacity
} from 'react-native';

export default function App(props){
    const [mostrar,setMostrar] = useState(true)
    const Fechar=()=> setMostrar(false)
    
  return (
      <View>
          <Modal visible={mostrar} transparent={true}>          
              <View style={estilos.background}>                 
              </View>          
          </Modal>
      </View>
  );
};

const estilos = StyleSheet.create({
    background:{
        backgroundColor:'rgba(0, 0 , 0, 0.8)',
        height:'100%'
},
  });
  
